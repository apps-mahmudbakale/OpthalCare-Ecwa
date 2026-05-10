<?php

namespace App\Livewire;

use App\Models\AntenatalRecord;
use Livewire\Component;
use Livewire\WithPagination;

class AntenatalRecordList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 25;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Only show the first antenatal record per patient (visit_type = 'new')
        $query = AntenatalRecord::query()
            ->with(['patient.user', 'user'])
            ->where('visit_type', 'new') // Only show new visits (first visits)
            ->orderBy('visit_date', 'desc')
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->whereHas('patient.user', function ($q) {
                $q->where('firstname', 'like', '%' . $this->search . '%')
                  ->orWhere('lastname', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.antenatal-record-list', [
            'records' => $query->paginate($this->perPage),
        ]);
    }
}
