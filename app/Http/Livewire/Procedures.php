<?php

namespace App\Http\Livewire;

use App\Models\Procedure;
use Livewire\Component;

class Procedures extends Base
{
    public $sortBy = 'name';
    public $ProcedureId;
    public $ProcedureName;
    public $ProcedureCategory;
    public $ProcedureTemplate;
    public $ProcedurePrice;

    public function selectProcedure($id)
    {
        $procedure = Procedure::findOrFail($id);

        $this->ProcedureId        = $procedure->id;
        $this->ProcedureName      = $procedure->name;
        $this->ProcedureCategory  = $procedure->category_id;
        $this->ProcedureTemplate  = $procedure->template_id;
        $this->ProcedurePrice     = $procedure->price;

        $this->dispatchBrowserEvent('ProceduresTestEditModal');
    }

    public function updateProcedure()
    {
        Procedure::where('id', $this->ProcedureId)->update([
            'name'        => $this->ProcedureName,
            'category_id' => $this->ProcedureCategory,
            'template_id' => $this->ProcedureTemplate,
            'price'       => $this->ProcedurePrice
        ]);

        session()->flash('success', 'Procedure updated successfully.');

        return redirect()->route('app.settings.index');
    }

    public function render()
    {
        $tests = Procedure::query()
            ->when($this->search, fn ($q) =>
                $q->where('name', 'LIKE', '%' . $this->search . '%')
            )
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.procedures', [
            'tests' => $tests
        ]);
    }
}
