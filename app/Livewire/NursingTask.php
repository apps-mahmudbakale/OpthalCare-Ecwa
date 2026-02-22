<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admission;

class NursingTask extends Component
{
    use WithPagination;

    public $admissionId;
    public $task;

    protected $rules = [
        'task' => 'required|string',
    ];

    public function mount($admissionId)
    {
        $this->admissionId = $admissionId;
    }

    public function save()
    {
        $this->validate();

        $admission = Admission::find($this->admissionId);

        \App\Models\NursingTask::create([
            'admission_id' => $this->admissionId,
            'patient_id' => $admission->patient_id,
            'user_id' => auth()->id(),
            'task' => $this->task,
            'status' => 'Pending'
        ]);

        $this->reset('task');
        $this->dispatch('closeModal');
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Nursing task added successfully.']);
    }

    public function toggleStatus($taskId)
    {
        $task = \App\Models\NursingTask::find($taskId);
        $task->status = $task->status == 'Completed' ? 'Pending' : 'Completed';
        $task->save();
    }

    public function render()
    {
        return view('livewire.nursing-task', [
            'tasks' => \App\Models\NursingTask::where('admission_id', $this->admissionId)
                ->with('user')
                ->latest()
                ->paginate(10)
        ]);
    }
}
