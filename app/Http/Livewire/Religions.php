<?php

namespace App\Http\Livewire;

use App\Models\Religion;
use Livewire\Component;

class Religions extends Base
{
    public $sortBy = 'name';
    public $ReligionId;
    public $ReligionName;

    public function selectReligion($id){
        $doc = Religion::find($id);

        $this->ReligionId = $doc->id;
        $this->ReligionName = $doc->name;

        $this->dispatchBrowserEvent('ReligionEditModal');
    }

    public function updateReligion(){
        Religion::where('id', $this->ReligionId)->update(['name' => $this->ReligionName]);
        
        redirect()->route('app.settings.index')->with('success', 'Religion Updated');

    }
    public function render()
    {
        if ($this->search) {
            $religions = Religion::query()
                ->where('name', 'like', '%' . $this->search . '%')
                ->paginate(10);

            return view(
                'livewire.religions',
                ['religions' => $religions]
            );
        } else {
            $religions = Religion::query()
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perPage);
            return view(
                'livewire.religions',
                ['religions' => $religions]
            );
        }
    }
}
