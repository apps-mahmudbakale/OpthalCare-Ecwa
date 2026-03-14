<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HmoGroup;
use App\Models\HmoWallet;
use App\Models\HmoWalletTransaction;
use Livewire\WithPagination;

class HmoFinance extends Component
{
    use WithPagination;

    public $search = '';
    public $fundingAmount = 0;
    public $fundingDescription = 'Wallet Funding';
    public $selectedHmoId = null;
    public $selectedHmoName = '';
    public $historyTransactions = [];

    protected $rules = [
        'fundingAmount' => 'required|numeric|min:1',
        'fundingDescription' => 'required|string|max:255',
    ];

    public function selectHmo($id)
    {
        $this->selectedHmoId = $id;
        $this->fundingAmount = 0;
        $this->fundingDescription = 'Wallet Funding';
    }

    public function fundWallet()
    {
        $this->validate();

        $hmo = HmoGroup::find($this->selectedHmoId);
        if ($hmo) {
            $wallet = $hmo->getWallet();
            $wallet->credit($this->fundingAmount, $this->fundingDescription);
            
            $this->emit('closeModal');
            session()->flash('success', "Wallet for {$hmo->name} funded with ₦" . number_format($this->fundingAmount, 2));
            $this->reset(['fundingAmount', 'fundingDescription', 'selectedHmoId']);
        }
    }

    public function showHistory($id)
    {
        $hmo = HmoGroup::with('wallet.transactions')->find($id);
        if ($hmo) {
            $this->selectedHmoId = $id;
            $this->selectedHmoName = $hmo->name;
            $this->historyTransactions = $hmo->wallet ? $hmo->wallet->transactions()->latest()->get()->toArray() : [];
            $this->emit('openHistoryModal');
        }
    }

    public function render()
    {
        $hmos = HmoGroup::with('wallet')
            ->where('name', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.hmo-finance', compact('hmos'))
            ->extends('layouts.layoutMaster')
            ->section('content');
    }
}
