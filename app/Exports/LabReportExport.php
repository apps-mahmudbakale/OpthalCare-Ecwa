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
    return collect($this->reports)->map(function ($report) {
      return [
        'Test Name' => $report->test->name ?? '-',
        'Category' => $report->test->category->name ?? '-',
        'Request Count' => $report->request_count,
      ];
    });
  }
  public function headings(): array
  {
    return [
      'Test Name',
      'Category',
      'Request Count',
    ];
  }
}
