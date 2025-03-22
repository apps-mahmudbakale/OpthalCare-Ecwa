<?php

namespace App\Http\Livewire;

use App\Models\Drug;
use Livewire\Component;

class Drugs extends Base
{
  public $sortBy = 'name';
  public $DrugId;
  public $DrugName;
  public $DrugCategory;
  public $DrugPrice;


  public function selectDrugs($id)
  {
    $test = Drug::find($id);
    

    $this->DrugId = $test->id;
    $this->DrugName = $test->name;
    $this->DrugCategory = $test->category_id;
    $this->DrugPrice = $test->price;

    
    $this->dispatchBrowserEvent('DrugsEditModal');
  }

  public function updateDrugs()
  {
    Drug::where('id', $this->DrugId)->update(['name' => $this->DrugName, 'category_id' => $this->DrugCategory,  'price' => $this->DrugPrice]);

    redirect()->route('app.settings.index')->with('success', 'Drugs Updated');
  }
  public function render()
  {
    if ($this->search) {
      $tests = Drug::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.drugs',
        ['tests' => $tests]
      );
    } else {
      $tests = Drug::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.drugs',
        ['tests' => $tests]
      );
    }
  }
}
