<?php

namespace App\Imports;

use App\Models\Antenatal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AntenatalImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Antenatal([
            'name' => $row['name'],
            'price' => $row['price'],
            'qty' => $row['qty'],
            'dispense_qty' => $row['dispense_qty'],
        ]);
    }
}
