<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admission;

class NursingNote extends Component
{
    use WithPagination;

    public $admissionId;
    public $note;

    protected $rules = [
        'note' => 'required|string',
    ];

    public function mount($admissionId)
    {
        $this->admissionId = $admissionId;
    }

    public function save()
    {
        $this->validate();

        $admission = Admission::find($this->admissionId);

        \App\Models\NursingNote::create([
            'admission_id' => $this->admissionId,
            'patient_id' => $admission->patient_id,
            'user_id' => auth()->id(),
            'note' => $this->note,
        ]);

        $this->reset('note');
        $this->dispatch('closeModal');
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Nursing note saved successfully.']);
    }

    public function render()
    {
        return view('livewire.nursing-note', [
            'notes' => \App\Models\NursingNote::where('admission_id', $this->admissionId)
                ->with('user')
                ->latest()
                ->paginate(10)
        ]);
    }
}
