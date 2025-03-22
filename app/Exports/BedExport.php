<?php

namespace App\Exports;

use App\Models\Bed;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BedExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
  public function view(): View
  {
    return view('admission.beds-export', ['beds' => Bed::all()]);
  }
}
