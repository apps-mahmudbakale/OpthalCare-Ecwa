<?php

namespace App\Exports;

use App\Models\RadiologyRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RadReportExport implements FromCollection, withHeadings
{
  protected $reports;

  public function __construct($reports)
  {
    $this->reports = $reports;
  }

  public function collection()
  {
    return collect($this->reports)->map(function ($report) {
      return [
        'Imaging Name' => $report->test->name ?? '-',
        'Category' => $report->test->category->name ?? '-',
        'Request Count' => $report->request_count,
      ];
    });
  }
  public function headings(): array
  {
    return [
      'Imaging Name',
      'Category',
      'Request Count',
    ];
  }
}
