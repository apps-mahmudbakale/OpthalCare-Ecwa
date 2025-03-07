<?php

namespace App\Http\Controllers;

use App\Models\Antenatal;
use Illuminate\Http\Request;

class AntenatalController extends Controller
{
  public function index()
  {
  }


  public function store(Request $request)
  {
    $antenatal = Antenatal::create($request->all());

    return redirect()->route('app.settings.antenatal')->with('success', 'Package Added');
  }

  public function destroy(Antenatal $antenatal)
  {
    $antenatal->delete();

    return redirect()->route('app.settings.antenatal')->with('success', 'Package Deleted');
  }
}
