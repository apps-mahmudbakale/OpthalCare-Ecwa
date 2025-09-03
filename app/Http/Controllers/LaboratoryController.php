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

  public function editCategory($id)
  {
    $category = LabCategory::find($id);
    return view('settings.laboratory.editCategory', compact('category'));
  }

  public function editTemplate($id){
    $template = LabTemplate::find($id);
    return view('settings.laboratory.editTemplate', compact('template'));
  }

  public function edit($id)
  {
    $lab = Laboratory::find($id);
    return view('settings.laboratory.edit', compact('lab'));
  }

  public function store(Request $request)
  {
    $labTest = Laboratory::create($request->all());
    return redirect()->route('app.settings.laboratory')->with('success', 'Lab Test Added !');
  }

  public function update(Request $request, $id)
  {
    $lab = Laboratory::find($id);
    $lab->update($request->all());
    return redirect()->route('app.settings.laboratory')->with('success', 'Lab Test Updated !');
  }

  public function storeCategory(Request $request)
  {
    $category = LabCategory::create($request->all());
    // dd($request->all());
    return redirect()->route('app.settings.laboratory')->with('success', 'Lab Test Category Added !');
  }

  public function UpdateCategory(Request $request, $id)
  {
    $category = LabCategory::find($id);
    $category->update($request->all());
    return redirect()->route('app.settings.laboratory')->with('success', 'Lab Test Category Updated !');
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

  public function updateTemplate(Request $request, $id)
  {
    $template = LabTemplate::find($id);
    $template->update($request->all());
    return redirect()->route('app.settings.laboratory')->with('success', 'Lab Test Template Updated !');
  }

  public function deleteCategory($id)
  {
    $category = LabCategory::find($id);
    $category->delete();
    return redirect()->route('app.settings.laboratory')->with('success', 'Lab Test Category Deleted !');
  }

  public function deleteTemplate($id)
  {
    $template = LabTemplate::find($id);
    $template->delete();
    return redirect()->route('app.settings.laboratory')->with('success', 'Lab Test Template Deleted !');
  }

  public function destroy($id)
  {
    $lab = Laboratory::find($id);
    $lab->delete();
    return redirect()->route('app.settings.laboratory')->with('success', 'Lab Test Deleted !');
  }
}
