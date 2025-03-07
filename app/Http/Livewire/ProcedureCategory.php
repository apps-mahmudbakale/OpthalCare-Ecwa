<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\ProcedureCategory as ModelCategory;

class ProcedureCategory extends Base
{
  public $sortBy = 'name';
  public $CategoryId;
  public $CategoryName;


  public function selectCategory(ModelCategory $procedureCategory)
  {
    $this->CategoryId = $procedureCategory->id;
    $this->CategoryName = $procedureCategory->name;

    $this->dispatchBrowserEvent('ProcedureCategoryEditModal');
  }

  public function updateCategory()
  {
    ModelCategory::where('id', $this->CategoryId)->update(['name' => $this->CategoryName]);

    return redirect()->route('app.settings.procedure')->with('success', 'Category Updated');
  }

  public function render()
  {
    if ($this->search) {
      $categories = ModelCategory::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.procedure-category',
        ['categories' => $categories]
      );
    } else {
      $categories = ModelCategory::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.procedure-category',
        ['categories' => $categories]
      );
    }
  }
}
