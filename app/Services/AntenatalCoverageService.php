<?php

namespace App\Services;

use App\Models\AntenatalPackageUsage;
use App\Models\AntenatalRecord;

class AntenatalCoverageService
{
    /**
     * Map billing service categories to package service types.
     */
    protected array $categoryMap = [
        'laboratory'    => 'laboratory',
        'radiology'     => 'imaging',
        'procedure'     => 'procedure',
        'procedures'    => 'procedure',
        'pharmacy'      => 'pharmacy',
        'consultations' => 'consultation',
        'consultation'  => 'consultation',
    ];

    /**
     * Check if a service is covered by the patient's active antenatal package.
     * Returns the enrollment record if covered and within qty limit, null otherwise.
     */
    public function getCoverage(int $patientId, string $billingCategory, int $serviceId): ?array
    {
        // Normalize to lowercase to handle inconsistent casing across controllers
        $billingCategory = strtolower($billingCategory);

        $serviceType = $this->categoryMap[$billingCategory] ?? null;
        if (!$serviceType) return null;

        // Find the patient's most recent active antenatal enrollment with a package
        $enrollment = AntenatalRecord::where('patient_id', $patientId)
            ->whereNotNull('enrolment_package_id')
            ->with('enrolmentPackage')
            ->latest()
            ->first();

        if (!$enrollment || !$enrollment->enrolmentPackage) return null;

        $package = $enrollment->enrolmentPackage;

        // Check package expiry
        if ($package->expiry_date && $package->expiry_date->isPast()) return null;

        // Find the service in the package's covered services
        $covered = collect($package->services_covered ?? [])
            ->first(fn($s) => $s['type'] === $serviceType && (int)$s['id'] === $serviceId);

        if (!$covered) return null;

        $allowedQty = (int)($covered['qty'] ?? 1);

        // Count how many times this service has already been used under this enrollment
        $usedQty = AntenatalPackageUsage::where('patient_id', $patientId)
            ->where('antenatal_record_id', $enrollment->id)
            ->where('service_type', $serviceType)
            ->where('service_id', $serviceId)
            ->count();

        if ($usedQty >= $allowedQty) return null; // qty exhausted

        return [
            'enrollment'   => $enrollment,
            'package'      => $package,
            'service_type' => $serviceType,
            'service_id'   => $serviceId,
            'used'         => $usedQty,
            'allowed'      => $allowedQty,
        ];
    }

    /**
     * Record a usage entry after a covered service is billed.
     */
    public function recordUsage(array $coverage, int $billingId): void
    {
        AntenatalPackageUsage::create([
            'patient_id'          => $coverage['enrollment']->patient_id,
            'antenatal_record_id' => $coverage['enrollment']->id,
            'package_id'          => $coverage['package']->id,
            'service_type'        => $coverage['service_type'],
            'service_id'          => $coverage['service_id'],
            'billing_id'          => $billingId,
        ]);
    }
}
