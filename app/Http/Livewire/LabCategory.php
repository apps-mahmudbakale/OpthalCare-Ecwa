<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LabCategory as ModelCategory;

class LabCategory extends Base
{
  public $sortBy = 'name';
  public $CategoryId;
  public $CategoryName;

  public function selectCategory(ModelCategory $labCategory)
  {
    $this->CategoryId = $labCategory->id;
    $this->CategoryName = $labCategory->name;

    $this->dispatchBrowserEvent('LabCategoryEditModal');
  }

  public function updateCategory()
  {
    ModelCategory::where('id', $this->CategoryId)->update(['name' => $this->CategoryName]);

    return redirect()->route('app.settings.laboratory')->with('success', 'Category Updated');
  }
  public function render()
  {
    if ($this->search) {
      $categories = ModelCategory::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.lab-category',
        ['categories' => $categories]
      );
    } else {
      $categories = ModelCategory::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.lab-category',
        ['categories' => $categories]
      );
    }
  }
}
