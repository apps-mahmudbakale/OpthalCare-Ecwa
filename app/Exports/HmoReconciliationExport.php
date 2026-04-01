<?php

namespace App\Exports;

use App\Models\Billing;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class HmoReconciliationExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $planId;
    protected $dateFrom;
    protected $dateTo;
    protected $status;

    public function __construct($planId = null, $dateFrom = null, $dateTo = null, $status = null)
    {
        $this->planId   = $planId;
        $this->dateFrom = $dateFrom;
        $this->dateTo   = $dateTo;
        $this->status   = $status;
    }

    public function query()
    {
        $query = Billing::query()
            ->whereNotNull('plan_id')
            ->with(['patient.user', 'hmoPlan.hmo']);

        if ($this->planId) {
            $query->where('plan_id', $this->planId);
        }
        if (!is_null($this->status)) {
            $query->where('status', $this->status);
        }
        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }
        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Patient Name',
            'Hospital No',
            'HMO Group',
            'HMO Plan',
            'Service Category/Name',
            'Quantity',
            'Amount (₦)',
            'Status'
        ];
    }

    public function map($billing): array
    {
        return [
            $billing->created_at->format('M d, Y'),
            ($billing->patient->user->firstname ?? '') . ' ' . ($billing->patient->user->lastname ?? ''),
            $billing->patient->hospital_no ?? 'N/A',
            $billing->hmoPlan->hmo->name ?? 'N/A',
            $billing->hmoPlan->name ?? 'N/A',
            $billing->service,
            $billing->quantity,
            number_format($billing->amount, 2),
            $billing->status == 1 ? 'Paid' : 'Unpaid'
        ];
    }
}
