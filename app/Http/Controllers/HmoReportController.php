<?php

namespace App\Http\Controllers;

use App\Exports\HmoReconciliationExport;
use App\Models\Billing;
use App\Models\HmoPlan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HmoReportController extends Controller
{
    public function analytics(Request $request)
    {
        $hmoId   = $request->get('hmo_id', '');
        $groupBy = $request->get('group_by', 'plan'); // plan | hmo

        $query = HmoPlan::with(['hmo'])
            ->withCount('patients as enrollees_count')
            ->withCount('billings as services_enjoyed_count')
            ->withSum('billings as total_billed', 'amount')
            ->withSum(['billings as outstanding_balance' => fn($q) => $q->where('status', 0)], 'amount')
            ->withSum(['billings as total_paid' => fn($q) => $q->where('status', 1)], 'amount');

        if ($hmoId) {
            $query->where('hmo_id', $hmoId);
        }

        $hmoPlans = $query->get();

        $totals = [
            'enrollees'   => $hmoPlans->sum('enrollees_count'),
            'services'    => $hmoPlans->sum('services_enjoyed_count'),
            'billed'      => $hmoPlans->sum('total_billed'),
            'outstanding' => $hmoPlans->sum('outstanding_balance'),
            'paid'        => $hmoPlans->sum('total_paid'),
        ];

        $hmoGroups = \App\Models\HmoGroup::orderBy('name')->get();

        return view('report.hmo-analytics', compact('hmoPlans', 'totals', 'hmoGroups', 'hmoId'));
    }

    public function reconciliation(Request $request)
    {
        $planId   = $request->filled('plan_id') ? (int)$request->get('plan_id') : null;
        $dateFrom = $request->filled('date_from') ? $request->get('date_from') : null;
        $dateTo   = $request->filled('date_to') ? $request->get('date_to') : null;
        $status   = $request->filled('status') ? (int)$request->get('status') : null;

        $plans = HmoPlan::with('hmo')->get();

        $query = Billing::query()
            ->whereNotNull('plan_id')
            ->with(['patient.user', 'hmoPlan.hmo'])
            ->when($planId,              fn($q) => $q->where('plan_id', $planId))
            ->when(!is_null($status),    fn($q) => $q->where('status', $status))
            ->when($dateFrom,            fn($q) => $q->whereDate('created_at', '>=', $dateFrom))
            ->when($dateTo,              fn($q) => $q->whereDate('created_at', '<=', $dateTo))
            ->latest();

        $bills = $query->paginate(20)->withQueryString();

        $summaryQuery = Billing::query()
            ->whereNotNull('plan_id')
            ->when($planId,           fn($q) => $q->where('plan_id', $planId))
            ->when(!is_null($status), fn($q) => $q->where('status', $status))
            ->when($dateFrom,         fn($q) => $q->whereDate('created_at', '>=', $dateFrom))
            ->when($dateTo,           fn($q) => $q->whereDate('created_at', '<=', $dateTo));

        $summary = [
            'total_billed'      => (clone $summaryQuery)->sum('amount'),
            'total_outstanding' => (clone $summaryQuery)->where('status', 0)->sum('amount'),
            'total_paid'        => (clone $summaryQuery)->where('status', 1)->sum('amount'),
            'total_services'    => (clone $summaryQuery)->count(),
        ];

        // Pass back as strings for the view (empty string = no filter selected)
        $planId   = $planId   ?? '';
        $dateFrom = $dateFrom ?? '';
        $dateTo   = $dateTo   ?? '';
        $status   = !is_null($status) ? (string)$status : '';

        return view('report.hmo-reconciliation', compact('plans', 'bills', 'summary', 'planId', 'dateFrom', 'dateTo', 'status'));
    }

    public function export(Request $request)
    {
        $planId   = $request->filled('plan_id') ? (int)$request->get('plan_id') : null;
        $dateFrom = $request->filled('date_from') ? $request->get('date_from') : null;
        $dateTo   = $request->filled('date_to') ? $request->get('date_to') : null;
        $status   = $request->filled('status') ? (int)$request->get('status') : null;

        $plan     = $planId ? HmoPlan::with('hmo')->find($planId) : null;
        $suffix   = !is_null($status) ? ($status ? '-paid' : '-unpaid') : '';
        $filename = $plan
            ? 'hmo-' . str()->slug($plan->hmo->name ?? 'group') . '-' . str()->slug($plan->name) . $suffix . '-reconciliation.xlsx'
            : 'hmo-all' . $suffix . '-reconciliation.xlsx';

        return Excel::download(new HmoReconciliationExport($planId, $dateFrom, $dateTo, $status), $filename);
    }
}
