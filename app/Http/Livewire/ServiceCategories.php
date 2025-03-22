<?php

namespace App\Http\Livewire;

use App\Models\ServiceCategory;
use Livewire\Component;

class ServiceCategories extends Base
{
  public $sortBy = 'name';
  public $CategoryId;
  public $CategoryName;



  public function selectCategory(ServiceCategory $category)
  {
    // $doc = ServiceCategory::find($id);

    $this->CategoryId = $category->id;
    $this->CategoryName = $category->name;

    $this->dispatchBrowserEvent('CategoryEditModal');

    // dd($this->CategoryName);
  }

  public function updateCategory()
  {
    ServiceCategory::where('id', $this->CategoryId)->update(['name' => $this->CategoryName]);

    return redirect()->route('app.settings.index')->with('success', 'Service Updated');
  }
  public function render()
  {
    if ($this->search) {
      $categories = ServiceCategory::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.service-categories',
        ['categories' => $categories]
      );
    } else {
      $categories = ServiceCategory::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.service-categories',
        ['categories' => $categories]
      );
    }
  }
}
