<?php

namespace App\Http\Livewire;

use App\Models\ConsultingRoom;
use Livewire\Component;

class ConsultingRooms extends Base
{
  public $sortBy = 'name';
  public $ConsultingRoomId;
  public $ConsultingRoomName;

  public function selectConsultingRoom(ConsultingRoom $consultingRoom)
  {
    $this->ConsultingRoomId = $consultingRoom->id;
    $this->ConsultingRoomName = $consultingRoom->name;

    $this->dispatchBrowserEvent('ConsultingRoomEditModal');
  }

  public function updateConsultingRoom()
  {
    ConsultingRoom::where('id', $this->ConsultingRoomId)->update(['name' => $this->ConsultingRoomName]);

    return redirect()->route('app.settings.consultations')->with('success', 'Consulting Room Updated');
  }
  public function render()
  {
    if ($this->search) {
      $consultingRooms = ConsultingRoom::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.consulting-rooms',
        ['consultingRooms' => $consultingRooms]
      );
    } else {
      $consultingRooms = ConsultingRoom::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.consulting-rooms',
        ['consultingRooms' => $consultingRooms]
      );
    }
  }
}
