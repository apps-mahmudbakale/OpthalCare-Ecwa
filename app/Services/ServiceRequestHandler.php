<?php

namespace App\Services;

use App\Models\Billing;
use App\Services\AntenatalCoverageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ServiceRequestHandler
{
  // Cache service type detection for 10 minutes to avoid repeated DB hits
  protected const SERVICE_TYPE_CACHE_TTL = 600;

  // Map of service categories => model classes (faster than looping every time)
  protected array $serviceModels = [
    'Speciality'  => \App\Models\Speciality::class,
    'Drug'        => \App\Models\Drug::class,
    'Laboratory'  => \App\Models\Laboratory::class,
    'Radiology'   => \App\Models\Radiology::class,
    'Procedure'   => \App\Models\Procedure::class,
    'Bed'         => \App\Models\Bed::class,
    'Antenatal'   => \App\Models\Antenatal::class,
    'Opticals'    => \App\Models\Antenatal::class,
    // Add new ones here easily
  ];

  /**
   * Handle creation of a billing record for a requested service.
   */
  public function handleServiceRequest(
    string $serviceName,
    int $patientId,
    string $serviceCategory,
    string $kind,
    string $billingRef,
    ?int $qty = null,
    ?float $customAmount = null,
    ?string $createdFrom = 'manual',
    ?string $notes = null,
    ?int $serviceId = null
  ): ?Billing {
    $qty = $qty ?? 1;

    // Handle miscellaneous charges (no service model lookup needed)
    if ($serviceCategory === 'miscellaneous') {
      if ($customAmount === null) {
        throw new \InvalidArgumentException('Custom amount is required for miscellaneous charges');
      }

      $status  = 0;
      $plan_id = null;

      // Fetch Patient to check HMO Plan
      $patient = \App\Models\Patient::with('hmoPlan')->find($patientId);
      if ($patient && $patient->hmoPlan) {
        $plan_id = $patient->hmo_plan_id;
      }

      return Billing::create([
        'service'     => 'Miscellaneous:' . $serviceName,
        'service_id'  => $serviceId ?? 0, // Use provided service ID or 0 for misc charges
        'user_id'     => $patientId,
        'quantity'    => $qty,
        'amount'      => $customAmount * $qty,
        'bill_ref'    => $billingRef,
        'payer_id'    => Auth::id(),
        'plan_id'     => $plan_id,
        'status'      => $status,
        'created_by'  => Auth::id(),
        'created_from' => $createdFrom,
        'creation_notes' => $notes,
        'created_ip'  => request()->ip(),
      ]);
    }

    // If service ID is provided, use it directly for more accurate lookup
    if ($serviceId) {
      $modelClass = $this->resolveServiceModelByCategory($serviceCategory);
      if (!$modelClass) {
        return null; // Service category not supported
      }

      // Fetch service by ID (more reliable than name)
      $service = $modelClass::select($this->getRequiredColumns($modelClass))
        ->where('id', $serviceId)
        ->first();

      if (!$service) {
        return null; // Service not found
      }
    } else {
      // Fallback to name-based lookup (legacy support)
      $modelClass = $this->resolveServiceModel($serviceName);
      if (!$modelClass) {
        return null; // Service not found in any registered model
      }

      // Fetch service with only needed columns
      $service = $modelClass::select($this->getRequiredColumns($modelClass))
        ->where('name', $serviceName)
        ->first();

      if (!$service) {
        return null;
      }
    }

    $amount = $this->calculateAmount($modelClass, $kind, $service, $qty);

    $status  = 0;
    $plan_id = null;

    // Fetch Patient to check HMO Plan mappings
    $patient = \App\Models\Patient::with('hmoPlan')->find($patientId);

    if ($patient && $patient->hmoPlan) {
        $plan_id = $patient->hmo_plan_id;

        $hmoService = \App\Models\HmoService::where('plan_id', $plan_id)
            ->where('type', $serviceCategory)
            ->where('service_id', $service->id)
            ->first();

        if ($hmoService) {
            $amount = $hmoService->price * $qty;
        }
    }

    // ── Antenatal package coverage check ──────────────────────────────────
    $coverage = null;
    $coverageService = new AntenatalCoverageService();
    $coverage = $coverageService->getCoverage($patientId, $serviceCategory, $service->id);

    \Illuminate\Support\Facades\Log::info('Antenatal coverage check', [
        'patient_id'      => $patientId,
        'serviceCategory' => $serviceCategory,
        'service_id'      => $service->id,
        'service_name'    => $serviceName,
        'covered'         => $coverage ? true : false,
    ]);

    if ($coverage) {
        $amount = 0;
        $status = 1;
    }
    // ──────────────────────────────────────────────────────────────────────

    $billing = Billing::create([
      'service'     => $serviceCategory . ':' . $serviceName,
      'service_id'  => $service->id,
      'user_id'     => $patientId,
      'quantity'    => $qty,
      'amount'      => $amount,
      'bill_ref'    => $billingRef,
      'payer_id'    => Auth::id(),
      'plan_id'     => $plan_id,
      'status'      => $status,
      'created_by'  => Auth::id(),
      'created_from' => $createdFrom,
      'creation_notes' => $notes,
      'created_ip'  => request()->ip(),
    ]);

    // Record usage so qty limit is tracked
    if ($coverage) {
        $coverageService->recordUsage($coverage, $billing->id);
    }

    return $billing;
  }

  /**
   * Resolve which Eloquent model owns this service name (cached).
   */
  protected function resolveServiceModel(string $serviceName): ?string
  {
    $cacheKey = 'service_model:' . md5(strtolower($serviceName));

    return Cache::remember($cacheKey, self::SERVICE_TYPE_CACHE_TTL, function () use ($serviceName) {
      foreach ($this->serviceModels as $modelClass) {
        if (!class_exists($modelClass)) {
          continue;
        }

        // Use exists() — much lighter than count() or first()
        if ($modelClass::where('name', $serviceName)->exists()) {
          return $modelClass;
        }
      }

      return null;
    });
  }

  /**
   * Resolve model class by service category (more reliable than name lookup).
   */
  protected function resolveServiceModelByCategory(string $serviceCategory): ?string
  {
    $categoryModelMap = [
      'consultations' => \App\Models\Speciality::class,
      'laboratory'    => \App\Models\Laboratory::class,
      'radiology'     => \App\Models\Radiology::class,
      'pharmacy'      => \App\Models\Drug::class,
      'procedure'     => \App\Models\Procedure::class,
      'ophthicals'    => \App\Models\Antenatal::class,
      'opticals'      => \App\Models\Antenatal::class,
      'bed'           => \App\Models\Bed::class,
      'antenatal'     => \App\Models\Antenatal::class,
    ];

    return $categoryModelMap[$serviceCategory] ?? null;
  }

  /**
   * Define minimal columns needed per model to avoid SELECT *
   */
  protected function getRequiredColumns(string $modelClass): array
  {
    $columns = ['id', 'name', 'price'];

    if (in_array($modelClass, [
      \App\Models\Speciality::class,
      // add others that have follow_up_price
    ])) {
      $columns[] = 'follow_up_price';
    }

    return $columns;
  }

  /**
   * Calculate amount with proper type hints and logic grouping
   */
  protected function calculateAmount(string $modelClass, string $kind, $service, int $qty): float
  {
    // Follow-up pricing takes precedence over regular price
    if ($kind === 'follow-up' && isset($service->follow_up_price)) {
      return $service->follow_up_price * $qty;
    }

    // Default: regular price
    return ($service->price ?? 0) * $qty;
  }

  /**
   * Check if a service has already been billed for a given reference
   */
  public function isBilled(int $serviceId, string $serviceName, string $ref): string
  {
    $billing = Billing::where('service_id', $serviceId)
      ->where('service', $serviceName)
      ->where('bill_ref', $ref)
      ->value('status'); // Only fetch status column

    return $billing !== null ? (string) $billing : '0';
  }
}
