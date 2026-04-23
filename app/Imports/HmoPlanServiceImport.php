<?php

namespace App\Imports;

use App\Models\HmoService;
use App\Models\Drug;
use App\Models\Laboratory;
use App\Models\Procedure;
use App\Models\Radiology;
use App\Models\Bed;
use App\Models\Speciality;
use App\Models\Antenatal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HmoPlanServiceImport implements ToCollection, WithHeadingRow
{
    protected $planId;

    // Caches to avoid querying for every row
    protected $cache = [];

    public function __construct($planId)
    {
        $this->planId = $planId;

        // Preload maps: lowercased service name => ID
        $this->cache['pharmacy'] = Drug::pluck('id', 'name')->mapWithKeys(fn($id, $name) => [strtolower(trim($name)) => $id])->toArray();
        $this->cache['laboratory'] = Laboratory::pluck('id', 'name')->mapWithKeys(fn($id, $name) => [strtolower(trim($name)) => $id])->toArray();
        $this->cache['procedure'] = Procedure::pluck('id', 'name')->mapWithKeys(fn($id, $name) => [strtolower(trim($name)) => $id])->toArray();
        $this->cache['procedures'] = $this->cache['procedure']; // Alias
        $this->cache['radiology'] = Radiology::pluck('id', 'name')->mapWithKeys(fn($id, $name) => [strtolower(trim($name)) => $id])->toArray();
        $this->cache['admissions'] = Bed::pluck('id', 'name')->mapWithKeys(fn($id, $name) => [strtolower(trim($name)) => $id])->toArray();
        $this->cache['admission'] = $this->cache['admissions']; // Alias
        $this->cache['consultations'] = Speciality::pluck('id', 'name')->mapWithKeys(fn($id, $name) => [strtolower(trim($name)) => $id])->toArray();
        $this->cache['consultation'] = $this->cache['consultations']; // Alias
        $this->cache['ophthicals'] = Antenatal::pluck('id', 'name')->mapWithKeys(fn($id, $name) => [strtolower(trim($name)) => $id])->toArray();
        $this->cache['antenatal'] = $this->cache['ophthicals']; // Alias
    }

    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $categoryRaw = strtolower(trim($row['category'] ?? ''));
            $serviceName = trim($row['service_name'] ?? '');
            $serviceNameLower = strtolower($serviceName);
            $priceRaw = $row['price'] ?? 0;

            if (empty($categoryRaw) || empty($serviceName)) {
                continue;
            }

            // Look up the service ID based on the category cache
            if (!isset($this->cache[$categoryRaw])) {
                continue; // Category not recognized
            }

            $serviceId = $this->cache[$categoryRaw][$serviceNameLower] ?? null;

            // If service not found, create it based on category
            if (!$serviceId) {
                $serviceId = $this->createServiceByCategory($categoryRaw, $serviceName, $priceRaw);
                
                if (!$serviceId) {
                    continue; // Failed to create service
                }

                // Update cache with newly created service
                $this->cache[$categoryRaw][$serviceNameLower] = $serviceId;
            }

            $price = (float) preg_replace('/[^0-9.]/', '', $priceRaw);

            // Update or create the Hmo Service constraint
            HmoService::updateOrCreate(
                [
                    'plan_id' => $this->planId,
                    'type' => $categoryRaw,
                    'service_id' => $serviceId,
                ],
                [
                    'price' => $price,
                ]
            );
        }
    }

    /**
     * Create a service based on category if it doesn't exist
     *
     * @param string $category
     * @param string $serviceName
     * @param mixed $price
     * @return int|null
     */
    protected function createServiceByCategory($category, $serviceName, $price)
    {
        $price = (float) preg_replace('/[^0-9.]/', '', $price);

        try {
            switch ($category) {
                case 'laboratory':
                    $service = Laboratory::create([
                        'name' => $serviceName,
                        'price' => $price,
                        'category_id' => null, // Set to null or default category if needed
                        'template_id' => null,
                    ]);
                    return $service->id;

                case 'procedure':
                case 'procedures':
                    $service = Procedure::create([
                        'name' => $serviceName,
                        'price' => $price,
                        'category_id' => null,
                    ]);
                    return $service->id;

                case 'radiology':
                    $service = Radiology::create([
                        'name' => $serviceName,
                        'price' => $price,
                        'category_id' => null,
                        'template_id' => null,
                    ]);
                    return $service->id;

                case 'pharmacy':
                    $service = Drug::create([
                        'name' => $serviceName,
                        'price' => $price,
                        'quantity' => 0,
                        'category_id' => null,
                        'threshold' => 0,
                        'is_active' => true,
                        'store_id' => null,
                        'expiry_date' => null,
                    ]);
                    return $service->id;

                case 'admissions':
                case 'admission':
                    $service = Bed::create([
                        'name' => $serviceName,
                        'price' => $price,
                    ]);
                    return $service->id;

                case 'consultations':
                case 'consultation':
                    $service = Speciality::create([
                        'name' => $serviceName,
                        'price' => $price,
                    ]);
                    return $service->id;

                case 'ophthicals':
                case 'antenatal':
                    $service = Antenatal::create([
                        'name' => $serviceName,
                        'price' => $price,
                    ]);
                    return $service->id;

                default:
                    return null;
            }
        } catch (\Exception $e) {
            // Log error if needed
            \Log::error("Failed to create service: {$serviceName} in category: {$category}. Error: " . $e->getMessage());
            return null;
        }
    }
}
