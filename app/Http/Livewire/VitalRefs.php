<?php

namespace App\Http\Livewire;

use App\Models\VitalRef;
use Livewire\Component;

class VitalRefs extends Base
{
  public $sortBy = 'name';
  public $Id;
  public $Name;
  public $Measurement;


  public function selectRef(VitalRef $ref)
  {
    $this->Id = $ref->id;
    $this->Name = $ref->name;
    $this->Measurement = $ref->measurement;

    $this->dispatchBrowserEvent('VitalRefEditModal');
  }

  public function updateRef()
  {
    VitalRef::where('id', $this->Id)->update(['name' => $this->Name, 'measurement' => $this->Measurement]);

    return redirect()->route('app.settings.index')->with('success', 'VitalRef Updated');
  }
  public function render()
  {
    if ($this->search) {
      $refs = VitalRef::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.vital-refs',
        ['refs' => $refs]
      );
    } else {
      $refs = VitalRef::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.vital-refs',
        ['refs' => $refs]
      );
    }
  }
}
