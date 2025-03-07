<?php

namespace App\Http\Controllers;

use App\Models\Laboratory;
use App\Models\LabCategory;
use App\Models\LabTemplate;
use Illuminate\Http\Request;
use App\Exports\LabTestExport;
use App\Imports\LabTestImport;
use Maatwebsite\Excel\Facades\Excel;

class LaboratoryController extends Controller
{
  public function store(Request $request)
  {
    $labTest = Laboratory::create($request->all());
    return redirect()->route('app.settings.laboratory')->with('success', 'Lab Test Added !');
  }

  public function update()
  {
  }

  public function storeCategory(Request $request)
  {
    $category = LabCategory::create($request->all());
    // dd($request->all());
    return redirect()->route('app.settings.laboratory')->with('success', 'Lab Test Category Added !');
  }

  public function UpdateCategory()
  {
  }

  public function storeTemplate(Request $request)
  {
    $template = LabTemplate::create($request->all());
    return redirect()->route('app.settings.laboratory')->with('success', 'Lab Test Template Added !');
  }

  public function Export()
  {
    return Excel::download(new LabTestExport, 'Lab_Tests.xlsx');
  }

  public function Import(Request $request)
  {
    Excel::import(new LabTestImport, $request->file('csv')->store('files'));
    return redirect()->back()->with('success', 'ICD10 data imported successfully!');
  }

  public function updateTemplate()
  {
  }

  public function deleteCategory()
  {
  }

  public function deleteTemplate()
  {
  }
}
