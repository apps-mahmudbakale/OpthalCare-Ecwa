<?php

namespace App\Http\Controllers;

use App\Models\HmoGroup;
use Illuminate\Http\Request;

class HmoFinanceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $hmos = HmoGroup::with('wallet')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->paginate(15)
            ->withQueryString();

        return view('hmo.finance', compact('hmos', 'search'));
    }

    public function fund(Request $request, HmoGroup $hmo)
    {
        $request->validate([
            'amount'      => 'required|numeric|min:1',
            'description' => 'required|string|max:255',
        ]);

        $wallet = $hmo->getWallet();
        $wallet->credit($request->amount, $request->description);

        return back()->with('success', "Wallet for {$hmo->name} funded with ₦" . number_format($request->amount, 2));
    }

    public function history(HmoGroup $hmo)
    {
        $transactions = $hmo->getWallet()->transactions()->latest()->paginate(20);
        return view('hmo.finance-history', compact('hmo', 'transactions'));
    }
}
