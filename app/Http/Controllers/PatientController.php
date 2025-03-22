<?php

namespace App\Http\Controllers;

use App\Models\TempPatient;
use App\Models\Wallet;
use App\Settings\SystemSettings;
use Jajo\NG;
use App\Models\User;
use App\Models\Visit;
use App\Models\CheckIn;
use App\Models\Patient;
use App\Models\HmoGroup;
use App\Models\Religion;
use App\Models\NextOfKin;
use App\Charts\PulseChart;
use App\Models\Speciality;
use App\Charts\WeightChart;
use Illuminate\Http\Request;
use App\Charts\TemperatureChart;
use App\Services\CheckInService;
use App\Charts\BloodPressureChart;
use App\Models\Billing;
use App\Services\ServiceRequestHandler;
use Illuminate\Support\Facades\Validator;
use sirajcse\UniqueIdGenerator\UniqueIdGenerator;

class PatientController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('patients.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    if (!empty($request->data)){
      $ng = new NG();
      $states = $ng->states;
      $religions = Religion::all();
      $hmos = HmoGroup::all();
      $data = json_decode(base64_decode($request->data));
      $hospital_no = UniqueIdGenerator::generate(['table' => 'patients', 'length' => 4,]);
      return view('patients.create', compact('religions', 'states', 'hmos', 'data'));
    } else{
      return redirect()->route('app.patients.index')->with('error', 'You Need Accces Code  to access this Page');
    }

  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // Validation rules for required fields
    $rules = [
      'firstname' => 'required|string|max:255',
      'lastname' => 'required|string|max:255',
      'phone' => 'required|string|max:20',
      'date_of_birth' => 'required|date',
      'email' => 'nullable|email|max:255|unique:users,email',
    ];

    // Optional fields (no 'required' rule)
    $optionalRules = [
      'gender' => 'nullable|in:Male,Female,Other',
      'religion_id' => 'nullable|integer',
      'next_of_kin_name' => 'nullable|string|max:255',
      'next_of_kin_relation' => 'nullable|string|max:255',
      'next_of_kin_phone' => 'nullable|string|max:20',
      'next_of_kin_address' => 'nullable|string|max:255',
      'marital_status' => 'nullable|string',
      'tribe' => 'nullable|string',
      'occupation' => 'nullable|string',
      'state_of_residence' => 'nullable|string',
      'lga_of_residence' => 'nullable|string',
      'state_of_origin' => 'nullable|string',
      'lga_of_origin' => 'nullable|string',
      'residential_address' => 'nullable|string',
    ];

    // Merge required and optional rules
    $rules = array_merge($rules, $optionalRules);

    // Custom validation messages
    $messages = [
      'firstname.required' => 'The First Name field is required.',
      'lastname.required' => 'The Last Name field is required.',
      'phone.required' => 'The phone field is required.',
      'date_of_birth.required' => 'The date of birth field is required.',
      'email.email' => 'The email must be a valid email address.',
      'email.unique' => 'The email has already been taken.',
    ];

    // Validate the request
    $validator = Validator::make($request->all(), $rules, $messages);

    // Check if validation fails
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->withInput();
    }

    // Set a default email if none is provided
    $email = $request->input('email') ?: 'no-email-' . uniqid() . '@example.com';

    // Create the user
    $user = User::create(array_merge(
      $request->except(['date_of_birth', 'gender', 'password', 'email']),
      [
        'email' => $email,
        'password' => bcrypt($request->password ?: 'default_password'),
      ]
    ));

    // Assign the 'patient' role to the user
    $user->assignRole('patient');

    // Generate a unique hospital number
    $hospital_no = UniqueIdGenerator::generate(['table' => 'patients', 'length' => 4]);

    // Create the patient record
    $patient = Patient::create(array_merge(
      $request->except(['password', 'next_of_kin_name', 'next_of_kin_relation', 'next_of_kin_phone', 'next_of_kin_address']),
      ['hospital_no' => $hospital_no, 'user_id' => $user->id]
    ));

    // Create the next of kin record
    $next_of_kin = NextOfKin::create(array_merge(
      $request->only(['next_of_kin_name', 'next_of_kin_relation', 'next_of_kin_phone', 'next_of_kin_address']),
      ['patient_id' => $patient->id]
    ));

    // Update billing and delete temporary patient record
    $billUpdate = Billing::where('user_id', $request->temp_id)->update(['user_id' => $patient->id]);
    $deleteTemp = TempPatient::where('id', $request->temp_id)->delete();

    // Create a visit record
    $visit = Visit::create([
      'patient_id' => $patient->id,
      'speciality' => 'Enrollment',
      'status' => 'Concluded'
    ]);

    // Check in the patient after creation
    $checkInService = new CheckInService();
    if ($checkInService->hasCheckedInToday($patient->id)) {
      // If already checked in (unlikely for a new patient), log it or handle silently
      \Log::warning("Patient {$patient->id} already checked in today.");
    } else {
      CheckIn::create([
        'patient_id' => $patient->id,
        'check_in_date' => now()->toDateString(),
      ]);
    }

    // Redirect with success message
    return redirect()->route('app.patients.index')->with('success', 'Patient Created and Checked In Successfully');
  }


  public function createAccount(Request $request)
  {
    $user = User::create(array_merge($request->except(['date_of_birth', 'gender', 'password']), ['password' => bcrypt($request->password)]));
    // $user->assignRole('patient');
    $hospital_no = UniqueIdGenerator::generate(['table' => 'patients', 'length' => 4,]);
    $patient = Patient::create(array_merge($request->except(['password']), ['hospital_no' => $hospital_no, 'user_id' => $user->id]));

    return redirect()->route('register')->with('success', 'Account Created Successfully');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Patient  $patient
   * @return \Illuminate\Http\Response
   */
  public function show(BloodPressureChart $chart, PulseChart $pulse, TemperatureChart $temperature, WeightChart $weight, Patient $patient)
  {
    $checkInService = new CheckInService();
    $outstanding_balance = Billing::where('user_id', $patient->id)->where('status', 0)->sum('amount');
    $wallet_balance = $patient->wallet ? $patient->wallet->balance : 0;
    $isCheckedIn = $patient->isCheckedInToday();

    if (!$isCheckedIn) {
      if (app(SystemSettings::class)->check_in) {
        $checkInService->checkIn($patient->id);
        $isCheckedIn = true;
      } else {
        return back()->with('check-in', 'Please Check-In the Patient');
      }
    }

    return view('patients.show', [
      'patient' => $patient,
      'blood_pressure' => $chart->build($patient->id),
      'pulse' => $pulse->build($patient->id),
      'temperature' => $temperature->build($patient->id),
      'weight' => $weight->build($patient->id),
      'outstanding_balance' => $outstanding_balance,
      'wallet_balance' => $wallet_balance,
      'isCheckedIn' => $isCheckedIn,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Patient  $patient
   * @return \Illuminate\Http\Response
   */
  public function edit(Patient $patient)
  {
    $ng = new NG();
    $states = $ng->states;
    $religions = Religion::all();
    $hmos = HmoGroup::all();
    $hospital_no = UniqueIdGenerator::generate(['table' => 'patients', 'length' => 4,]);
    return view('patients.edit', compact('religions', 'states', 'hmos', 'patient'));
  }

  public function draw(Patient $patient)
  {
    return view('patients.draw');
  }

  public function fundWalletView($patient)
  {
    $patient = Patient::find($patient);
    return view('patients.fund-wallet', compact('patient'));
  }

  public function fundWalletSave(Request $request)
  {
    $wallet = Wallet::firstOrCreate(
      ['patient_id' => $request->patient_id],
      ['balance' => 0]
    );

    $wallet->increment('balance', $request->amount);

    $wallet_transaction = \DB::table('wallet_transaction')->insert([
      'wallet_id' => $wallet->id,
      'transaction_type' => $request->transaction_type,
      'transaction_amount' => $request->amount,
      'transaction_id' => $request->reference ? $request->reference : 'OPTC-'.rand(100000,999999).time(),
      'created_at' => \Carbon\Carbon::now(),
      'updated_at' => \Carbon\Carbon::now()
    ]);
    return back()->with('success', 'Patient Wallet Funded Successfully');
  }


  public function checkIn($patient)
  {
    $checkInService = new CheckInService();
    if ($checkInService->hasCheckedInToday($patient)) {
      return back()->with('error', 'Patient has checked in already');
    } else {
      $checkIn = CheckIn::create([
        'patient_id' => $patient,
        'check_in_date' => now()->toDateString(),
      ]);
      return back()->with('success', 'Patient checked in Successfully');
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Patient  $patient
   * @return \Illuminate\Http\Response
   */

  public function update(Request $request, Patient $patient)
  {
    $userId = $patient->user->id;

    $userUpdateData = array_merge(
      $request->except(['date_of_birth', 'gender', 'password']),
      ['password' => bcrypt($request->password)]
    );

    $user = User::findOrFail($userId);
    $user->update($userUpdateData);
    $user->assignRole('patient');

    $patientUpdateData = $request->except([
      'password',
      'next_of_kin_name',
      'dependent',
      'next_of_kin_relation',
      'next_of_kin_phone',
      'next_of_kin_address'
    ]);

    $patient = Patient::where('user_id', $userId)->firstOrFail();
    $patient->update($patientUpdateData);

    $nextOfKinUpdateData = $request->only([
      'next_of_kin_name',
      'next_of_kin_relation',
      'next_of_kin_phone',
      'next_of_kin_address'
    ]);

//    $nextOfKin = NextOfKin::where('user_id', $userId)->firstOrFail();
//    $nextOfKin->update($nextOfKinUpdateData);
    return redirect()->route('app.patients.index')->with('success', 'Patient Updated Successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Patient  $patient
   * @return \Illuminate\Http\Response
   */
  public function destroy(Patient $patient)
  {
    //
  }
}
