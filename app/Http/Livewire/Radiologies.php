<?php

namespace App\Http\Livewire;

use App\Models\Radiology;
use Livewire\Component;

class Radiologies extends Base
{
  public $sortBy = 'name';
  public $RadiologyTestId;
  public $RadiologyTestName;
  public $RadiologyTestCategory;
  public $RadiologyTestTemplate;
  public $RadiologyTestPrice;


  public function selectRadiologyTest($id)
  {
    $test = Radiology::find($id);

    $this->RadiologyTestId = $test->id;
    $this->RadiologyTestName = $test->name;
    $this->RadiologyTestCategory = $test->category_id;
    $this->RadiologyTestTemplate = $test->template_id;
    $this->RadiologyTestPrice = $test->price;

    $this->dispatchBrowserEvent('RadiologyTestEditModal');
  }

  public function updateRadiologyTest()
  {
    Radiology::where('id', $this->RadiologyTestId)->update(['name' => $this->RadiologyTestName, 'category_id' => $this->RadiologyTestCategory, 'template_id' => $this->RadiologyTestTemplate, 'price' => $this->RadiologyTestPrice]);

    redirect()->route('app.settings.index')->with('success', 'Department Updated');
  }
  public function render()
  {
    if ($this->search) {
      $tests = Radiology::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.radiologies',
        ['tests' => $tests]
      );
    } else {
      $tests = Radiology::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.radiologies',
        ['tests' => $tests]
      );
    }
  }
}
