<?php

namespace App\Http\Livewire;

use App\Models\Antenatal;
use Livewire\Component;

class Antenatals extends Base
{
  public $sortBy = 'name';
  public $AntenatalId;
  public $AntenatalName;
  public $AntenatalPrice;

  public function selectAntenatal(Antenatal $antenatal)
  {
    $this->AntenatalId = $antenatal->id;
    $this->AntenatalName = $antenatal->name;
    $this->AntenatalPrice = $antenatal->price;

    $this->dispatchBrowserEvent('AntenatalEditModal');
  }

  public function updateAntenatal()
  {
    Antenatal::where('id', $this->AntenatalId)->update(['name' => $this->AntenatalName, 'price' => $this->AntenatalPrice]);

    return redirect()->route('app.settings.antenatal')->with('success', 'Package Updated');
  }
  public function render()
  {
    if ($this->search) {
      $antenatals = Antenatal::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->where('price', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.antenatals',
        ['antenatals' => $antenatals]
      );
    } else {
      $antenatals = Antenatal::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.antenatals',
        ['antenatals' => $antenatals]
      );
    }
  }
}
