<?php

namespace App\Http\Livewire;

use App\Models\Bed;
use Livewire\Component;

class Beds extends Base
{
  public $sortBy = 'name';
  public $BedId;
  public $BedName;
  public $BedPrice;

  public function selectBed(Bed $bed)
  {
    $this->BedId = $bed->id;
    $this->BedName = $bed->name;
    $this->BedPrice = $bed->price;

    $this->dispatchBrowserEvent('BedEditModal');
  }

  public function updateBed()
  {
    Bed::where('id', $this->BedId)->update(['name' => $this->BedName, 'price' => $this->BedPrice]);

    return redirect()->route('app.settings.admission')->with('success', 'Ward Updated');
  }
  public function render()
  {
    if ($this->search) {
      $beds = Bed::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->where('price', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.beds',
        ['beds' => $beds]
      );
    } else {
      $beds = Bed::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.beds',
        ['beds' => $beds]
      );
    }
  }
}
