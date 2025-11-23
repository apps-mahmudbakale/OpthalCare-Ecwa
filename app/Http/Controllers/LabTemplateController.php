<?php

namespace App\Http\Controllers;

use App\Models\LabParameter;
use App\Models\LabTemplate;
use App\Models\LabTemplateItem;
use Illuminate\Http\Request;

class LabTemplateController extends Controller
{
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'parameters' => 'required|array',
      'references' => 'required|array',
    ]);

    // Save Template
    $template = LabTemplate::create([
      'name' => $request->name,
    ]);


    // Save all items
    foreach ($request->parameters as $index => $paramId) {
      if (!$paramId) continue;

      LabTemplateItem::create([
        'lab_template_id' => $template->id,
        'lab_parameter_id' => $paramId,
        'reference' => $request->references[$index] ?? null
      ]);
    }

    return back()->with('success', 'Template Created Successfully');
  }


  public function edit($id)
  {
    $template = LabTemplate::find($id);

    return view('settings.laboratory.editTemplate', compact('template'));
  }

  public function storeLabParameter(Request $request)
  {
    $parameter = LabParameter::create($request->all());
    return back()->with('success', 'Parameter Created Successfully');
  }

  public function editLabParameter($id)
  {
    $parameter = LabParameter::find($id);
    return view('settings.laboratory.editParameter', compact('parameter'));
  }

  public function updateLabParameter(Request $request, $id)
  {
    $parameter = LabParameter::find($id);
    $parameter->update($request->all());
    return back()->with('success', 'Parameter Updated Successfully');
  }

  public function deleteLabParameter($id)
  {
    $parameter = LabParameter::find($id);
    $parameter->delete();
    return back()->with('success', 'Parameter Deleted Successfully');
  }
}
