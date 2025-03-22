<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use Livewire\Component;

class Appointments extends Base
{
    public $sortBy = 'date';
    public $DeptId;
    public $DeptName;

    // public function selectDept($id){
    //     $dept = Appointment::find($id);

    //     $this->DeptId = $dept->id;
    //     $this->DeptName = $dept->name;

    //     $this->dispatchBrowserEvent('DeptEditModal');
    // }

    // public function updateDept(){
    //     Appointment::where('id', $this->DeptId)->update(['name' => $this->DeptName]);
        
    //     redirect()->route('app.settings.index')->with('success', 'Department Updated');

    // }
    public function render()
    {
        if ($this->search) {
            $appointments = Appointment::query()
                ->where('date', 'like', '%' . $this->search . '%')
                ->paginate(10);

            return view(
                'livewire.appointments',
                ['appointments' => $appointments]
            );
        } else {
            $appointments = Appointment::query()
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perPage);
            return view(
                'livewire.appointments',
                ['appointments' => $appointments]
            );
        }
    }
}
