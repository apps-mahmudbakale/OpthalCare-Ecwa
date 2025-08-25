<?php

namespace App\Http\Livewire;

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
  public function confirmDelete($id)
  {
    $this->dispatchBrowserEvent('confirm-delete', [
      'type' => 'warning',
      'title' => 'Are you sure?',
      'text' => 'You won\'t be able to revert this!',
      'id' => $id
    ]);
  }

  public function deleteLab($id)
  {
    try {
      $lab = Laboratory::findOrFail($id);
      $lab->delete();
      $this->dispatchBrowserEvent('alert', [
        'type' => 'success',
        'message' => 'Lab test deleted successfully!'
      ]);
    } catch (\Exception $e) {
      $this->dispatchBrowserEvent('alert', [
        'type' => 'error',
        'message' => 'Failed to delete lab test!'
      ]);
    }
  }

  public function render()
  {
    if ($this->search) {
      $tests = Laboratory::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.laboratories',
        ['tests' => $tests]
      );
    } else {
      $tests = Laboratory::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.laboratories',
        ['tests' => $tests]
      );
    }
  }
}
