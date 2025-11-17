<?php

namespace App\Http\Controllers;

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
}
