<?php

namespace App\Livewire;

use App\Models\AntenatalRecord;
use Livewire\Component;
use Livewire\WithPagination;

class AntenatalRecords extends Component
{
    use WithPagination;

    public $patientId;

    public function mount($patientId)
    {
        $this->patientId = $patientId;
    }

    public function delete($id)
    {
        AntenatalRecord::findOrFail($id)->delete();
        $this->emit('notify', ['type' => 'success', 'message' => 'Record deleted.']);
    }

    public function render()
    {
        return view('livewire.antenatal-records', [
            'records' => AntenatalRecord::where('patient_id', $this->patientId)
                ->with('user')
                ->latest()
                ->paginate(10),
        ]);
    }
}
