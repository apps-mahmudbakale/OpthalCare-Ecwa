<?php

namespace App\Exports;

use App\Models\LabRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LabReportExport implements FromCollection, WithHeadings
{
  protected $reports;

  public function __construct($reports)
  {
    $this->reports = $reports;
  }

  public function collection()
  {
    return $this->reports->map(function ($report) {
      return [
        'Date'          => $report->created_at->format('Y-m-d'),
        'Patient Name'  => $report->patient && $report->patient->user ? $report->patient->user->firstname.' '.$report->patient->user->lastname : 'N/A',
        'Investigation' => $report->test?->name ?? '-',
        'Category'      => $report->test?->category?->name ?? '-',
        'Status'        => $report->status,
      ];
    });
  }

  public function headings(): array
  {
    return [
      'Date',
      'Patient Name',
      'Investigation',
      'Category',
      'Status',
    ];
  }
}
