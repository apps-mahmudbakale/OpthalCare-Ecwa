<?php

namespace App\Http\Controllers;

use App\Exports\AntenatalExport;
use App\Imports\AntenatalImport;
use App\Models\Antenatal;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AntenatalController extends Controller
{
  public function index()
  {
    return view('antenatal.index');
  }


  public function store(Request $request)
  {
    $antenatal = Antenatal::create($request->all());

    return redirect()->route('app.settings.ophthical')->with('success', 'Item Added');
  }

  public function destroy(Antenatal $antenatal)
  {
    $antenatal->delete();

    return redirect()->route('app.settings.ophthical')->with('success', 'Item Deleted');
  }

  public function export()
  {
    return Excel::download(new AntenatalExport, 'Ophthicals.xlsx');
  }

  public function importView()
  {
    return view('ophthical.antenatal-import');
  }

  public function import(Request $request)
  {
    Excel::import(new AntenatalImport, $request->file('csv')->store('files'));

    return redirect()->route('app.settings.ophthical')->with('success', 'Ophthicals imported successfully!');
  }
}
