<?php

namespace App\Http\Controllers;

use App\Models\Laboratory;
use App\Models\LabCategory;
use App\Models\LabTemplate;
use App\Models\LabTemplateItem;
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

  public function editTemplate(Request $request, $id){
    $template = LabTemplate::find($id);
    
    // If it's an AJAX request, return the modal view
    if ($request->ajax() || $request->wantsJson()) {
      return view('settings.laboratory.editTemplateModal', compact('template'));
    }
    
    // Otherwise return the full page view
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
//    $request->validate([
//      'name' => 'required',
//      'parameters' => 'required|array',
//      'references' => 'required|array',
//      'item_ids' => 'array'  // each item may have an ID (existing row)
//    ]);

    $template = LabTemplate::findOrFail($id);

    // Update template name
    $template->update([
      'name' => $request->name,
    ]);

    // Track IDs we have processed
    $processedIds = [];

    foreach ($request->parameters as $index => $paramId) {

      if (!$paramId) continue;  // skip empty rows

      $reference = $request->references[$index] ?? null;
      $itemId = $request->item_ids[$index] ?? null;

      // CASE 1: Update existing item
      if ($itemId) {
        $item = LabTemplateItem::find($itemId);

        if ($item) {
          $item->update([
            'lab_parameter_id' => $paramId,
            'reference' => $reference
          ]);
          $processedIds[] = $itemId;
        }
      }
      // CASE 2: Insert new item
      else {
        $newItem = LabTemplateItem::create([
          'lab_template_id' => $template->id,
          'lab_parameter_id' => $paramId,
          'reference' => $reference
        ]);
        $processedIds[] = $newItem->id;
      }
    }

    // Delete removed rows
    LabTemplateItem::where('lab_template_id', $template->id)
      ->whereNotIn('id', $processedIds)
      ->delete();

    // If it's an AJAX request, return JSON
    if ($request->ajax() || $request->wantsJson()) {
      return response()->json([
        'success' => true,
        'message' => 'Lab Test Template Updated Successfully!'
      ]);
    }

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
