<?php

namespace App\Imports;

use App\Models\Bed;
use App\Models\Ward;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BedImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
      // Fetch all categories and map them into an associative array
      $wards = Ward::pluck('id', 'name')->toArray();

      foreach ($rows as $row) {
        // Check if the category exists, if not, skip this row
        if (!isset($wards[$row[1]])) {
          continue;
        }

        // Use the create method for inserting each row with mass assignment
        Bed::create([
          'name' => $row[0],
          'ward_id' => $wards[$row[1]], // Use the pre-fetched category ID
          'price' => $row[2],
          'available' => $row[3],
        ]);
      }
    }
}
