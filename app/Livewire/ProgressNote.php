<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admission;

class ProgressNote extends Component
{
    use WithPagination;

    public $admissionId;
    public $procedureRequestId;
    public $note;

    protected $rules = [
        'note' => 'required|string',
    ];

    public function mount($admissionId = null, $procedureRequestId = null)
    {
        $this->admissionId = $admissionId;
        $this->procedureRequestId = $procedureRequestId;
    }

    public function save()
    {
        $this->validate();

        $patient_id = null;
        if ($this->admissionId) {
            $patient_id = Admission::find($this->admissionId)->patient_id;
        } elseif ($this->procedureRequestId) {
            $patient_id = \App\Models\ProcedureRequest::find($this->procedureRequestId)->patient_id;
        }

        \App\Models\ProgressNote::create([
            'admission_id' => $this->admissionId,
            'procedure_request_id' => $this->procedureRequestId,
            'patient_id' => $patient_id,
            'user_id' => auth()->id(),
            'note' => $this->note,
        ]);

        $this->reset('note');
        $this->emit('closeModal');
        $this->emit('notify', ['type' => 'success', 'message' => 'Progress note saved successfully.']);
    }

    public function render()
    {
        $query = \App\Models\ProgressNote::query()->with('user');

        if ($this->admissionId) {
            $query->where('admission_id', $this->admissionId);
        } elseif ($this->procedureRequestId) {
            $query->where('procedure_request_id', $this->procedureRequestId);
        }

        return view('livewire.progress-note', [
            'notes' => $query->latest()->paginate(10)
        ]);
    }
}
