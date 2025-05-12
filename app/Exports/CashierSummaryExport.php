<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CashierSummaryExport implements FromCollection, WithHeadings, WithMapping
{
  protected $data;

  public function __construct($data)
  {
    $this->data = $data;
  }

  public function collection()
  {
    return $this->data;
  }

  public function headings(): array
  {
    return [
      'Cashier',
      'Payment Method',
      'Total Amount',
    ];
  }

  public function map($row): array
  {
    return [
      $row->user?->firstname . ' ' . $row->user?->lastname,
      ucfirst($row->payment_method ?? 'Cash'),
      number_format($row->total, 2),
    ];
  }
}

