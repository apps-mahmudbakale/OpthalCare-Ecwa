<?php

namespace App\Http\Livewire;

use App\Models\PaymentMethod;
use Livewire\Component;

class PaymentMethods extends Base
{
    public $sortBy = 'name';
    public $PaymentMethodId;
    public $PaymentMethodName;

    public function selectMethod($id)
    {
        $paymentMethod = PaymentMethod::find($id);
        $this->PaymentMethodId = $paymentMethod->id;
        $this->PaymentMethodName = $paymentMethod->name;
        $this->dispatchBrowserEvent('PaymentMethodEditModal');
    }

    public function updateMethod()
    {
        PaymentMethod::where('id', $this->PaymentMethodId)->update([
            'name' => $this->PaymentMethodName,
        ]);

        redirect()->route('app.settings.index')->with('success', 'Payment Method Updated');
    }

    public function render()
    {
        if ($this->search) {
            $methods = PaymentMethod::query()
                ->where('name', 'like', '%' . $this->search . '%')
                ->paginate(10);

            return view(
                'livewire.payment-methods',
                ['methods' => $methods]
            );
        } else {
            $methods = PaymentMethod::query()
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perPage);
            return view(
                'livewire.payment-methods',
                ['methods' => $methods]
            );
        }
    }
}
