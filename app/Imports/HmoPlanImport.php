<?php

namespace App\Imports;

use App\Models\HmoPlan;
use App\Models\HmoGroup;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HmoPlanImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        // Pre-fetch all HMO Groups to map group names to their IDs
        $hmoGroups = HmoGroup::pluck('id', 'name')->mapWithKeys(function ($id, $name) {
            return [strtolower(trim($name)) => $id];
        })->toArray();

        foreach ($rows as $row) {
            // Check if the plan name is present
            if (empty($row['name'])) {
                continue;
            }

            // Map the HMO group name to its ID
            $groupName = strtolower(trim($row['hmo_group_name'] ?? ''));
            $hmo_id = $hmoGroups[$groupName] ?? null;

            // If the group wasn't found, you may decide to skip or create it
            // For safety, let's only import if the HMO Group actually exists
            if (!$hmo_id) {
                continue;
            }

            // Clean amounts (handle possible strings like "5,000" or empty values)
            $enrollment = preg_replace('/[^0-9.]/', '', $row['enrollment_amount'] ?? '0');
            $signup = preg_replace('/[^0-9.]/', '', $row['signup_amount'] ?? '0');

            // Determine if it is insurance (accepts 1, 0, 'yes', 'no', 'true', 'false')
            $is_insurance = filter_var($row['is_insurance'] ?? false, FILTER_VALIDATE_BOOLEAN);

            HmoPlan::create([
                'hmo_id' => $hmo_id,
                'name' => trim($row['name']),
                'enrollment_amount' => $enrollment !== '' ? (float)$enrollment : 0,
                'signup_amount' => $signup !== '' ? (float)$signup : 0,
                'max_no' => !empty($row['max_members']) ? (int)$row['max_members'] : null,
                'is_insurance' => $is_insurance,
            ]);
        }
    }
}
