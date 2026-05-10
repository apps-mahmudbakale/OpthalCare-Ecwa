<?php

namespace App\Livewire;

use App\Models\AntenatalRecord;
use Livewire\Component;
use Livewire\WithPagination;

class AntenatalFollowups extends Component
{
    use WithPagination;

    public $patientId;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function mount($patientId)
    {
        $this->patientId = $patientId;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $followups = AntenatalRecord::where('patient_id', $this->patientId)
            ->where('visit_type', 'followup')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('followup_complaint', 'like', '%' . $this->search . '%')
                      ->orWhere('followup_treatment', 'like', '%' . $this->search . '%')
                      ->orWhere('followup_notes', 'like', '%' . $this->search . '%')
                      ->orWhere('height_of_fundus', 'like', '%' . $this->search . '%')
                      ->orWhere('presentation_and_position', 'like', '%' . $this->search . '%')
                      ->orWhere('fetal_heart', 'like', '%' . $this->search . '%')
                      ->orWhere('blood_pressure', 'like', '%' . $this->search . '%')
                      ->orWhere('urine', 'like', '%' . $this->search . '%')
                      ->orWhere('edema', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('visit_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.antenatal-followups', compact('followups'));
    }

    public function deleteFollowup($id)
    {
        $followup = AntenatalRecord::find($id);
        if ($followup && $followup->patient_id == $this->patientId) {
            $followup->delete();
            session()->flash('success', 'Follow-up record deleted successfully.');
        }
    }
}
