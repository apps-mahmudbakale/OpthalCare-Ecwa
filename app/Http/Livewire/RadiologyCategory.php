<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\RadiologyCategory as ModelCategory;

class RadiologyCategory extends Base
{
  public $sortBy = 'name';
  public $CategoryId;
  public $CategoryName;


  public function selectCategory(ModelCategory $radiologyCategory)
  {
    $this->CategoryId = $radiologyCategory->id;
    $this->CategoryName = $radiologyCategory->name;

    $this->dispatchBrowserEvent('RadiologyCategoryEditModal');
  }

  public function updateCategory()
  {
    ModelCategory::where('id', $this->CategoryId)->update(['name' => $this->CategoryName]);

    return redirect()->route('app.settings.radiology')->with('success', 'Category Updated');
  }

  public function render()
  {
    if ($this->search) {
      $categories = ModelCategory::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.radiology-category',
        ['categories' => $categories]
      );
    } else {
      $categories = ModelCategory::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.radiology-category',
        ['categories' => $categories]
      );
    }
  }
}
