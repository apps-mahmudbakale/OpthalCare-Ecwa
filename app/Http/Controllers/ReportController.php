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
    $tab       = $request->get('tab', 'revenue');
    $date      = $request->get('date', '');
    $service   = $request->get('service', '');
    $cashpoint = $request->get('cashpoint', '');
    $method    = $request->get('method', '');
    $cashier   = $request->get('cashier', '');

    $cashPoints = CashPoint::all();
    $allCashiers = \App\Models\User::orderBy('firstname')->get();

    // Revenue tab
    $revenueQuery = Payment::query()->with(['billing', 'cashPoint'])
        ->when($service,   fn($q) => $q->whereHas('billing', fn($sq) =>
            $sq->whereRaw("LOWER(SUBSTRING_INDEX(service, ':', 1)) = ?", [strtolower($service)])))
        ->when($cashpoint, fn($q) => $q->where('cashpoint_id', $cashpoint))
        ->when($method,    fn($q) => $q->where('payment_method', $method))
        ->when($date,      fn($q) => $q->whereDate('created_at', $date))
        ->latest();
    $revenue = $revenueQuery->paginate(15, ['*'], 'rev_page')->withQueryString();

    // Cashpoints tab
    $cashpointRevenue = Payment::selectRaw('cashpoint_id, SUM(paying_amount) as total_revenue')
        ->when($cashier,   fn($q) => $q->where('user_id', $cashier))
        ->when($cashpoint, fn($q) => $q->where('cashpoint_id', $cashpoint))
        ->when($date,      fn($q) => $q->whereDate('created_at', $date))
        ->groupBy('cashpoint_id')
        ->with('cashPoint')
        ->get();

    // End of day tab
    $endDayRevenue = Payment::selectRaw('user_id, payment_method, SUM(paying_amount) as total')
        ->when($cashier, fn($q) => $q->where('user_id', $cashier))
        ->when($date,    fn($q) => $q->whereDate('created_at', $date))
        ->groupBy('user_id', 'payment_method')
        ->get()
        ->groupBy('user_id');

    $cashierUsers = \App\Models\User::whereIn('id', $endDayRevenue->keys()->all())->get()->keyBy('id');

    return view('report.billing', compact(
        'tab', 'date', 'service', 'cashpoint', 'method', 'cashier',
        'cashPoints', 'allCashiers', 'revenue', 'cashpointRevenue',
        'endDayRevenue', 'cashierUsers'
    ));
  }


  public function exportRevenue(Request $request)
  {
    $data = Payment::with(['billing', 'cashPoint'])
        ->when($request->service,   fn($q) => $q->whereHas('billing', fn($sq) =>
            $sq->whereRaw("LOWER(SUBSTRING_INDEX(service, ':', 1)) = ?", [strtolower($request->service)])))
        ->when($request->cashpoint, fn($q) => $q->where('cashpoint_id', $request->cashpoint))
        ->when($request->method,    fn($q) => $q->where('payment_method', $request->method))
        ->when($request->date,      fn($q) => $q->whereDate('created_at', $request->date))
        ->latest()->get();
    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\RevenueReportExport($data), 'revenue-report.xlsx');
  }

  public function exportCashpoint(Request $request)
  {
    $data = Payment::selectRaw('cashpoint_id, SUM(paying_amount) as total_revenue')
        ->when($request->cashier,   fn($q) => $q->where('user_id', $request->cashier))
        ->when($request->cashpoint, fn($q) => $q->where('cashpoint_id', $request->cashpoint))
        ->when($request->date,      fn($q) => $q->whereDate('created_at', $request->date))
        ->groupBy('cashpoint_id')->with('cashPoint')->get();
    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\CashpointExport($data), 'cashpoint-report.xlsx');
  }

  public function exportEndDay(Request $request)
  {
    $data = Payment::selectRaw('user_id, payment_method, SUM(paying_amount) as total')
        ->when($request->cashier, fn($q) => $q->where('user_id', $request->cashier))
        ->when($request->date,    fn($q) => $q->whereDate('created_at', $request->date))
        ->groupBy('user_id', 'payment_method')->with('user')->get();
    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\CashierSummaryExport($data), 'cashier-summary.xlsx');
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
