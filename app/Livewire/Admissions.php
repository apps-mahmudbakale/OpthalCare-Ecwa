<?php

namespace App\Livewire;

use App\Models\Admission;
use App\Models\Patient;
use App\Models\Ward;
use Livewire\Component;
use Livewire\WithPagination;

class Admissions extends Component
{
    use WithPagination;

    public $tab = 'active';
    public $patient_id = '';
    public $ward_id = '';
    public $search = '';

    public function updatedTab() { $this->resetPage(); }
    public function updatedPatientId() { $this->resetPage(); }
    public function updatedWardId() { $this->resetPage(); }
    public function updatedSearch() { $this->resetPage(); }

    public function render()
    {
        $activeStatuses = ['pending', 'prepared', 'billed', 'active'];

        $query = Admission::with(['patient.user', 'ward', 'bed'])
            ->when($this->tab === 'active', fn($q) => $q->whereIn('admissions.status', $activeStatuses))
            ->when($this->tab === 'discharged', fn($q) => $q->where('admissions.status', 'discharged'))
            ->when($this->patient_id, fn($q) => $q->where('admissions.patient_id', $this->patient_id))
            ->when($this->ward_id, fn($q) => $q->where('admissions.ward_id', $this->ward_id))
            ->when($this->search, fn($q) => $q->whereHas('patient.user', fn($sq) =>
                $sq->where('firstname', 'like', '%'.$this->search.'%')
                   ->orWhere('lastname', 'like', '%'.$this->search.'%')
            ))
            ->latest('admissions.created_at');

        $admissions = $query->paginate(15);
        $activeCount = Admission::whereIn('admissions.status', $activeStatuses)->count();
        $dischargedCount = Admission::where('admissions.status', 'discharged')->count();
        $patients = Patient::with('user')->get();
        $wards = Ward::all();

        return view('livewire.admissions', compact(
            'admissions', 'patients', 'wards', 'activeCount', 'dischargedCount'
        ));
    }
}
