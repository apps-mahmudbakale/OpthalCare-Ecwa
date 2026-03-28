<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admission;

class NursingTask extends Component
{
    use WithPagination;

    public $admissionId;
    public $procedureRequestId;
    public $task;

    protected $rules = [
        'task' => 'required|string',
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

        \App\Models\NursingTask::create([
            'admission_id' => $this->admissionId,
            'procedure_request_id' => $this->procedureRequestId,
            'patient_id' => $patient_id,
            'user_id' => auth()->id(),
            'task' => $this->task,
            'status' => 'Pending'
        ]);

        $this->reset('task');
        $this->emit('closeModal');
        $this->emit('notify', ['type' => 'success', 'message' => 'Nursing task added successfully.']);
    }

    public function toggleStatus($taskId)
    {
        $task = \App\Models\NursingTask::find($taskId);
        $task->status = $task->status == 'Completed' ? 'Pending' : 'Completed';
        $task->save();
    }

    public function render()
    {
        $query = \App\Models\NursingTask::query()->with('user');

        if ($this->admissionId) {
            $query->where('admission_id', $this->admissionId);
        } elseif ($this->procedureRequestId) {
            $query->where('procedure_request_id', $this->procedureRequestId);
        }

        return view('livewire.nursing-task', [
            'tasks' => $query->latest()->paginate(10)
        ]);
    }
}
