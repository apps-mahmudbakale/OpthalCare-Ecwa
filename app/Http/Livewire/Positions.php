<?php

namespace App\Http\Livewire;

use App\Models\Position;
use Livewire\Component;

class Positions extends Base
{
    public $sortBy = 'name';
    public $PositionId;
    public $PositionName;

    public function selectPosition($id){
        $doc = Position::find($id);

        $this->PositionId = $doc->id;
        $this->PositionName = $doc->name;

        $this->dispatchBrowserEvent('PositionEditModal');
    }

    public function updatePosition(){
        Position::where('id', $this->PositionId)->update(['name' => $this->PositionName]);
        
        redirect()->route('app.settings.index')->with('success', 'Position Updated');

    }
    public function render()
    {
        if ($this->search) {
            $positions = Position::query()
                ->where('name', 'like', '%' . $this->search . '%')
                ->paginate(10);

            return view(
                'livewire.positions',
                ['positions' => $positions]
            );
        } else {
            $positions = Position::query()
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perPage);
            return view(
                'livewire.positions',
                ['positions' => $positions]
            );
        }
    }
}
