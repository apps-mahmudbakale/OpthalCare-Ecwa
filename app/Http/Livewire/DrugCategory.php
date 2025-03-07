<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DrugCategory as ModelCategory;

class DrugCategory extends Base
{
  public $sortBy = 'name';
  public $CategoryId;
  public $CategoryName;


  public function selectCategory(ModelCategory $drugCategory)
  {
    $this->CategoryId = $drugCategory->id;
    $this->CategoryName = $drugCategory->name;

    $this->dispatchBrowserEvent('DrugCategoryEditModal');
  }

  public function updateCategory()
  {
    ModelCategory::where('id', $this->CategoryId)->update(['name' => $this->CategoryName]);

    return redirect()->route('app.settings.pharmacy')->with('success', 'Category Updated');
  }
  public function render()
  {
    if ($this->search) {
      $categories = ModelCategory::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.drug-category',
        ['categories' => $categories]
      );
    } else {
      $categories = ModelCategory::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.drug-category',
        ['categories' => $categories]
      );
    }
  }
}
