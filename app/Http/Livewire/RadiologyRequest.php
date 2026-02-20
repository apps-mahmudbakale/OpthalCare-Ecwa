<?php

namespace App\Http\Livewire;

use App\Models\RadiologyRequest as ImagingRequest;

class RadiologyRequest extends Base
{
    public $sortBy = 'created_at';
    public $patientId;

    protected $listeners = ['deleteImagingRequest' => 'delete'];

    public function mount($patientId)
    {
        $this->patientId = $patientId;
    }

    public function render()
    {
        $requests = ImagingRequest::query()
            ->where('patient_id', $this->patientId)
            ->with(['test', 'user', 'findings'])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.radiology-request', ['requests' => $requests]);
    }

    public function delete($id)
    {
        $request = ImagingRequest::find($id);
        if ($request) {
            $request->delete();
            $this->emit('imagingRequestDeleted');
            session()->flash('success', 'Radiology Request Deleted Successfully!');
        }
    }
}
