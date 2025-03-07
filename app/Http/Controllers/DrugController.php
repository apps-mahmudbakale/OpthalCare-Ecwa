<?php

namespace App\Http\Controllers;


use App\Models\Drug;
use App\Models\DrugCategory;
use Illuminate\Http\Request;

class DrugController extends Controller
{


  public function storeDrugs(Request $request)
  {
    $drug = Drug::create($request->all());
    return redirect()->route('app.settings.pharmacy')->with('success', 'Drug Added !');
  }

  public function updateDrugs()
  {
  }

  public function storeCategory(Request $request)
  {
    $category = DrugCategory::create($request->all());
    // dd($request->all());
    return redirect()->route('app.settings.pharmacy')->with('success', 'Drug Category Added !');
  }

  public function UpdateCategory()
  {
  }

  public function getDrugsbyStore(Request $request)
  {
    // dd($request->all());
    $drugs = Drug::where('store_id', $request->input('store'))->get();

    return response()->json($drugs);
  }
}
