<?php

namespace App\Http\Controllers;



use App\Models\Procedure;
use Illuminate\Http\Request;
use App\Models\ProcedureRequest;
use App\Models\ProcedureCategory;
use App\Services\ServiceRequestHandler;

class ProcedureController extends Controller
{

  public function index()
  {
    return view('procedure.index');
  }


  public function store(Request $request)
  {
    dd($request->all());
    $request = ProcedureRequest::create(array_merge($request->except('status'), ['status' => 'Pending']));
    $procedure = Procedure::find($request->procedure_id);
    $serviceHandler = new ServiceRequestHandler();
    $billingRecord = $serviceHandler->handleServiceRequest(
      $procedure->name, 
      $request->patient_id, 
      'Procedure',
      'fresh',
      str()->random(6),
      1,
      null,
      'procedure_request',
      'Procedure requested via procedure interface by ' . auth()->user()->firstname . ' ' . auth()->user()->lastname,
      $procedure->id
    );
    return redirect()->back()->with('success', 'Procedure Requested!');
  }

  public function edit($id)
  {
    $procedure = Procedure::findOrFail($id);
    return view('procedure.edit', compact('procedure'));
  }


  public function storeProcedure(Request $request)
  {
    $procedure = Procedure::create($request->all());
    return redirect()->route('app.settings.procedures')->with('success', 'Procedure Added !');
  }

  public function updateProcedure(Request $request, $id)
  {
    $procedure = Procedure::findOrFail($id);
    $procedure->update($request->all());
    return redirect()->route('app.settings.procedures')->with('success', 'Procedure Updated !');
  }

  public function storeCategory(Request $request)
  {
    $category = ProcedureCategory::create($request->all());
    // dd($request->all());
    return redirect()->route('app.settings.procedures')->with('success', 'Procedure Category Added !');
  }

  public function editCategory($id)
  {
    $category = ProcedureCategory::findOrFail($id);
    return view('settings.procedure.edit-category', compact('category'));
  }

  public function UpdateCategory(Request $request, $id) {
     $category = ProcedureCategory::findOrFail($id);
     $category->update($request->all());
     return redirect()->route('app.settings.procedures')->with('success', 'Procedure Category Updated !');

  }

  public function deleteCategory($id){
    $category = ProcedureCategory::findOrFail($id);
     $category->delete();
     return redirect()->route('app.settings.procedures')->with('success', 'Procedure Category Deleted !');
  }

  public function destroy($id)
  {
    $procedure = Procedure::findOrFail($id);
    $procedure->delete();
    return redirect()->route('app.settings.procedures')->with('success', 'Procedure Deleted !');
  }
}
