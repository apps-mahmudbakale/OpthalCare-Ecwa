<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Department As DeptModel;

class Department extends Base
{
    public $sortBy = 'name';
    public $DeptId;
    public $DeptName;

    public function selectDept($id){
        $dept = DeptModel::find($id);

        $this->DeptId = $dept->id;
        $this->DeptName = $dept->name;

        $this->dispatchBrowserEvent('DeptEditModal');
    }

    public function updateDept(){
        DeptModel::where('id', $this->DeptId)->update(['name' => $this->DeptName]);
        
        redirect()->route('app.settings.index')->with('success', 'Department Updated');

    }
    public function render()
    {
        if ($this->search) {
            $departments = DeptModel::query()
                ->where('name', 'like', '%' . $this->search . '%')
                ->paginate(10);

            return view(
                'livewire.department',
                ['departments' => $departments]
            );
        } else {
            $departments = DeptModel::query()
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perPage);
            return view(
                'livewire.department',
                ['departments' => $departments]
            );
        }
    }
}
