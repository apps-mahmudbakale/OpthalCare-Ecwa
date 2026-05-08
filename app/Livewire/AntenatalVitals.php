<?php

namespace App\Livewire;

use App\Models\Vitals;
use Livewire\Component;
use Livewire\WithPagination;

class AntenatalVitals extends Component
{
    use WithPagination;

    public $patientId;

    public function mount($patientId)
    {
        $this->patientId = $patientId;
    }

    public function delete($id)
    {
        Vitals::findOrFail($id)->delete();
        $this->emit('notify', ['type' => 'success', 'message' => 'Vital record deleted.']);
    }

    public function render()
    {
        $vitals = Vitals::where('patient_id', $this->patientId)
            ->latest()
            ->paginate(20);

        // Group vitals by date for better display
        $groupedVitals = $vitals->getCollection()->groupBy(function($vital) {
            return $vital->created_at->format('Y-m-d');
        });

        return view('livewire.antenatal-vitals', [
            'vitals' => $vitals,
            'groupedVitals' => $groupedVitals
        ]);
    }
}
