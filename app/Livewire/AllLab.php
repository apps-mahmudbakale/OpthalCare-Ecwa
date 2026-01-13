<?php


namespace App\Livewire;

use App\Models\LabRequest;
use Livewire\Component;
use Livewire\WithPagination;

class AllLab extends Base
{
    use WithPagination;

    public $patientId;
    public $locationId;
    public $categoryId;
    public $startDate;
    public $endDate;

    public function render()
    {
        $labRequests = LabRequest::query()->where('status', '!=', 'Result Ready')
            ->when($this->patientId, function ($query) {
                $query->where('patient_id', $this->patientId);
            })
            ->when($this->categoryId, function ($query) {
                $query->where('category_id', $this->categoryId);
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('request_date', [$this->startDate, $this->endDate]);
            })
            ->when($this->search, function ($query) {
                $query->whereHas('patient.user', function($q) {
                    $q->where('firstname', 'like', '%' . $this->search . '%')
                      ->orWhere('lastname', 'like', '%' . $this->search . '%');
                })->orWhereHas('test', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderByRaw("CASE 
                WHEN status = 'Pending' THEN 1 
                WHEN status = 'Specimen Collected' THEN 2 
                ELSE 3 END")
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.all-lab', [
            'labRequests' => $labRequests
        ]);
    }
}
