<?php

namespace App\Livewire;

use App\Models\LabParameter as ModelsLabParameter;
use Livewire\Component;


class LabParameter extends Base
{
   public $sortBy = 'name';
  public $CategoryId;
  public $CategoryName;

  public function selectCategory(ModelsLabParameter $labCategory)
  {
    $this->CategoryId = $labCategory->id;
    $this->CategoryName = $labCategory->name;

    $this->dispatchBrowserEvent('LabCategoryEditModal');
  }

  public function updateCategory()
  {
    ModelsLabParameter::where('id', $this->CategoryId)->update(['name' => $this->CategoryName]);

    return redirect()->route('app.settings.laboratory')->with('success', 'Category Updated');
  }
  public function render()
  {
    if ($this->search) {
      $categories = ModelsLabParameter::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.lab-parameter',
        ['categories' => $categories]
      );
    } else {
      $categories = ModelsLabParameter::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.lab-parameter',
        ['categories' => $categories]
      );
    }
  }
}
