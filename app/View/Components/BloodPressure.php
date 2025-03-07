<?php

namespace App\View\Components;

use App\Charts\BloodPressureChart;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BloodPressure extends Component
{
  public $data;
  /**
   * Create a new component instance.
   */
  public function __construct(BloodPressureChart $chart, $data)
  {
    $this->data = $data;
  }

  /**
   * Get the view / contents that represent the component.
   */
  public function render(): View|Closure|string
  {
    return view('components.blood_pressure', ['chart' => $chart->build()]);
  }
}
