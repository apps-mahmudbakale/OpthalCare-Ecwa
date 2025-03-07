<?php

namespace App\Imports;

use App\Models\LabCategory;
use App\Models\Laboratory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class LabTestImport implements ToCollection
{
  /**
   * @param Collection $collection
   */
  public function collection(Collection $rows)
  {
    // Fetch all categories and map them into an associative array
    $categories = LabCategory::pluck('id', 'name')->toArray();

    foreach ($rows as $row) {
      // Check if the category exists, if not, skip this row
      if (!isset($categories[$row[1]])) {
        continue;
      }

      // Use the create method for inserting each row with mass assignment
      Laboratory::create([
        'name' => $row[0],
        'category_id' => $categories[$row[1]], // Use the pre-fetched category ID
        'price' => $row[2]
      ]);
    }
  }
}

