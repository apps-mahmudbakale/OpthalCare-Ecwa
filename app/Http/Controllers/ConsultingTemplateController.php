<?php

namespace App\Http\Controllers;

use App\Models\ConsultingTemplate;
use Illuminate\Http\Request;

class ConsultingTemplateController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $perPage = $request->get('per_page', 10);
    $search = $request->get('search');

    $consultingTemplates = ConsultingTemplate::query()
      ->when($search, function ($query) use ($search) {
        $query->where('name', 'like', '%' . $search . '%')
          ->orWhere('body', 'like', '%' . $search . '%');
      })
      ->orderBy('name', 'asc')
      ->paginate($perPage);

    return view('settings.consultation.consulting-templates', compact('consultingTemplates'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'body' => 'required|string'
    ]);

    $template = ConsultingTemplate::create($request->all());

    return redirect()->route('app.consulting-templates.index')->with('success', 'Consulting Template Added Successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(ConsultingTemplate $consultingTemplate)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $consultingTemplate = ConsultingTemplate::findOrFail($id);
    return view('settings.consultation.edit-consulting-template', compact('consultingTemplate'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'body' => 'required|string'
    ]);

    $consultingTemplate = ConsultingTemplate::findOrFail($id);
    $consultingTemplate->update($request->all());

    return redirect()->route('app.consulting-templates.index')->with('success', 'Consulting Template Updated Successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(ConsultingTemplate $consultingTemplate)
  {
    $consultingTemplate->delete();
    return redirect()->back()->with('success', 'Consulting Template Deleted Successfully');
  }
}
