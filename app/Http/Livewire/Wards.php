<?php

namespace App\Http\Livewire;

use App\Models\Ward;
use Livewire\Component;

class Wards extends Base
{
  public $sortBy = 'name';
  public $WardId;
  public $WardName;

  public function selectWard(Ward $ward)
  {
    $this->WardId = $ward->id;
    $this->WardName = $ward->name;

    $this->dispatchBrowserEvent('WardEditModal');
  }

  public function updateWard()
  {
    Ward::where('id', $this->WardId)->update(['name' => $this->WardName]);

    redirect()->route('app.settings.admission')->with('success', 'Ward Updated');
  }
  public function render()
  {
    if ($this->search) {
      $wards = Ward::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.wards',
        ['wards' => $wards]
      );
    } else {
      $wards = Ward::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.wards',
        ['wards' => $wards]
      );
    }
  }
}
