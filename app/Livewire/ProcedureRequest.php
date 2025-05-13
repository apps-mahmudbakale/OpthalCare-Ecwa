<?php

namespace App\Livewire;

use App\Models\Patient;
use App\Models\ProcedureRequest as ModelsProcedureRequest;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ProcedureRequest extends Component
{
  use WithPagination;

  public $patient_id = '';
  public $category_id = '';
  public $start;
  public $stop;

  public function mount()
  {
    // Optional: Set default date range to today
    $this->start = now()->startOfDay()->format('Y-m-d');
    $this->stop = now()->endOfDay()->format('Y-m-d');
  }

  public function updated()
  {
    // Live update when filters are changed
    $this->resetPage();
  }

  public function render()
  {
    $requests = ModelsProcedureRequest::query()
      ->with(['patient', 'procedure.category'])
      ->when($this->patient_id, fn($q) => $q->where('patient_id', $this->patient_id))
      ->when($this->category_id, function ($q) {
        // Filter by category through the procedure
        return $q->whereHas('procedure', function ($query) {
          $query->where('category_id', $this->category_id);
        });
      })
      ->when($this->start && $this->stop, function ($q) {
        $startDate = Carbon::parse($this->start)->startOfDay();
        $endDate = Carbon::parse($this->stop)->endOfDay();
        return $q->whereBetween('created_at', [$startDate, $endDate]);
      })
      ->latest()
      ->paginate(10);

    return view('livewire.procedure-request', [
      'requests' => $requests,
      'patients' => Patient::all(), // Adjust if you need more efficient querying
    ]);
  }
}
