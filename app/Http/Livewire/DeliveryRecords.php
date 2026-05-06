<?php

namespace App\Http\Livewire;

use App\Models\Delivery;
use Livewire\Component;
use Livewire\WithPagination;

class DeliveryRecords extends Component
{
    use WithPagination;

    public $patientId;

    public function mount($patientId)
    {
        $this->patientId = $patientId;
    }

    public function delete($id)
    {
        Delivery::findOrFail($id)->delete();
        $this->emit('notify', ['type' => 'success', 'message' => 'Delivery record deleted.']);
    }

    public function render()
    {
        return view('livewire.delivery-records', [
            'deliveries' => Delivery::where('patient_id', $this->patientId)
                ->with(['user', 'antenatalRecord'])
                ->latest()
                ->paginate(10)
        ]);
    }
}
