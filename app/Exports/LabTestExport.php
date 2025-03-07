<?php

namespace App\Exports;

use App\Models\Laboratory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;

class LabTestExport implements FromView
{

  public function view(): View
  {
    return view('laboratory.export', ['labs' => Laboratory::all()]);
  }
}
