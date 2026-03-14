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
            $serviceName = strtolower(trim($row['service_name'] ?? ''));
            $priceRaw = $row['price'] ?? 0;

            if (empty($categoryRaw) || empty($serviceName)) {
                continue;
            }

            // Look up the service ID based on the category cache
            if (!isset($this->cache[$categoryRaw])) {
                continue; // Category not recognized
            }

            $serviceId = $this->cache[$categoryRaw][$serviceName] ?? null;

            if (!$serviceId) {
                continue; // Service not found inside this category
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
}
