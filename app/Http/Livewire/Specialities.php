<?php

namespace App\Http\Livewire;

use App\Models\Speciality;
use Livewire\Component;

class Specialities extends Base
{
  public $sortBy = 'name';
  public $SpecialityId;
  public $SpecialityName;
  public $SpecialityPrice;
  public $SpecialityFollowUpPrice;

  public function selectSpeciality(Speciality $speciality)
  {
    $this->SpecialityId = $speciality->id;
    $this->SpecialityName = $speciality->name;
    $this->SpecialityPrice = $speciality->price;
    $this->SpecialityFollowUpPrice = $speciality->follow_up_price;

    $this->dispatchBrowserEvent('SpecialityEditModal');
  }

  public function updateSpeciality()
  {
    Speciality::where('id', $this->SpecialityId)->update(['name' => $this->SpecialityName, 'price' => $this->SpecialityPrice, 'follow_up_price' => $this->SpecialityFollowUpPrice]);

    return redirect()->route('app.settings.consultations')->with('success', 'Speciality Updated');
  }
  public function render()
  {
    if ($this->search) {
      $specialities = Speciality::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->where('price', 'like', '%' . $this->search . '%')
        ->where('follow_up_price', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.specialities',
        ['specialities' => $specialities]
      );
    } else {
      $specialities = Speciality::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.specialities',
        ['specialities' => $specialities]
      );
    }
  }
}
