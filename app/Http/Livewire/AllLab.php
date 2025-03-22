<?php


namespace App\Http\Livewire;

use App\Models\LabRequest;
use Livewire\Component;

class AllLab extends Component
{
    public $patientId;
    public $locationId;
    public $categoryId;
    public $startDate;
    public $endDate;
    public $perPage = 10;

    public function render()
    {
        $labRequests = LabRequest::query()
            ->when($this->patientId, function ($query) {
                $query->where('patient_id', $this->patientId);
            })
            ->when($this->categoryId, function ($query) {
                $query->where('category_id', $this->categoryId);
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('request_date', [$this->startDate, $this->endDate]);
            })
            ->paginate($this->perPage);

        return view('livewire.all-lab', [
            'labRequests' => $labRequests
        ]);
    }
}
