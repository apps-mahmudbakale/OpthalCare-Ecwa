<?php

namespace App\Imports;

use App\Models\ICD10;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ICD10Import implements ToCollection
{
  /**
   * @param Collection $collection
   */
  public function collection(Collection $collection)
  {
    foreach ($collection as $row) {
      // Assuming the columns are in order: [number, group, name]
      $number = $row[0]; // First column
      $group = $row[1];  // Second column
      $name  = $row[2];  // Third column

      ICD10::create([
        'number' => $number,
        'group'  => $group,
        'name'   => $name,
      ]);
    }
  }
}
