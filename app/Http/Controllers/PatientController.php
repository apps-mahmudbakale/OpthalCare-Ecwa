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
    // Validation rules for all fields
    $rules = [
      'firstname' => 'required|string|max:255',
      'lastname' => 'required|string|max:255',
      // 'email' => 'required|email|unique:users,email',
      'phone' => 'required|string|max:20',
      'date_of_birth' => 'required|date',
      'gender' => 'required|in:Male,Female,Other',
       'religion_id' => 'required|integer',
      // 'next_of_kin_name' => 'required|string|max:255',
      // 'next_of_kin_relation' => 'required|string|max:255',
      // 'next_of_kin_phone' => 'required|string|max:20',
      // 'next_of_kin_address' => 'required|string|max:255',
      'marital_status' => 'required|string',
      'tribe' => 'required|string',
//      'occupation' => 'required|string',
//      'state_of_residence' => 'required|string',
//      'lga_of_residence' => 'required|string',
      // 'state_of_origin' => 'required|string',
      // 'lga_of_origin' => 'required|string',
//      'residential_address' => 'required|string',

      // Add more validation rules as needed
    ];

    // Custom validation messages
    $messages = [
      // Custom messages for each field
      'firstname.required' => 'The First Name field is required.',
      'lastname.required' => 'The Last Name field is required.',
      'email.required' => 'The email field is required.',
      'email.email' => 'The email must be a valid email address.',
      'email.unique' => 'The email has already been taken.',
      'phone.required' => 'The phone field is required.',
      'date_of_birth.required' => 'The date of birth field is required.',
      'gender.required' => 'The gender field is required.',
      // 'religion_id.required' => 'The religion field is required.',
      'next_of_kin_name.required' => 'The next of kin name field is required.',
      'next_of_kin_relation.required' => 'The next of kin relation field is required.',
      'next_of_kin_phone.required' => 'The next of kin phone field is required.',
      'next_of_kin_address.required' => 'The next of kin address field is required.',
      'marital_status.required' => 'The marital status field is required.',
      'occupation.required' => 'The occupation field is required.',
      'state_of_residence.required' => 'The state of residence field is required.',
      'lga_of_residence.required' => 'The lga of residence field is required.',
      'state_of_origin.required' => 'The state of origin field is required.',
      'lga_of_origin.required' => 'The lga of origin field is required.',
      'residential_address.required' => 'The residential address field is required.',
      // Add more custom messages as needed
    ];
    $validator = Validator::make($request->all(), $rules, $messages);

    // Check if validation fails
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->withInput();
    }
    $user = User::create(array_merge($request->except(['date_of_birth', 'gender', 'password']), ['password' => bcrypt($request->password)]));
    $user->assignRole('patient');
    $hospital_no = UniqueIdGenerator::generate(['table' => 'patients', 'length' => 4,]);
    $patient = Patient::create(array_merge($request->except(['password', 'next_of_kin_name', 'next_of_kin_relation', 'next_of_kin_phone', 'next_of_kin_address']), ['hospital_no' => $hospital_no, 'user_id' => $user->id]));
    $next_of_kin = NextOfKin::create(array_merge($request->only(['next_of_kin_name', 'next_of_kin_relation', 'next_of_kin_phone', 'next_of_kin_address']), ['patient_id' => $patient->id]));
    $billUpdate = Billing::where('user_id', $request->temp_id)->update(['user_id' => $patient->id]);
    $deleteTemp = TempPatient::where('id', $request->temp_id)->delete();
    $visit = Visit::create(['patient_id' => $patient->id, 'speciality' => 'Enrollement', 'status' => 'Concluded']);
    return redirect()->route('app.patients.index')->with('success', 'Patient Created Successfully');
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

    $nextOfKin = NextOfKin::where('user_id', $userId)->firstOrFail();
    $nextOfKin->update($nextOfKinUpdateData);
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
