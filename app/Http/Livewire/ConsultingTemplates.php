<?php

namespace App\Http\Livewire;

use App\Models\ConsultingTemplate;
use Livewire\Component;

class ConsultingTemplates extends Base
{
  public $sortBy = 'title';
  public $TemplateId;
  public $TemplateTitle;
  public $TemplateBody;
  public function selectConsultingTemplate(ConsultingTemplate $template)
  {
    $this->TemplateId = $template->id;
    $this->TemplateTitle = $template->title;
    $this->TemplateBody = $template->body;

    $this->dispatchBrowserEvent('ConsultingTemplateEditModal');
  }

  public function updateConsultingTemplate()
  {
    ConsultingTemplate::where('id', $this->TemplateId)->update(['title' => $this->TemplateTitle, 'body' => $this->TemplateBody]);

    return redirect()->route('app.settings.consultations')->with('success', 'Consulting Template Updated !');
  }
  public function render()
  {
    if ($this->search) {
      $templates = ConsultingTemplate::query()
        ->where('title', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.consulting-templates',
        ['templates' => $templates]
      );
    } else {
      $templates = ConsultingTemplate::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.consulting-templates',
        ['templates' => $templates]
      );
    }
  }
}
