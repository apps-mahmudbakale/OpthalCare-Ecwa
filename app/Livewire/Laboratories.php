<?php

namespace App\Livewire;

use App\Models\Laboratory;
use Livewire\Component;

class Laboratories extends Base
{
  public $sortBy = 'name';
  public $LabTestId;
  public $LabTestName;
  public $LabTestCategory;
  public $LabTestTemplate;
  public $LabTestPrice;


  public function selectDrugs($id)
  {
    $test = Laboratory::find($id);

    $this->LabTestId = $test->id;
    $this->LabTestName = $test->name;
    $this->LabTestCategory = $test->category_id;
    $this->LabTestTemplate = $test->template_id;
    $this->LabTestPrice = $test->price;

    $this->dispatchBrowserEvent('LabTestEditModal');
  }

  public function updateDrugs()
  {
    Laboratory::where('id', $this->LabTestId)->update(['name' => $this->LabTestName, 'category_id' => $this->LabTestCategory, 'template_id' => $this->LabTestTemplate, 'price' => $this->LabTestPrice]);

    redirect()->route('app.settings.index')->with('success', 'Department Updated');
  }
  public function render()
  {
    $query = Laboratory::query();

    // Apply search
    if ($this->search) {
      $query->where('name', 'like', '%' . $this->search . '%');
    }

    // Apply sorting
    $query->orderBy($this->sortBy, $this->sortDirection);

    // Paginate
    $tests = $query->paginate($this->perPage);

    return view('livewire.laboratories', ['tests' => $tests]);
  }
}
