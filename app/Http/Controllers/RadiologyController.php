<?php

namespace App\Http\Controllers;

use App\Models\Radiology;
use App\Models\RadiologyCategory;
use App\Models\RadiologyTemplate;
use Illuminate\Http\Request;

class RadiologyController extends Controller
{
 

  public function storeCategory(Request $request)
  {
    $category = RadiologyCategory::create($request->all());
    return redirect()->route('app.settings.radiology')->with('success', 'Radiology Test Category Added !');
  }

  public function storeTemplate(Request $request)
  {
    $template = RadiologyTemplate::create($request->all());
    return redirect()->route('app.settings.radiology')->with('success', 'Radiology Test Template Added !');
  }

  public function updateTemplate()
  {
  }

  public function updateCategory()
  {
  }

  public function store(Request $request){
    $radiologyTest = Radiology::create($request->all());
    return redirect()->route('app.settings.radiology')->with('success', 'Radiology Test Added !');
  }

}
