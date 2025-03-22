<?php

namespace App\Http\Livewire;

use App\Models\CashPoint;
use Livewire\Component;

class Cashpoints extends Base
{
  public $sortBy = 'name';
  public $Id;
  public $Name;
  public $Location;


  public function selectPoint(CashPoint $point)
  {
    $this->Id = $point->id;
    $this->Name = $point->name;
    $this->Location = $point->location;

    $this->dispatchBrowserEvent('VitalRefEditModal');
  }

  public function updatePoint()
  {
    CashPoint::where('id', $this->Id)->update(['name' => $this->Name, 'location' => $this->Location]);

    return redirect()->route('app.settings.index')->with('success', 'CashPoint Updated');
  }
  public function render()
  {
    if ($this->search) {
      $points = CashPoint::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.cashpoints',
        ['points' => $points]
      );
    } else {
      $points = CashPoint::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.cashpoints',
        ['points' => $points]
      );
    }
  }
}
