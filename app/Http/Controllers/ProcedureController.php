<?php

namespace App\Http\Controllers;



use App\Models\Procedure;
use Illuminate\Http\Request;
use App\Models\ProceudreRequest;
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
    $request = ProceudreRequest::create(array_merge($request->except('status'), ['status' => 'Pending']));
    $procedure = Procedure::find($request->procedure_id);
    $serviceHandler = new ServiceRequestHandler();
    $billingRecord = $serviceHandler->handleServiceRequest($procedure->name, $request->patient_id, 'Procedure');
    return redirect()->back()->with('success', 'Procedure Requested!');
  }


  public function storeProcedure(Request $request)
  {
    $procedure = Procedure::create($request->all());
    return redirect()->route('app.settings.procedures')->with('success', 'Procedure Added !');
  }

  public function updateProcedure()
  {
  }

  public function storeCategory(Request $request)
  {
    $category = ProcedureCategory::create($request->all());
    // dd($request->all());
    return redirect()->route('app.settings.procedures')->with('success', 'Procedure Category Added !');
  }

  public function UpdateCategory()
  {
  }
}
