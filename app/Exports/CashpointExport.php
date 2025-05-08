<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CashpointExport implements FromCollection, WithHeadings
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
        'Date' => $item->created_at->format('Y-m-d H:i'),
        'Service' => $item->billing->service ?? '-',
        'Cash Point' => $item->cashPoint->name ?? '-',
        'Payment Method' => ucfirst($item->payment_method ?? 'Cash'),
        'Amount' => $item->paying_amount,
      ];
    });
  }

  public function headings(): array
  {
    return ['Date', 'Service', 'Cash Point', 'Payment Method', 'Amount'];
  }
}
