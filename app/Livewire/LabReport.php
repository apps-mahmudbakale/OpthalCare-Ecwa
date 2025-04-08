<?php

namespace App\Livewire;

use App\Models\LabRequest;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LabReport extends Component
{
  public $category_id = ''; // Bound to dropdown
  public $status = '';

  public function render()
  {
    $query = LabRequest::select('test_id', DB::raw('count(*) as request_count'))
      ->with(['test.category'])
      ->groupBy('test_id');

    if ($this->category_id) {
      $query->whereHas('test', function ($q) {
        $q->where('category_id', $this->category_id);
      });
    }

    if ($this->status) {
      $query->where('status', $this->status);
    }

    $labReports = $query->get();
    $categories = \App\Models\LabCategory::all();
        return view('livewire.lab-report', compact('labReports', 'categories'));
    }
}
