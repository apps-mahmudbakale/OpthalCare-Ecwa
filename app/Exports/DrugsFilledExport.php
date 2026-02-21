<?php

namespace App\Exports;

use App\Models\DrugRequest;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DrugsFilledExport implements FromCollection, WithHeadings
{
  private $store_id;
  private $startDate;
  private $endDate;
  private $fileName = 'drugs-filled-report.xlsx';

  public function __construct($store_id = null, $startDate = null, $endDate = null)
  {
    $this->store_id = $store_id;
    $this->startDate = $startDate;
    $this->endDate = $endDate;
  }

  public function collection(): Collection
  {
    return DrugRequest::with(['store', 'patient.user', 'drug'])
      ->where('status', 'filled')
      ->when($this->store_id, fn($q) => $q->where('store_id', $this->store_id))
      ->when($this->startDate, fn($q) => $q->whereDate('created_at', '>=', $this->startDate))
      ->when($this->endDate, fn($q) => $q->whereDate('created_at', '<=', $this->endDate))
      ->get()
      ->map(function ($request) {
        return [
          'Patient Name' => $request->patient && $request->patient->user ? $request->patient->user->firstname.' '.$request->patient->user->lastname : 'N/A',
          'Drug'         => $request->drug?->name ?? 'N/A',
          'Quantity'     => $request->qty ?? 0,
          'Store'        => $request->store?->name ?? 'N/A',
          'Status'       => ucfirst($request->status),
          'Requested At' => $request->created_at->format('Y-m-d'),
        ];
      });
  }

  public function headings(): array
  {
    return ['Patient Name', 'Drug', 'Quantity', 'Store', 'Status', 'Requested At'];
  }
}
