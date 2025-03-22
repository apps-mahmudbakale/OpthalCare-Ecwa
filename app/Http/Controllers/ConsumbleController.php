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

  public function updateConsumables()
  {
  }

  public function storeCategory(Request $request)
  {
    $category = ConsumableCategory::create($request->all());
    // dd($request->all());
    return redirect()->route('app.settings.consumables')->with('success', 'Consumable Category Added !');
  }

  public function UpdateCategory()
  {
  }
}
