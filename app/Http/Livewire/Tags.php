<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;

class Tags extends Base
{
  public $sortBy = 'name';
  public $Id;
  public $Name;
  public $Color;


  public function selectTag(Tag $tag)
  {
    $this->Id = $tag->id;
    $this->Name = $tag->name;
    $this->Color = $tag->color;

    $this->dispatchBrowserEvent('TagEditModal');
  }

  public function updateTag()
  {
    Tag::where('id', $this->Id)->update(['name' => $this->Name, 'color' => $this->Color]);

    return redirect()->route('app.settings.index')->with('success', 'Tag Updated');
  }
  public function render()
  {
    if ($this->search) {
      $tags = Tag::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.tags',
        ['tags' => $tags]
      );
    } else {
      $tags = Tag::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.tags',
        ['tags' => $tags]
      );
    }
  }
}
