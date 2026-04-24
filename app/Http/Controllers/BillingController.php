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
    $query = Billing::query()->with(['patient.user', 'hmoPlan.hmo']);

    // Apply status filter
    $status = $request->get('status', 'unpaid');
    if ($status === 'paid') {
      $query->where('status', 1);
    } elseif ($status === 'unpaid') {
      $query->where('status', 0);
    }

    // Apply payer filter
    $payer = $request->get('payer', 'all');
    if ($payer === 'self') {
      $query->whereNull('plan_id');
    } elseif ($payer === 'hmo') {
      $query->whereNotNull('plan_id');
    }

    // Apply search
    $search = $request->get('search');
    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('service', 'like', '%' . $search . '%')
          ->orWhere('bill_ref', 'like', '%' . $search . '%')
          ->orWhereHas('patient.user', function ($userQuery) use ($search) {
            $userQuery->where('firstname', 'like', '%' . $search . '%')
              ->orWhere('lastname', 'like', '%' . $search . '%')
              ->orWhere('middlename', 'like', '%' . $search . '%');
          });
      });
    }

    // Apply date range filter
    if ($request->get('date_from')) {
      $query->whereDate('created_at', '>=', $request->get('date_from'));
    }
    if ($request->get('date_to')) {
      $query->whereDate('created_at', '<=', $request->get('date_to'));
    }

    $query->orderBy('created_at', 'desc');

    $perPage = $request->get('per_page', 10);
    $paginated = $query->paginate($perPage);

    // Group the paginated collection by bill_ref
    $grouped = $paginated->getCollection()->groupBy('bill_ref');

    // Create a new paginator instance with the grouped data
    $billings = new \Illuminate\Pagination\LengthAwarePaginator(
      $grouped,
      $paginated->total(),
      $paginated->perPage(),
      $paginated->currentPage(),
      ['path' => $request->url(), 'query' => $request->query()]
    );

    // Calculate summary statistics
    $summaryQuery = Billing::query();
    if ($payer === 'self') {
      $summaryQuery->whereNull('plan_id');
    } elseif ($payer === 'hmo') {
      $summaryQuery->whereNotNull('plan_id');
    }

    $totalAmount = (clone $summaryQuery)->sum('amount');
    $paidAmount = (clone $summaryQuery)->where('status', 1)->sum('amount');
    $unpaidAmount = (clone $summaryQuery)->where('status', 0)->sum('amount');

    return view('billing.all-billings', compact('billings', 'totalAmount', 'paidAmount', 'unpaidAmount'));
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
    // Get all bills with this reference
    $allBills = Billing::where('bill_ref', $ref)->get();
    
    // Calculate total of unpaid bills
    $amount = Billing::where('bill_ref', $ref)
      ->where('status', 0)
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

  /**
   * Cancel all unpaid system charges for a bill reference and delete associated requests.
   */
  public function cancel($billRef)
  {
    try {
      \DB::beginTransaction();

      // Find all billings with this bill_ref (both paid and unpaid)
      $billings = Billing::where('bill_ref', $billRef)->get();

      if ($billings->isEmpty()) {
        return response()->json([
          'success' => false,
          'message' => 'No charges found for this bill reference.'
        ], 404);
      }

      // Track what we're deleting
      $deletedBillings = 0;
      $deletedRequests = 0;
      $serviceTypes = [];

      // Delete associated service requests based on service category
      foreach ($billings as $billing) {
        // Extract service category from the service field (format: "category:serviceName")
        $serviceParts = explode(':', $billing->service);
        $serviceCategory = strtolower($serviceParts[0] ?? '');
        
        if (!in_array($serviceCategory, $serviceTypes)) {
          $serviceTypes[] = $serviceCategory;
        }

        // Delete the corresponding request based on service category
        switch ($serviceCategory) {
          case 'laboratory':
            $deleted = \App\Models\LabRequest::where('request_ref', $billRef)->delete();
            $deletedRequests += $deleted;
            break;
            
          case 'pharmacy':
            $deleted = \App\Models\DrugRequest::where('request_ref', $billRef)->delete();
            $deletedRequests += $deleted;
            break;
            
          case 'radiology':
            $deleted = \App\Models\RadiologyRequest::where('request_ref', $billRef)->delete();
            $deletedRequests += $deleted;
            break;
            
          case 'procedure':
            // Try ProcedureRequest first (correct spelling, has request_ref)
            try {
              $deleted = \App\Models\ProcedureRequest::where('request_ref', $billRef)->delete();
              $deletedRequests += $deleted;
            } catch (\Exception $e) {
              // Ignore if table doesn't exist or column not found
            }
            
            // ProceudreRequest (typo) doesn't have request_ref, so we can't delete by bill_ref
            // We would need patient_id which we don't have in this context
            break;
            
          case 'ophthicals':
          case 'opticals':
            $deleted = \App\Models\OpticalRequest::where('request_ref', $billRef)->delete();
            $deletedRequests += $deleted;
            break;
        }
      }

      // Delete all billings (both paid and unpaid)
      $deletedBillings = Billing::where('bill_ref', $billRef)->delete();

      // Delete antenatal package usage records if any
      \App\Models\AntenatalPackageUsage::where('billing_id', function($query) use ($billRef) {
        $query->select('id')
              ->from('billings')
              ->where('bill_ref', $billRef);
      })->delete();

      \DB::commit();

      $message = "Successfully cancelled: {$deletedBillings} billing record(s)";
      if ($deletedRequests > 0) {
        $message .= " and {$deletedRequests} service request(s)";
      }
      $message .= ".";

      return response()->json([
        'success' => true,
        'message' => $message,
        'details' => [
          'billings_deleted' => $deletedBillings,
          'requests_deleted' => $deletedRequests,
          'service_types' => $serviceTypes
        ]
      ]);

    } catch (\Exception $e) {
      \DB::rollBack();
      
      return response()->json([
        'success' => false,
        'message' => 'Failed to cancel charges: ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * Cancel a single billing line item and its associated request.
   */
  public function cancelLine($billingId)
  {
    try {
      \DB::beginTransaction();

      // Find the specific billing record
      $billing = Billing::find($billingId);

      if (!$billing) {
        return response()->json([
          'success' => false,
          'message' => 'Billing record not found.'
        ], 404);
      }

      // Extract service category from the service field (format: "category:serviceName")
      $serviceParts = explode(':', $billing->service);
      $serviceCategory = strtolower($serviceParts[0] ?? '');
      $serviceName = $serviceParts[1] ?? $billing->service;

      $deletedRequests = 0;

      // Delete the corresponding request based on service category and service_id
      switch ($serviceCategory) {
        case 'laboratory':
          $deleted = \App\Models\LabRequest::where('request_ref', $billing->bill_ref)
                                           ->where('test_id', $billing->service_id)
                                           ->delete();
          $deletedRequests += $deleted;
          break;
          
        case 'pharmacy':
          $deleted = \App\Models\DrugRequest::where('request_ref', $billing->bill_ref)
                                            ->where('drug_id', $billing->service_id)
                                            ->delete();
          $deletedRequests += $deleted;
          break;
          
        case 'radiology':
          $deleted = \App\Models\RadiologyRequest::where('request_ref', $billing->bill_ref)
                                                  ->where('imaging_id', $billing->service_id)
                                                  ->delete();
          $deletedRequests += $deleted;
          break;
          
        case 'procedure':
          // Try ProcedureRequest first (correct spelling, has request_ref)
          try {
            $deleted = \App\Models\ProcedureRequest::where('request_ref', $billing->bill_ref)
                                                    ->where('procedure_id', $billing->service_id)
                                                    ->delete();
            $deletedRequests += $deleted;
          } catch (\Exception $e) {
            // Ignore if table doesn't exist or column not found
          }
          
          // Try ProceudreRequest (typo spelling, doesn't have request_ref)
          // This table uses different structure, so we skip it or handle differently
          try {
            // Only delete if we can match by procedure_id and patient
            if (isset($billing->user_id)) {
              $deleted = \App\Models\ProceudreRequest::where('procedure_id', $billing->service_id)
                                                     ->where('patient_id', $billing->user_id)
                                                     ->delete();
              $deletedRequests += $deleted;
            }
          } catch (\Exception $e) {
            // Ignore if table doesn't exist
          }
          break;
          
        case 'ophthicals':
        case 'opticals':
          $deleted = \App\Models\OpticalRequest::where('request_ref', $billing->bill_ref)
                                                ->where('service_id', $billing->service_id)
                                                ->delete();
          $deletedRequests += $deleted;
          break;
      }

      // Delete antenatal package usage for this specific billing
      \App\Models\AntenatalPackageUsage::where('billing_id', $billing->id)->delete();

      // Delete the billing record
      $billing->delete();

      \DB::commit();

      $message = "Successfully cancelled charge for '{$serviceName}'";
      if ($deletedRequests > 0) {
        $message .= " and deleted the associated request";
      }
      $message .= ".";

      return response()->json([
        'success' => true,
        'message' => $message
      ]);

    } catch (\Exception $e) {
      \DB::rollBack();
      
      return response()->json([
        'success' => false,
        'message' => 'Failed to cancel charge: ' . $e->getMessage()
      ], 500);
    }
  }
}
