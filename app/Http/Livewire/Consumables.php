<?php

namespace App\Http\Livewire;

use App\Models\Consumable;
use Livewire\Component;

class Consumables extends Base
{
    public $sortBy = 'name';
    public $ConsumableId;
    public $ConsumableName;
    public $ConsumableCategory;
    public $ConsumablePrice;


    public function selectConsumables($id)
    {
        $test = Consumable::find($id);


        $this->ConsumableId = $test->id;
        $this->ConsumableName = $test->name;
        $this->ConsumableCategory = $test->category_id;
        $this->ConsumablePrice = $test->price;


        $this->dispatchBrowserEvent('ConsumablesEditModal');
    }

    public function updateConsumables()
    {
        Consumable::where('id', $this->ConsumableId)->update(['name' => $this->ConsumableName, 'category_id' => $this->ConsumableCategory,  'price' => $this->ConsumablePrice]);

        redirect()->route('app.settings.index')->with('success', 'Consumables Updated');
    }
    public function render()
    {
        if ($this->search) {
            $tests = Consumable::query()
                ->where('name', 'like', '%' . $this->search . '%')
                ->paginate(10);

            return view(
                'livewire.consumables',
                ['tests' => $tests]
            );
        } else {
            $tests = Consumable::query()
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perPage);
            return view(
                'livewire.consumables',
                ['tests' => $tests]
            );
        }
    }
}
