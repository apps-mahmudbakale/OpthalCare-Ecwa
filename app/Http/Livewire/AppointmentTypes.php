<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use Livewire\Component;
use App\Models\AppointmentType;

class AppointmentTypes extends Base
{
  public $sortBy = 'name';
  public $AppointmentTypeId;
  public $AppointmentTypeName;
  public function selectAppointmentType(AppointmentType $appointment)
  {
    $this->AppointmentTypeId = $appointment->id;
    $this->AppointmentTypeName = $appointment->name;

    $this->dispatchBrowserEvent('AppointmentTypeEditModal');
  }

  public function updateAppointmentType()
  {
    AppointmentType::where('id', $this->AppointmentTypeId)->update(['name' => $this->AppointmentTypeName]);

    return redirect()->route('app.settings.consultations')->with('success', 'Appointment Type Updated !');
  }
  public function render()
  {
    if ($this->search) {
      $appointmentType = AppointmentType::query()
        ->where('date', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.appointment-types',
        ['appointmentType' => $appointmentType]
      );
    } else {
      $appointmentType = AppointmentType::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.appointment-types',
        ['appointmentType' => $appointmentType]
      );
    }
  }
}
