<?php

namespace App\Exports;

use App\Models\Drug;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DrugsExpiredExport implements FromCollection, withHeadings
{
  protected $store_id;

  public function __construct($store_id = null)
  {
    $this->store_id = $store_id;
  }

  public function collection()
  {
    return Drug::with('store')
      ->whereDate('expiry_date', '<=', now())
      ->when($this->store_id, function ($query) {
        $query->where('store_id', $this->store_id);
      })
      ->get()
      ->map(function ($drug) {
        return [
          'Drug Name'   => $drug->name,
          'Quantity'    => $drug->quantity,
          'Expiry Date' => Carbon::parse($drug->expiry_date)->format('d M Y'),
          'Store Name'  => $drug->store?->name ?? 'N/A',
        ];
      });
  }

  public function headings(): array
  {
    return [
      'Drug Name',
      'Quantity',
      'Expiry Date',
      'Store Name',
    ];
  }
}
