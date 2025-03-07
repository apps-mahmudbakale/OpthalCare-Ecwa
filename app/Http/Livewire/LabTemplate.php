<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LabTemplate as ModelTemplate;

class LabTemplate extends Base
{
  public $sortBy = 'name';
  public $TemplateId;
  public $TemplateName;

  public function selectTemplate(ModelTemplate $labTemplate)
  {
    $this->TemplateId = $labTemplate->id;
    $this->TemplateName = $labTemplate->name;

    $this->dispatchBrowserEvent('LabTemplateEditModal');
  }

  public function updateTemplate()
  {
    ModelTemplate::where('id', $this->TemplateId)->update(['name' => $this->TemplateName]);

    return redirect()->route('app.settings.laboratory')->with('success', 'Template Updated');
  }
  public function render()
  {
    if ($this->search) {
      $templates = ModelTemplate::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.lab-template',
        ['templates' => $templates]
      );
    } else {
      $templates = ModelTemplate::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.lab-template',
        ['templates' => $templates]
      );
    }
  }
}
