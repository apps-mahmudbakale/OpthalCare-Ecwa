<?php

namespace App\Http\Controllers;

use App\Models\LabRequest;
use App\Models\LabResult;
use App\Models\Patient;
use App\Models\Radiology;
use App\Models\RadiologyResult;
use Illuminate\Http\Request;
use App\Models\RadiologyRequest;
use App\Services\ServiceRequestHandler;

class RadiologyRequestController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('radiology.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }
  public function addFindings() {}

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'patient_id' => 'required|exists:patients,id',
      'user_id' => 'required|exists:users,id',
      'imaging_id' => 'required|array',
      'priority' => 'required|array',
      'request_note' => 'required|array',
    ]);


    // dd($request->all());

    $request_ref = str()->upper(str()->random(6));
    $serviceHandler = new ServiceRequestHandler();

    foreach ($request->imaging_id as $index => $imagingId) {
      $imaging = Radiology::find($imagingId);
      //      dd($imaging);

      if (!$imaging) {
        continue; // Skip invalid entries
      }

      RadiologyRequest::create([
        'patient_id'   => $request->patient_id,
        'user_id'      => $request->user_id,
        'imaging_id'   => $imaging->id,
        'priority'     => $request->priority[$index],
        'request_note' => $request->request_note[$index],
        'status'       => 'Pending',
        'request_ref'  => $request_ref,
      ]);

      $serviceHandler->handleServiceRequest(
        $imaging->name,
        $request->patient_id,
        'Radiology',
        'fresh',
        $request_ref,
        1,
        null,
        'radiology_request',
        'Radiology requested via radiology interface by ' . auth()->user()->firstname . ' ' . auth()->user()->lastname,
        $imaging->id
      );
    }

    return redirect()->back()->with('success', 'Imaging Requested!');
  }


  public function addResult(Request $request)
  {
    $data = $request->all();

    // Map Trix field to result column if present
    if (isset($data['radiology-result-trixFields']['result'])) {
      $data['result'] = $data['radiology-result-trixFields']['result'];
    } else {
        // Fallback or search for trixFields in case model naming differs
        foreach($data as $key => $value) {
            if (str_ends_with($key, '-trixFields') && isset($value['result'])) {
                $data['result'] = $value['result'];
                break;
            }
        }
    }
    // dd($data);

    $resultData = array_merge($data, ['user_id' => auth()->id()]);
    
    $result = RadiologyResult::create($resultData);

    $update = RadiologyRequest::where('id', $result->imaging_id)->update(['status' => 'Result Ready']);
    return redirect()->back()->with('success', 'Result Collected!');
  }

  public function updateResult(Request $request)
  {
    $data = $request->all();

    // Map Trix field to result column if present
    if (isset($data['radiology-result-trixFields']['result'])) {
      $data['result'] = $data['radiology-result-trixFields']['result'];
    } else {
        foreach($data as $key => $value) {
            if (str_ends_with($key, '-trixFields') && isset($value['result'])) {
                $data['result'] = $value['result'];
                break;
            }
        }
    }

    $resultData = array_merge($data, ['user_id' => auth()->id()]);
    
    if (empty($resultData['image'])) {
        unset($resultData['image']);
    }

    $result = RadiologyResult::updateOrCreate(
        ['imaging_id' => $data['imaging_id']],
        $resultData
    );

    return redirect()->back()->with('success', 'Result Updated!');
  }

  public function showResult(Request $request, $id)
  {
    $image = RadiologyRequest::findOrFail($id);
    $result = RadiologyResult::where('imaging_id', $id)->first();
    $patient = Patient::where('id', $image->patient_id)->first();

    if ($request->has('modal')) {
        return view('radiology.result-partial', compact('image', 'result', 'patient'));
    }

    return view('radiology.print', compact('image', 'result', 'patient'));
  }

  /**
   * Display the specified resource.
   */
  public function show(RadiologyRequest $radiologyRequest)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $request = RadiologyRequest::where('id', $id)->first();
    return view('radiology.result', compact('request'));
  }

  public function editResult($id)
  {
    $request = RadiologyRequest::with('findings')->where('id', $id)->first();
    return view('radiology.edit-result', compact('request'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, RadiologyRequest $radiologyRequest)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(RadiologyRequest $radiologyRequest)
  {
    $radiologyRequest->load('test');

    if ($radiologyRequest->test) {
        \App\Models\Billing::where('bill_ref', $radiologyRequest->request_ref)
            ->where('service', 'Radiology:' . $radiologyRequest->test->name)
            ->where('status', 0)
            ->delete();
    }

    $radiologyRequest->update(['status' => 'Cancelled']);
    return back()->with('success', 'Imaging request cancelled and bill removed.');
  }
}
