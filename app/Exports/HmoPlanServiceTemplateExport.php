<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class HmoPlanServiceTemplateExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            [
                'category' => 'laboratory',
                'service_name' => 'Full Blood Count',
                'price' => '2500'
            ],
            [
                'category' => 'pharmacy',
                'service_name' => 'Paracetamol 500mg',
                'price' => '500'
            ],
            [
                'category' => 'consultations',
                'service_name' => 'General Practice',
                'price' => '3000'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'category',
            'service_name',
            'price'
        ];
    }

    public function title(): string
    {
        return 'HMO Service Template';
    }
}
