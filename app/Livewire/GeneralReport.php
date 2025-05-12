<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class GeneralReport extends Component
{
  use WithPagination;

  public $clinic_id = '';
  public $status = '';
  public $diagnosis_id = '';
  public $start;
  public $stop;
  public $tab = 'visits';

  protected $queryString = ['clinic_id', 'status', 'diagnosis_id', 'start', 'stop', 'tab'];

  public function mount()
  {
    $today = Carbon::now()->format('Y-m-d');
    $this->start = $today;
    $this->stop = $today;
  }

  public function updated($property)
  {
    $this->resetPage();
  }

  public function render()
  {
    $visits = []; // Fetch filtered visits here
    $diagnoses = []; // Fetch filtered diagnoses here
    $admissions = []; // Fetch filtered admissions here

    return view('livewire.reports.general-report', compact('visits', 'diagnoses', 'admissions'));
  }
}
