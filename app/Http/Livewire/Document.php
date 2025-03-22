<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Document As DocModel;

class Document extends Base
{
    public $sortBy = 'name';
    public $DocId;
    public $DocName;

    public function selectDoc($id){
        $doc = DocModel::find($id);

        $this->DocId = $doc->id;
        $this->DocName = $doc->name;

        $this->dispatchBrowserEvent('DocEditModal');
    }

    public function updateDoc(){
        DocModel::where('id', $this->DocId)->update(['name' => $this->DocName]);
        
        redirect()->route('app.settings.index')->with('success', 'Document Updated');

    }
    public function render()
    {
        if ($this->search) {
            $documents = DocModel::query()
                ->where('name', 'like', '%' . $this->search . '%')
                ->paginate(10);

            return view(
                'livewire.document',
                ['documents' => $documents]
            );
        } else {
            $documents = DocModel::query()
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perPage);
            return view(
                'livewire.document',
                ['documents' => $documents]
            );
        }
    }
}
