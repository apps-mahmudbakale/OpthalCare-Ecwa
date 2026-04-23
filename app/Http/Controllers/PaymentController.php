<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\FollowUp;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\TempPatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
  /**
   * Process wallet payment and validate balance
   */
  private function processWalletPayment(Patient $patient, float $amount): bool
  {
    if ($patient->wallet->balance < $amount) {
      return false;
    }

    $patient->wallet->balance -= $amount;
    $patient->wallet->save(); // Save the updated wallet balance

    return true;
  }

  /**
   * Create payment and update billing status
   */
  private function createPaymentAndUpdateBilling(array $paymentData, int $billingId): Payment
  {
    $payment = Payment::create($paymentData);
    Billing::where('id', $billingId)->update(['status' => true]);
    return $payment;
  }

  /**
   * Store a newly created payment resource
   */
  public function store(Request $request)
  {
    $request->validate([
      'patient_id' => 'required|exists:patients,id',
      'billing_id' => 'required|string', // Allow string for bill_ref like 64N2yT
      'payment_method_id' => 'required|exists:payment_methods,id',
      'amount' => 'required|numeric|min:0',
    ]);

    try {
      return DB::transaction(function () use ($request) {
        $paymentMethod = PaymentMethod::findOrFail($request->payment_method_id);
        $patient = Patient::findOrFail($request->patient_id);

        // Find billings by bill_ref
        $billings = Billing::where('bill_ref', $request->billing_id)
          ->where('user_id', $patient->id) // Ensure billing belongs to patient
          ->get();

        if ($billings->isEmpty()) {
          Log::warning("No billing found for bill_ref: {$request->billing_id}");
          return redirect()->back()->with(['error' => 'Invalid or non-existent billing reference']);
        }

        // Handle wallet payment
        if (strcasecmp($paymentMethod->name, 'wallet') === 0
          && !$this->processWalletPayment($patient, $request->amount)) {
          dd($patient);
          return redirect()->route('app.patients.show', $patient->id)
            ->with(['error' => 'Insufficient balance']);
        }



        $paymentData = [
          'cashpoint_id'   => $request->location_id,
          'payment_method' => $paymentMethod->name,
          'user_id'        => Auth::id(),
        ];

        $payment = null;
        // Process multiple billings if they exist
        if ($billings->count() > 1) {
          foreach ($billings as $billing) {
            $paymentData['billing_id'] = $billing->id;
            $paymentData['paying_amount'] = $billing->amount;
            $payment = $this->createPaymentAndUpdateBilling($paymentData, $billing->id);
          }
        } else {
          // Single billing
          $billing = $billings->first();
          $paymentData['billing_id'] = $billing->id;
          $paymentData['paying_amount'] = $request->amount;
          $payment = $this->createPaymentAndUpdateBilling($paymentData, $billing->id);
        }

        $service = $billings->first(); // Use first billing for service check

        // Handle Check-In Consultation Fee
        $clearanceCode = null;
        if (strtolower($service->service) === strtolower('consultation / check-in fee')) {
          $checkIn = \App\Models\CheckIn::where('patient_id', $service->user_id)
                                        ->whereDate('check_in_date', today())
                                        ->where('cleared', false)
                                        ->first();

          if ($checkIn) {
              $clearanceCode = strtoupper(str()->random(6));
              $checkIn->update(['clearance_code' => $clearanceCode]);
          }
        }

        // Handle follow-up consultation
        if (strtolower($service->service) === strtolower('consultations:Follow-Up')) {
          $accessCode = 'OPC-' . substr(rand(100000, 999999) . time(), 0, 6);
          $access = FollowUp::create([
            'patient_id' => $service->user_id,
            'access_code' => $accessCode,
          ]);

          return view('billing.print-follow', compact('access', 'patient'));
        }

        return view('billing.print', [
          'billing' => $service,
          'payment' => $payment,
          'bill_ref' => $request->billing_id,
          'clearance_code' => $clearanceCode
        ])->with(['success' => 'Payment added successfully']);
      });
    } catch (\Exception $e) {
      Log::error('Payment processing failed: ' . $e->getMessage(), [
        'bill_ref' => $request->billing_id,
        'patient_id' => $request->patient_id
      ]);
      return redirect()->back()->with(['error' => 'Payment processing failed: Invalid billing reference or server error']);
    }
  }

  /**
   * Show form for creating new payment method
   */
  public function newMethod()
  {
    return view('payments.new-method');
  }

  /**
   * Save new payment method
   */
  public function saveMethod(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255|unique:payment_methods',
    ]);

    try {
      PaymentMethod::create($request->only(['name']));
      return redirect()->back()->with(['success' => 'Payment Method added successfully']);
    } catch (\Exception $e) {
      Log::error('Payment method creation failed: ' . $e->getMessage());
      return redirect()->back()->with(['error' => 'Failed to add payment method']);
    }
  }

  public  function EditMethod($id)
  {
    $method = PaymentMethod::where('id', $id)->first();
    return view('payments.edit-method', compact('method'));
  }


  public  function  UpdateMethod(Request $request)
  {
      $method = PaymentMethod::where('id', $request->method_id)->first();

      $method->update(['name' => $request->name]);

      return redirect()->back()->with('success', 'Payment Method Updated');
  }

  /**
   * Store payment for enrollment
   */
  public function storeEnroll(Request $request)
  {
    try {
      return DB::transaction(function () use ($request) {
        $paymentMethod = PaymentMethod::findOrFail($request->payment_method_id);
        $tempPatient = TempPatient::findOrFail($request->patient_id);

        // Handle wallet payment
        if ($paymentMethod->name === 'Wallet') {
          $patient = Patient::findOrFail($request->patient_id);
          if (!$this->processWalletPayment($patient, $request->amount)) {
            return redirect()->back()->with(['error' => 'Insufficient balance']);
          }
        }

        // Create payment
        $payment = $this->createPaymentAndUpdateBilling([
          'billing_id'     => $request->billing_id,
          'cashpoint_id'   => $request->location_id,
          'payment_method' => $paymentMethod->name,
          'paying_amount'  => $request->amount,
          'user_id'        => Auth::id(),
        ], $request->billing_id);

        $billing = Billing::where('id', $request->billing_id)->first();


        // Update temp patient with access code
        $accessCode = 'OPC-' . substr(rand(100000, 999999) . time(), 0, 6);
        $tempPatient->update(['accesscode' => $accessCode]);

        return view('billing.print-new', compact('tempPatient', 'billing'));
      });
    } catch (\Exception $e) {
      Log::error('Enrollment payment processing failed: ' . $e->getMessage());
      return redirect()->back()->with(['error' => 'Enrollment payment processing failed']);
    }
  }

  public function DeleteMethod(Request $request)
  {
      $method = PaymentMethod::where('id', $request->method_id)->first();

      $method->delete();

      return redirect()->back()->with('success', 'Payment Method Deleted');
  }

  /**
   * Reprint receipt for a paid bill
   */
  public function reprintReceipt($billRef)
  {
    try {
      // Find the billing record
      $billing = Billing::where('bill_ref', $billRef)
        ->where('status', 1) // Only paid bills
        ->first();

      if (!$billing) {
        return redirect()->back()->with('error', 'No paid bill found with this reference.');
      }

      // Find the payment record
      $payment = Payment::where('billing_id', $billing->id)->first();

      if (!$payment) {
        return redirect()->back()->with('error', 'No payment record found for this bill.');
      }

      $patient = Patient::findOrFail($billing->user_id);

      // Check if it's a check-in consultation with clearance code
      $clearanceCode = null;
      if (strtolower($billing->service) === strtolower('consultation / check-in fee')) {
        $checkIn = \App\Models\CheckIn::where('patient_id', $billing->user_id)
                                      ->whereDate('check_in_date', $billing->created_at->toDateString())
                                      ->where('cleared', false)
                                      ->first();
        if ($checkIn) {
          $clearanceCode = $checkIn->clearance_code;
        }
      }

      // Check if it's a follow-up consultation
      if (strtolower($billing->service) === strtolower('consultations:Follow-Up')) {
        $access = FollowUp::where('patient_id', $billing->user_id)
                          ->whereDate('created_at', $billing->created_at->toDateString())
                          ->first();
        
        if ($access) {
          return view('billing.print-follow', compact('access', 'patient'));
        }
      }

      return view('billing.print', [
        'billing' => $billing,
        'payment' => $payment,
        'bill_ref' => $billRef,
        'clearance_code' => $clearanceCode
      ]);

    } catch (\Exception $e) {
      Log::error('Receipt reprint failed: ' . $e->getMessage());
      return redirect()->back()->with('error', 'Failed to reprint receipt.');
    }
  }

  /**
   * Reprint enrollment receipt
   */
  public function reprintEnrollment($tempPatientId)
  {
    try {
      $tempPatient = TempPatient::findOrFail($tempPatientId);

      // Find the enrollment billing record
      $billing = Billing::where('user_id', $tempPatient->id)
        ->where('service', 'LIKE', '%Enrollment%')
        ->where('status', 1) // Only paid
        ->first();

      if (!$billing) {
        return redirect()->back()->with('error', 'No paid enrollment found for this patient.');
      }

      return view('billing.print-new', compact('tempPatient', 'billing'));

    } catch (\Exception $e) {
      Log::error('Enrollment receipt reprint failed: ' . $e->getMessage());
      return redirect()->back()->with('error', 'Failed to reprint enrollment receipt.');
    }
  }

  /**
   * Search for enrollments to reprint
   */
  public function searchEnrollment(Request $request)
  {
    $search = $request->get('search', '');
    
    $enrollments = TempPatient::query()
      ->when($search, function($query, $search) {
        $query->where(function($q) use ($search) {
          $q->where('first_name', 'LIKE', "%{$search}%")
            ->orWhere('last_name', 'LIKE', "%{$search}%")
            ->orWhere('accesscode', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%");
        });
      })
      ->whereHas('billing', function($query) {
        $query->where('status', 1); // Only show paid enrollments
      })
      ->with('billing')
      ->orderBy('created_at', 'desc')
      ->paginate(20);

    return view('payments.search-enrollment', compact('enrollments', 'search'));
  }
}
