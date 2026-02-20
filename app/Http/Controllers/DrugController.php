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

  public function updateDrugs() {}

  public function storeCategory(Request $request)
  {
    $category = DrugCategory::create($request->all());
    // dd($request->all());
    return redirect()->route('app.settings.pharmacy')->with('success', 'Drug Category Added !');
  }

  public function editCategory($id)
  {
    $category = DrugCategory::findOrFail($id);
    return view('settings.pharmacy.edit-category', compact('category'));
  }

  public function UpdateCategory(Request $request, $id)
  {
    $category = DrugCategory::findOrFail($id);
    $category->update($request->all());
    return redirect()->route('app.settings.pharmacy')->with('success', 'Drug Category Updated !');
  }

  //  public function getDrugsbyStore(Request $request)
  //  {
  //    // dd($request->all());
  //    $drugs = Drug::where('store_id', $request->input('store'))->get();
  //
  //    return response()->json($drugs);
  //  }

  public function getByCategory(Request $request)
  {
    $request->validate([
      'category_id' => 'required|exists:drug_categories,id'
    ]);

    $drugs = Drug::where('category_id', $request->category_id)->get(['id', 'name']);

    return response()->json($drugs);
  }

  public function getDrugsByStore(Request $request)
  {
    $request->validate([
      'store_id' => 'required|integer',
      'category_id' => 'required|integer',
    ]);

    $drugs = \App\Models\Drug::where('store_id', $request->store_id)
      ->where('category_id', $request->category_id)
      ->get(['id', 'name', 'quantity']);

    return response()->json(
      $drugs->map(fn($drug) => [
        'id' => $drug->id,
        'name' => $drug->name,
        'text' => $drug->name . ' (Stock: ' . $drug->quantity . ')',
        'stock' => $drug->quantity,
      ])
    );
  }

  public function destroy($id)
  {
    $drug = Drug::findOrFail($id);
    $drug->delete();
    return redirect()->route('app.settings.pharmacy')->with('success', 'Drug Deleted !');
  }
}
