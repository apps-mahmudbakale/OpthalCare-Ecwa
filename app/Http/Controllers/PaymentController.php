<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\FollowUp;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\TempPatient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
//      dd($request->all());
      $payment_method = PaymentMethod::find($request->payment_method_id);

      if ($payment_method && $payment_method->name == 'Wallet') {
        $patient = Patient::find($request->patient_id);
        $wallet_balance = $patient->wallet_balance;
        $required_amount = $request->amount; // assuming the amount is passed in the request

        if ($wallet_balance < $required_amount) {
          return redirect()->route('app.patients.show', $patient->id)->with(['error', 'insufficient balance']);
        }

        // Deduct the amount from the user's wallet
        $patient->wallet_balance -= $required_amount;

      }

      $payment = Payment::create([
        'billing_id' => $request->billing_id,
        'cashpoint_id' => $request->location_id,
        'payment_method_id' => $request->payment_method_id,
        'paying_amount' => $request->amount,
        'user_id' => Auth::user()->id,
      ]);

      $billing = Billing::where('id', $request->billing_id)->update([
        'status' => true
      ]);

      $service = Billing::where('id', $request->billing_id)->first();

      if ($service->service == 'consultations:Follow-Up'){
//        dd($service);
        $accessCode = 'OPC-' . substr(rand(100000, 999999) . time(), 0, 6);
        $access = FollowUp::create([
          'patient_id' => $service->user_id,
          'access_code' => $accessCode,
        ]);
        $patient = Patient::where('id', $service->user_id)->first();
        if ($access) {
          return view('billing.print-follow', compact('access', 'patient'));
        }
      }

      return view('billing.print', compact('billing', 'payment'))->with(['success' => 'Payment added successfully.']);

    }

public function newMethod()
{
  return view('payments.new-method');
}

  public function saveMethod(Request $request)
  {
    $method = PaymentMethod::create($request->all());

    return redirect()->back()->with(['success' => 'Payment Method added successfully.']);
  }


  public function storeEnroll(Request $request)
  {
    $payment_method = PaymentMethod::find($request->payment_method_id);

    if ($payment_method && $payment_method->name == 'Wallet') {
      $patient = Patient::find($request->patient_id);
      $wallet_balance = $patient->wallet_balance;
      $required_amount = $request->amount; // assuming the amount is passed in the request

      if ($wallet_balance < $required_amount) {
        return redirect()->back()->with(['error', 'insufficient balance']);
      }

      // Deduct the amount from the user's wallet
      $patient->wallet_balance -= $required_amount;

    }

    $payment = Payment::create([
      'billing_id' => $request->billing_id,
      'cashpoint_id' => $request->location_id,
      'payment_method_id' => $payment_method->name,
      'paying_amount' => $request->amount
    ]);

    $billing = Billing::where('id', $request->billing_id)->update([
      'status' => true
    ]);

    $accessCode = 'OPC-' . substr(rand(100000, 999999) . time(), 0, 6);

    $tempPatient = TempPatient::find($request->patient_id);
    $tempPatient->accesscode = $accessCode;
    $tempPatient->save();
//    $tempPatient = DB::table('temp_patients')->where('id', $request->patient_id)->update(['accesscode' => $accessCode]);
if ($tempPatient){
//  dd($tempPatient);
  return view('billing.print-new', compact('tempPatient', ));
}



//

  }
    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
