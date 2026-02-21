<?php

namespace App\Http\Controllers;

use App\Models\CashPoint;
use App\Models\Drug;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $paymentData = Payment::select(
      'cash_points.name as cash_point_name',
      DB::raw('SUM(payments.paying_amount) as total_revenue')
    )
      ->join('cash_points', 'payments.cashpoint_id', '=', 'cash_points.id')
      ->groupBy('cash_points.name')
      ->orderBy('cash_points.name')
      ->get();

    // Prepare data for chart
    $cashPointNames = $paymentData->pluck('cash_point_name')->values()->all();

    $paymentSeries = $paymentData->pluck('total_revenue')->map(function ($item) {
      return floatval($item);
    })->all();

    $today = now()->toDateString(); // Current date in 'Y-m-d' format

    // Fetch patients who registered today
    $patientTodayCount = Patient::whereDate('created_at', $today)->count();
    $patientsCount = Patient::count();
    $expiredDrugs = Drug::where('expiry_date', '<=', $today)->count();
    $lowStock = Drug::whereColumn('quantity', '<=', 'threshold')->count();

//    dd(compact('patientTodayCount', 'patientsCount', 'expiredDrugsCount', 'lowStockCount'));




    return view('report.index', compact('patientTodayCount', 'patientsCount', 'expiredDrugs', 'lowStock', 'cashPointNames',
      'paymentSeries'));

  }

  public function generalReport(Request $request)
  {
    $tab = $request->input('tab', 'visits');
    $from = $request->input('from');
    $to   = $request->input('to');

    // ---------- Visits (Check-Ins) ----------
    $visitsQuery = \App\Models\CheckIn::with('patient.user')
      ->when($request->cleared !== null && $request->cleared !== '', fn ($q) => $q->where('cleared', $request->cleared))
      ->when($from, fn ($q) => $q->whereDate('check_in_date', '>=', $from))
      ->when($to,   fn ($q) => $q->whereDate('check_in_date', '<=', $to))
      ->latest('check_in_date');

    $visits = $visitsQuery->paginate(15, ['*'], 'visits_page')->withQueryString();

    // ---------- Diagnoses ----------
    $specialties = \App\Models\Diagnosis::select('specialty')->distinct()->pluck('specialty');

    $diagnosesQuery = \App\Models\Diagnosis::with(['patient.user', 'user'])
      ->when($request->specialty, fn ($q) => $q->where('specialty', $request->specialty))
      ->when($from, fn ($q) => $q->whereDate('created_at', '>=', $from))
      ->when($to,   fn ($q) => $q->whereDate('created_at', '<=', $to))
      ->latest();

    $diagnoses = $diagnosesQuery->paginate(15, ['*'], 'diag_page')->withQueryString();

    // ---------- Admissions ----------
    $wards = \App\Models\Ward::pluck('name', 'id');

    $admissionsQuery = \App\Models\Admission::with(['patient.user', 'ward'])
      ->when($request->ward_id,  fn ($q) => $q->where('ward_id', $request->ward_id))
      ->when($request->adm_status, fn ($q) => $q->where('status', $request->adm_status))
      ->when($from, fn ($q) => $q->whereDate('created_at', '>=', $from))
      ->when($to,   fn ($q) => $q->whereDate('created_at', '<=', $to))
      ->latest();

    $admissions = $admissionsQuery->paginate(15, ['*'], 'adm_page')->withQueryString();

    return view('report.general', compact(
      'tab', 'visits', 'diagnoses', 'specialties', 'admissions', 'wards', 'from', 'to'
    ));
  }


  public function pharmacyReport(Request $request)
  {
    $lowstock = Drug::whereColumn('quantity', '<=', 'threshold')->get();
    $all = Drug::all();
    return view('report.pharmacy', compact('lowstock', 'all'));
  }

  public function labReport(Request $request)
  {
    return view('report.lab');
  }

  public function radiologyReport(Request $request)
  {
    return view('report.radiology');
  }

  public function procedureReport(Request $request)
  {
    return view('report.procedure');
  }

  public function billingReport(Request $request)
  {
    return view('report.billing');
  }


  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
