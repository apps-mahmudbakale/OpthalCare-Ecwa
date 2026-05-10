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
    public $status = 'active'; // active, concluded, all

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Only show the first antenatal record per patient (visit_type = 'new')
        $query = AntenatalRecord::query()
            ->with(['patient.user', 'user', 'concludedBy'])
            ->where('visit_type', 'new') // Only show new visits (first visits)
            ->orderBy('visit_date', 'desc')
            ->orderBy('created_at', 'desc');

        // Get counts for tabs
        $activeCount = AntenatalRecord::where('visit_type', 'new')
            ->where(function($q) {
                $q->where('status', 'active')->orWhereNull('status');
            })->count();
        
        $concludedCount = AntenatalRecord::where('visit_type', 'new')
            ->where('status', 'concluded')->count();
        
        $totalCount = AntenatalRecord::where('visit_type', 'new')->count();

        // Filter by status
        if ($this->status === 'active') {
            $query->where(function($q) {
                $q->where('status', 'active')
                  ->orWhereNull('status'); // Handle records created before status field
            });
        } elseif ($this->status === 'concluded') {
            $query->where('status', 'concluded');
        }
        // 'all' shows both active and concluded

        if ($this->search) {
            $query->whereHas('patient.user', function ($q) {
                $q->where('firstname', 'like', '%' . $this->search . '%')
                  ->orWhere('lastname', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.antenatal-record-list', [
            'records' => $query->paginate($this->perPage),
            'activeCount' => $activeCount,
            'concludedCount' => $concludedCount,
            'totalCount' => $totalCount,
        ]);
    }
}
