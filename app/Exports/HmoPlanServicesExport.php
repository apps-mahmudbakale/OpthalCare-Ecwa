<?php

namespace App\Exports;

use App\Models\HmoService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class HmoPlanServicesExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $planId;

    public function __construct($planId)
    {
        $this->planId = $planId;
    }

    public function query()
    {
        return HmoService::query()->where('plan_id', $this->planId);
    }

    public function headings(): array
    {
        return [
            'Service Name',
            'Category',
            'Base Price (₦)',
            'HMO Price (₦)',
            'Difference (₦)'
        ];
    }

    public function map($hmoService): array
    {
        $diff = $hmoService->price - $hmoService->service_base_price;
        
        return [
            $hmoService->service_name,
            ucfirst($hmoService->type),
            number_format($hmoService->service_base_price, 2, '.', ''),
            number_format($hmoService->price, 2, '.', ''),
            number_format($diff, 2, '.', '')
        ];
    }
}
