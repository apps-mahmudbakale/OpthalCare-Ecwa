<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ICD10Export implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
}
