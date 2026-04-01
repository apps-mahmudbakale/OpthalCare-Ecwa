<?php

namespace App\Http\Controllers;

use App\Models\Antenatal;
use App\Models\Drug;
use App\Models\Billing;
use App\Models\Laboratory;
use App\Models\Radiology;
use App\Models\Speciality;
use App\Models\DrugRequest;
use Illuminate\Http\Request;
use App\Services\ServiceRequestHandler;

class BillingController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $search    = $request->get('search', '');
    $status    = $request->filled('status') ? (int)$request->get('status') : null;
    $dateFrom  = $request->get('date_from', '');
    $dateTo    = $request->get('date_to', '');

    $query = Billing::query()
        ->whereNull('plan_id')
        ->when(!is_null($status), fn($q) => $q->where('status', $status),
                                  fn($q) => $q->where('status', 0))
        ->when($search, fn($q) => $q->where('service', 'like', "%$search%"))
        ->when($dateFrom, fn($q) => $q->whereDate('created_at', '>=', $dateFrom))
        ->when($dateTo,   fn($q) => $q->whereDate('created_at', '<=', $dateTo))
        ->latest();

    $billings = $query->paginate(20)->withQueryString();

    return view('billing.index', compact('billings', 'search', 'status', 'dateFrom', 'dateTo'));
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
//    dd($request->all());
    $request_ref = str()->random(6);
    if ($request->service_category == 'consultations') {
      $consult = Speciality::find($request->service_id);

      $serviceHandler = new ServiceRequestHandler();
      $billingRecord = $serviceHandler->handleServiceRequest($consult->name, $request->patient_id, 'consultations', $request->service_type, $request_ref, 1);
      // Generate unique access code
//      $accessCode = 'FU-' . strtoupper(Str::random(6));

    } elseif ($request->service_category == 'laboratory') {
      $lab = Laboratory::find($request->service_id);
      $serviceHandler = new ServiceRequestHandler();
      $billingRecord = $serviceHandler->handleServiceRequest($lab->name, $request->patient_id, 'laboratory', 'fresh', $request_ref, 1);
    } elseif ($request->service_category == 'pharmacy') {
      $drug = Drug::find($request->service_id);
      $serviceHandler = new ServiceRequestHandler();
      $billingRecord = $serviceHandler->handleServiceRequest($drug->name, $request->patient_id, 'pharmacy', 'fresh', $request_ref, 1);
    }elseif ($request->service_category == 'ophthicals') {
      //  dd($request->all());
      $optic = Antenatal::find($request->service_id);
      $serviceHandler = new ServiceRequestHandler();
      $billingRecord = $serviceHandler->handleServiceRequest($optic->name, $request->patient_id, 'ophthicals', 'fresh',  $request_ref, 1);
    }elseif ($request->service_category == 'radiology'){
      $imaging = Radiology::find($request->service_id);
      $serviceHandler = new ServiceRequestHandler();
      $billingRecord = $serviceHandler->handleServiceRequest($imaging->name, $request->patient_id, 'radiology', 'fresh',  $request_ref, 1);
    }
    return redirect()->back()->with('success', 'Bill Added Successfully!');

  }

  /**
   * Display the specified resource.
   */
  public function show($ref)
  {
    $amount = Billing::where('bill_ref', $ref)
      ->sum('amount');
    $billing = Billing::with('patient')->where('bill_ref', $ref)->first();

    return view('billing.show', compact('amount', 'ref', 'billing'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Billing $billing)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Billing $billing)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Billing $billing)
  {
    //
  }

  /**
   * Generates a clearance code for a pending check-in bill when paid.
   */
  public function generateCheckInCode(Request $request)
  {
      $request->validate([
          'billing_id' => 'required|string'
      ]);

      // Find the check-in consultation bill
      $bill = Billing::where('bill_ref', $request->billing_id)
                     ->where('service', 'Consultation / Check-In Fee')
                     ->firstOrFail();

      if ($bill->status == 1) {
          return back()->with('error', 'Bill is already paid.');
      }

      // Find the pending checkin record for this patient today
      $checkIn = \App\Models\CheckIn::where('patient_id', $bill->user_id)
                                    ->whereDate('check_in_date', today())
                                    ->where('cleared', false)
                                    ->first();

      if (!$checkIn) {
          return back()->with('error', 'No pending check-in found for this bill.');
      }

      \DB::beginTransaction();
      try {
          // Mark bill as paid
          $bill->update(['status' => 1]);

          // Generate a 6-character uppercase alphanumeric code
          $code = strtoupper(str()->random(6));

          // Save code to the checkin record
          $checkIn->update(['clearance_code' => $code]);

          \DB::commit();
          return back()->with('success', 'Payment successful. Clearance Code: ' . $code)->with('clearance_code', $code);
      } catch (\Exception $e) {
          \DB::rollBack();
          return back()->with('error', 'Failed to generate clearance code: ' . $e->getMessage());
      }
  }
}
