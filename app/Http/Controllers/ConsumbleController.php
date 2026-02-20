<?php

namespace App\Http\Controllers;


use App\Models\Consumable;
use App\Models\ConsumableCategory;
use Illuminate\Http\Request;

class ConsumbleController extends Controller
{


  public function storeConsumables(Request $request)
  {
    $drug = Consumable::create($request->all());
    return redirect()->route('app.settings.consumables')->with('success', 'Consumable Added !');
  }

  public function editConsumables($id)
  {
    $consumable = Consumable::findOrFail($id);
    return view('settings.pharmacy.edit-consumable', compact('consumable'));
  }

  public function updateConsumables(Request $request, $id)
  {
    $consumable = Consumable::findOrFail($id);
    $consumable->update($request->all());
    return redirect()->route('app.settings.consumables')->with('success', 'Consumable Updated !');
  }

  public function storeCategory(Request $request)
  {
    $category = ConsumableCategory::create($request->all());
    // dd($request->all());
    return redirect()->route('app.settings.consumables')->with('success', 'Consumable Category Added !');
  }

  public function editCategory($id)
  {
    $category = ConsumableCategory::findOrFail($id);
    return view('settings.pharmacy.edit-consumable-category', compact('category'));
  }

  public function UpdateCategory(Request $request, $id)
  {
    $category = ConsumableCategory::findOrFail($id);
    $category->update($request->all());
    return redirect()->route('app.settings.consumables')->with('success', 'Consumable Category Updated !');
  }
}
