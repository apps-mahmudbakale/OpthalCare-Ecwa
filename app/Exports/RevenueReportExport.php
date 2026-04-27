<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RevenueReportExport implements FromCollection, WithHeadings
{
  protected $data;

  public function __construct($data)
  {
    $this->data = $data;
  }

  public function collection()
  {
    return $this->data->map(function ($item) {
      return [
        'Date' => $item->created_at->format('d M Y h:i A'),
        'Bill Ref' => $item->billing->bill_ref ?? '',
        'Patient Name' => ($item->billing->patient->user->firstname ?? '') . ' ' . ($item->billing->patient->user->lastname ?? ''),
        'Patient ID' => $item->billing->patient->hospital_number ?? '',
        'Service' => $item->billing->service ?? '',
        'Cash Point' => strtoupper($item->cashPoint->name ?? ''),
        'Payment Method' => ucfirst($item->payment_method ?? 'Cash'),
        'Amount' => number_format($item->paying_amount, 2),
      ];
    });
  }

  public function headings(): array
  {
    return ['Date', 'Bill Ref', 'Patient Name', 'Patient ID', 'Service', 'Cash Point', 'Payment Method', 'Amount'];
  }
}
