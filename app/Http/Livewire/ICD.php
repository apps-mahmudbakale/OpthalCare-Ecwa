<?php

namespace App\Http\Livewire;

use App\Models\ICD10;
use Livewire\Component;

class ICD extends Base
{
  public $sortBy = 'name';
  public $Id;
  public $Name;
  public $Number;
  public $Group;


  public function selectICD(ICD10 $icd)
  {
    $this->Id = $icd->id;
    $this->Name = $icd->name;
    $this->Number = $icd->number;
    $this->Group = $icd->group;

    $this->dispatchBrowserEvent('ICD10EditModal');
  }

  public function updateICD()
  {
    ICD10::where('id', $this->Id)->update(['name' => $this->Name, 'number' => $this->Number, 'group' => $this->Group]);

    return redirect()->route('app.settings.index')->with('success', 'ICD Updated');
  }
  public function render()
  {
    if ($this->search) {
      $icds = ICD10::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.i-c-d',
        ['icds' => $icds]
      );
    } else {
      $icds = ICD10::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.i-c-d',
        ['icds' => $icds]
      );
    }
  }
}
