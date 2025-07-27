<?php

namespace App\Exports;

use App\Models\Antenatal;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AntenatalExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('ophthical.antenatal-export', ['antenatals' => Antenatal::all()]);
    }
}
