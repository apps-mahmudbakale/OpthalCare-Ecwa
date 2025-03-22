<?php

namespace App\Http\Livewire;

use App\Models\Procedure;
use Livewire\Component;

class Procedures extends Base
{
  public $sortBy = 'name';
  public $RadiologyTestId;
  public $RadiologyTestName;
  public $RadiologyTestCategory;
  public $RadiologyTestTemplate;
  public $RadiologyTestPrice;


  public function selectRadiologyTest($id)
  {
    $test = Procedure::find($id);

    $this->RadiologyTestId = $test->id;
    $this->RadiologyTestName = $test->name;
    $this->RadiologyTestCategory = $test->category_id;
    $this->RadiologyTestTemplate = $test->template_id;
    $this->RadiologyTestPrice = $test->price;

    $this->dispatchBrowserEvent('ProceduresTestEditModal');
  }

  public function updateRadiologyTest()
  {
    Procedure::where('id', $this->RadiologyTestId)->update(['name' => $this->RadiologyTestName, 'category_id' => $this->RadiologyTestCategory, 'template_id' => $this->RadiologyTestTemplate, 'price' => $this->RadiologyTestPrice]);

    redirect()->route('app.settings.index')->with('success', 'Procedures Updated');
  }
  public function render()
  {
    if ($this->search) {
      $tests = Procedure::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.procedure',
        ['tests' => $tests]
      );
    } else {
      $tests = Procedure::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.procedures',
        ['tests' => $tests]
      );
    }
  }
}
