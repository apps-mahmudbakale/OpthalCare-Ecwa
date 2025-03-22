<?php

namespace App\Charts;

use App\Models\Vitals;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class PulseChart
{
  protected $chart;

  public function __construct(LarapexChart $chart)
  {
    $this->chart = $chart;
  }

  public function build($patient): \ArielMejiaDev\LarapexCharts\AreaChart
  {
    $chartTarget = 'Pulse';
    $vitals = Vitals::where('parameter', $chartTarget)
      ->where('patient_id', $patient)
      ->select(['value', 'created_at'])
      ->get()
      ->groupBy(function ($data) {
        return $data->created_at->format('Y-m-d');
      })
      ->map(function ($results) {
        return $results->pluck('value')->first();
      });

    // Transform data for chart
    $chartData = $vitals->values()->toArray();
    $chartLabels = $vitals->keys()->toArray();
    // dd($chartLabels);
    // Build and return the chart
    return $this->chart->areaChart()
      ->setTitle($chartTarget)
      ->addData($chartTarget, $chartData)
      ->setXAxis($chartLabels);
  }
}
