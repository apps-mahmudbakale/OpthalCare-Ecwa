<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ConsumableCategory as ModelCategory;

class ConsumablesList extends Base
{
    public $sortBy = 'name';
    public $CategoryId;
    public $CategoryName;


    public function selectCategory(ModelCategory $consumableCategory)
    {
        $this->CategoryId = $consumableCategory->id;
        $this->CategoryName = $consumableCategory->name;

        $this->dispatchBrowserEvent('consumables-listEditModal');
    }

    public function updateCategory()
    {
        ModelCategory::where('id', $this->CategoryId)->update(['name' => $this->CategoryName]);

        return redirect()->route('app.settings.consumables-list')->with('success', 'Category Updated');
    }
    public function render()
    {
        if ($this->search) {
            $categories = ModelCategory::query()
                ->where('name', 'like', '%' . $this->search . '%')
                ->paginate(10);

            return view(
                'livewire.consumables-list',
                ['categories' => $categories]
            );
        } else {
            $categories = ModelCategory::query()
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perPage);
            return view(
                'livewire.consumables-list',
                ['categories' => $categories]
            );
        }
    }
}
