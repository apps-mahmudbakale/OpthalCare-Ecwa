<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\RadiologyTemplate as ModelTemplate;

class RadiologyTemplate extends Base
{
  public $sortBy = 'name';
  public $TemplateId;
  public $TemplateName;

  public function selectTemplate(ModelTemplate $radiologyTemplate)
  {
    $this->TemplateId = $radiologyTemplate->id;
    $this->TemplateName = $radiologyTemplate->name;

    $this->dispatchBrowserEvent('RadiologyTemplateEditModal');
  }

  public function updateTemplate()
  {
    ModelTemplate::where('id', $this->TemplateId)->update(['name' => $this->TemplateName]);

    return redirect()->route('app.settings.radiology')->with('success', 'Template Updated');
  }
  public function render()
  {
    if ($this->search) {
      $templates = ModelTemplate::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.radiology-template',
        ['templates' => $templates]
      );
    } else {
      $templates = ModelTemplate::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.radiology-template',
        ['templates' => $templates]
      );
    }
  }
}
