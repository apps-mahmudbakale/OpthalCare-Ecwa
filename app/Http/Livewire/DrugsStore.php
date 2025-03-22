<?php

namespace App\Http\Livewire;

use App\Models\DrugStore;
use Livewire\Component;

class DrugsStore extends Base
{
  public $sortBy = 'name';
  public $StoreId;
  public $StoreName;


  public function selectStore(DrugStore $drugCategory)
  {
    $this->StoreId = $drugCategory->id;
    $this->StoreName = $drugCategory->name;

    $this->dispatchBrowserEvent('DrugStoreEditModal');
  }

  public function updateStore()
  {
    DrugStore::where('id', $this->StoreId)->update(['name' => $this->StoreName]);

    return redirect()->route('app.settings.pharmacy')->with('success', 'Store Updated');
  }
  public function render()
  {
    if ($this->search) {
      $stores = DrugStore::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.drugs-store',
        ['stores' => $stores]
      );
    } else {
      $stores = DrugStore::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.drugs-store',
        ['stores' => $stores]
      );
    }
  }
}
