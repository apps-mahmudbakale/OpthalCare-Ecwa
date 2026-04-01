<?php

namespace App\Http\Controllers;

use App\Models\PatientTags;
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
  public function index(Request $request)
  {
    $search       = $request->get('search', '');
    $filterGender = $request->get('gender', '');
    $filterTag    = $request->get('tag', '');
    $filterAge    = $request->get('age', '');
    $filterHmo    = $request->get('hmo_plan_id', '');

    $query = Patient::query()->with('user', 'hmoPlan.hmo');

    if ($search) {
      $query->join('users', 'patients.user_id', '=', 'users.id')
        ->where(function ($q) use ($search) {
          $q->where('patients.hospital_no', 'like', "%$search%")
            ->orWhere('patients.phone', 'like', "%$search%")
            ->orWhere('users.firstname', 'like', "%$search%")
            ->orWhere('users.lastname', 'like', "%$search%")
            ->orWhere('patients.middlename', 'like', "%$search%");
        })->select('patients.*');
    }

    if ($filterGender) {
      $query->where('patients.gender', $filterGender);
    }

    if ($filterTag) {
      $query->whereHas('tags', fn($q) => $q->where('tag_id', $filterTag));
    }

    if ($filterAge) {
      $age      = (int) $filterAge;
      $fromDate = \Carbon\Carbon::now()->subYears($age + 1)->addDay();
      $toDate   = \Carbon\Carbon::now()->subYears($age);
      $query->whereBetween('patients.date_of_birth', [$fromDate, $toDate]);
    }

    if ($filterHmo) {
      $query->where('patients.hmo_plan_id', $filterHmo);
    }

    $patients  = $query->orderBy('patients.hospital_no', 'desc')->paginate(20)->withQueryString();
    $tags      = \App\Models\Tag::all();
    $hmoPlans  = \App\Models\HmoPlan::with('hmo')->get();

    return view('patients.index', compact('patients', 'tags', 'hmoPlans', 'search', 'filterGender', 'filterTag', 'filterAge', 'filterHmo'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $ng = new NG();
    $states = $ng->states;
    $religions = Religion::all();
    $hmos = \App\Models\HmoPlan::all();

    $data = null;
    if (!empty($request->data)) {
        $data = json_decode(base64_decode($request->data));
    }

    return view('patients.create', compact('religions', 'states', 'hmos', 'data'));
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

    // Auto check-in after paid registration — already paid so mark as cleared
    $checkInService = new CheckInService();
    if (!$checkInService->hasCheckedInToday($patient->id)) {
        CheckIn::create([
            'patient_id'     => $patient->id,
            'check_in_date'  => now()->toDateString(),
            'cleared'        => true,
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
        $checkInFee = (float)(app(SystemSettings::class)->checkin_fee ?? 0);
        
        if ($checkInFee > 0) {
            // For auto check-in, if fee is required, don't auto check-in. Tell them to use manual checkin button
            return back()->with('check-in', 'Check-In fee required. Please click the Check-In button to initiate billing.');
        } else {
            $checkInService->checkIn($patient->id);
            $isCheckedIn = true;
        }
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
    $hmos = \App\Models\HmoPlan::all();
    $hospital_no = UniqueIdGenerator::generate(['table' => 'patients', 'length' => 4,]);
    return view('patients.edit', compact('religions', 'states', 'hmos', 'patient'));
  }

  public function draw(Patient $patient)
  {
    return view('patients.draw');
  }

  public function tag($patient){
    $patient = Patient::find($patient);
    return view('patients.add_tag', compact('patient'));
  }

  public function addTag(Request $request)
  {
    // Validate the incoming request data
    $validated = $request->validate([
      'patient_id' => 'required|exists:patients,id',
      'tag_id' => 'required|exists:tags,id', // Ensure tag exists in the tags table
    ]);

    // Check if the tag already exists for this patient
    $existingTag = PatientTags::where('patient_id', $validated['patient_id'])
      ->where('tag_id', $validated['tag_id'])
      ->first();

    if ($existingTag) {
      // If the tag exists, you can choose to update or ignore it
      // For now, we are just ignoring the tag addition if it already exists
      return redirect()
        ->route('app.patients.index')
        ->with('info', 'Tag already assigned to the patient.');
    }

    // If the tag doesn't exist, add the new tag
    PatientTags::create([
      'patient_id' => $validated['patient_id'],
      'tag_id' => $validated['tag_id'],
    ]);

    return redirect()
      ->route('app.patients.index')
      ->with('success', 'Tag added successfully.');
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
    }

    $system = app(SystemSettings::class);
    $checkInFee = (float)($system->checkin_fee ?? 0);

    $patientModel = \App\Models\Patient::with('hmoPlan')->find($patient);

    // If there is no global fee configured, we must check if the HMO plan requires one
    if ($checkInFee <= 0) {
        if ($patientModel && $patientModel->hmoPlan && $patientModel->hmoPlan->enrollment_amount > 0) {
            $checkInFee = (float)$patientModel->hmoPlan->enrollment_amount;
        } else {
            CheckIn::create([
                'patient_id' => $patient,
                'check_in_date' => now()->toDateString(),
                'cleared' => true
            ]);
            return back()->with('success', 'Patient checked in Successfully');
        }
    }

    // Check if they already have a pending checkin today to avoid duplicate bills
    $existingPending = CheckIn::where('patient_id', $patient)
                              ->whereDate('check_in_date', today())
                              ->first();

    if ($existingPending && !$existingPending->cleared) {
       return back()->with('error', 'Patient already has a pending check-in. Please clear the pending bill.');
    }

    // Handle HMO Patients
    if ($patientModel && $patientModel->hmo_plan_id) {
        \DB::beginTransaction();
        try {
            // Create cleared checkin for HMO patient
            CheckIn::create([
                'patient_id' => $patient,
                'check_in_date' => now()->toDateString(),
                'cleared' => true
            ]);

            // Create unpaid billing record for check-in fee, mapped to their HMO plan
            Billing::create([
                'service' => 'Consultation / Check-In Fee',
                'service_id' => 0, // 0 or null for check-in
                'user_id' => $patient,
                'quantity' => 1,
                'amount' => $checkInFee, // Fetched from HMO specific fee if global is 0
                'bill_ref' => str()->random(6),
                'status' => 0, // Unpaid
                'payer_id' => $patient,
                'plan_id' => $patientModel->hmo_plan_id,
            ]);

            \DB::commit();
            return back()->with('success', 'Patient checked in successfully via HMO Plan.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Failed to initiate HMO check-in: ' . $e->getMessage());
        }
    }

    // Handle Private/Non-HMO Patients
    \DB::beginTransaction();
    try {
        // Create pending checkin
        $checkIn = CheckIn::create([
          'patient_id' => $patient,
          'check_in_date' => now()->toDateString(),
          'cleared' => false
        ]);

        // Create billing record for check-in fee
        Billing::create([
          'service' => 'Consultation / Check-In Fee',
          'service_id' => 0, // 0 or null for check-in
          'user_id' => $patient,
          'quantity' => 1,
          'amount' => $checkInFee,
          'bill_ref' => str()->random(6),
          'status' => 0, // Unpaid
          'payer_id' => $patient,
        ]);

        \DB::commit();
        return back()->with('error', 'Check-In initiated. Patient must pay the consultation fee of ₦' . number_format($checkInFee, 2) . ' to receive a clearance code.');
    } catch (\Exception $e) {
        \DB::rollBack();
        return back()->with('error', 'Failed to initiate check-in: ' . $e->getMessage());
    }
  }

  /**
   * Approves a pending check-in using the cashier's clearance code.
   */
  public function approveCheckIn(Request $request, $patient)
  {
      $request->validate([
          'clearance_code' => 'required|string'
      ]);

      // Find the pending checkin record
      $checkIn = CheckIn::where('patient_id', $patient)
                        ->whereDate('check_in_date', today())
                        ->where('cleared', false)
                        ->first();

      if (!$checkIn) {
          return back()->with('error', 'No pending check-in found for this patient today.');
      }

      // Verify clearance code
      if (strtoupper($checkIn->clearance_code) !== strtoupper($request->clearance_code)) {
          return back()->with('error', 'Invalid clearance code.');
      }

      // Mark as cleared
      $checkIn->update(['cleared' => true]);

      return back()->with('success', 'Patient checked in Successfully with Clearance Code!');
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
      $request->except(['date_of_birth', 'gender', 'password', 'tags']), // exclude tags
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
      'next_of_kin_address',
      'tags' // exclude tags from patient update
    ]);

    $patient = Patient::where('user_id', $userId)->firstOrFail();
    $patient->update($patientUpdateData);

    // Update Next of Kin
    $nextOfKinUpdateData = $request->only([
      'next_of_kin_name',
      'next_of_kin_relation',
      'next_of_kin_phone',
      'next_of_kin_address'
    ]);

    // Update or create Next of Kin if any field is provided
    if (!empty(array_filter($nextOfKinUpdateData))) {
      NextOfKin::updateOrCreate(
        ['patient_id' => $patient->id],
        $nextOfKinUpdateData
      );
    }

    // Update patient tags
    if ($request->has('tag_ids')) {
      // Detach all current tags and re-attach the new ones
      PatientTags::where('patient_id', $patient->id)->delete();

      foreach ($request->tag_ids as $tagId) {
        PatientTags::create([
          'patient_id' => $patient->id,
          'tag_id' => $tagId,
        ]);
      }
    } else{
      PatientTags::where('patient_id', $patient->id)->delete();
    }

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
