<?php

namespace App\Http\Livewire;

use App\Models\RadiologyCategory;
use App\Models\RadiologyRequest;
use Livewire\Component;
use Livewire\WithPagination;

class RadiologyRequestsTable extends Component
{
  use WithPagination;
  public $patientId;
  public $locationId;
  public $categoryId;
  public $startDate;
  public $endDate;
  public $perPage = 10;

  protected $paginationTheme = 'bootstrap';
    public function render()
    {

      $radiologyCategories = RadiologyCategory::get();
    $radiologyRequests = RadiologyRequest::query()
      ->when($this->patientId, function ($query) {
        $query->where('patient_id', $this->patientId);
      })
      ->when($this->categoryId, function ($query) {
        $query->where('imaging_id', $this->categoryId);
      })
      ->when($this->startDate && $this->endDate, function ($query) {
        $query->whereBetween('request_date', [$this->startDate, $this->endDate]);
      })
      ->paginate($this->perPage);

        return view('livewire.radiology-requests-table', [
          'radiologyRequests' => $radiologyRequests,
         'radiologyCategories' => $radiologyCategories
        ]);
    }

    public function cancelRequest($requestId){
    RadiologyRequest::find($requestId)->delete();

    }
}
