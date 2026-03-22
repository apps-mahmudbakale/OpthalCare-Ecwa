<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\HmoGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HmoBillingController extends Controller
{
    public function index(Request $request)
    {
        $hmoGroups = HmoGroup::all();
        $selectedHmoId = $request->hmo_id;
        $search = $request->search;

        $query = Billing::query()
            ->whereNotNull('plan_id')
            ->where('status', 0) // Only unpaid
            ->with(['patient.user', 'hmoPlan.hmo']);

        if ($selectedHmoId) {
            $query->whereHas('hmoPlan', function($q) use ($selectedHmoId) {
                $q->where('hmo_id', $selectedHmoId);
            });
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('patient.user', function($sq) use ($search) {
                    $sq->where('firstname', 'like', '%' . $search . '%')
                      ->orWhere('lastname', 'like', '%' . $search . '%');
                })->orWhere('service', 'like', '%' . $search . '%');
            });
        }

        $bills = $query->latest()->paginate(20)->withQueryString();

        return view('hmo-billing.index', compact('hmoGroups', 'bills', 'selectedHmoId', 'search'));
    }

    public function settle(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'bill_ids' => 'required|array',
            'bill_ids.*' => 'exists:billings,id',
            'clearance_codes' => 'nullable|array',
            'bulk_code' => 'nullable|string'
        ]);

        $billIds = $request->bill_ids;
        $serviceClearanceCodes = $request->clearance_codes ?? [];
        $bulkCode = $request->bulk_code;

        $bills = Billing::whereIn('id', $billIds)->with('hmoPlan.hmo')->get();

        if ($bills->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No valid bills found.'], 422);
        }

        // Ensure all selected bills belong to the same HMO Group
        $hmoGroupId = $bills->first()->hmoPlan->hmo_id;
        foreach ($bills as $bill) {
            if ($bill->hmoPlan->hmo_id !== $hmoGroupId) {
                return response()->json(['success' => false, 'message' => 'Selected bills must belong to the same HMO provider.'], 422);
            }
        }

        $totalAmount = $bills->sum('amount');
        $hmo = HmoGroup::find($hmoGroupId);
        $wallet = $hmo->getWallet();

        if ($wallet->balance < $totalAmount) {
            return response()->json(['success' => false, 'message' => 'Insufficient HMO wallet balance. Please fund the wallet first.'], 422);
        }

        try {
            DB::transaction(function () use ($wallet, $totalAmount, $bills, $serviceClearanceCodes, $bulkCode) {
                $wallet->debit($totalAmount, "Settlement for " . count($bills) . " bills via AJAX");

                foreach ($bills as $bill) {
                    $finalCode = $serviceClearanceCodes[$bill->id] ?? ($bulkCode ?: null);

                    if (empty($finalCode)) {
                        throw new \Exception("Clearance code is required for service: " . $bill->service . " (Patient: " . ($bill->patient->user->firstname ?? '') . ")");
                    }

                    $bill->update([
                        'status' => 1,
                        'clearance_code' => $finalCode
                    ]);
                }
            });

            return response()->json([
                'success' => true, 
                'message' => "Successfully settled " . count($bills) . " bills totaling ₦" . number_format($totalAmount, 2)
            ]);
        } catch (\Exception $e) {
            Log::error('HMO Settlement failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
