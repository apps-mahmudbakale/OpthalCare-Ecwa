<?php

namespace App\Http\Liveware;

use Livewire\Component;
use App\Models\Refraction as ModelRefraction;

class Refraction extends Base
{
  public $sortBy = 'created_at';
  public $refractionId;
  public $patientId; // Holds the patient ID
  public $itching_right, $itching_left;
  public $photophobia_right, $photophobia_left;
  public $watering_right, $watering_left;
  public $redness_right, $redness_left;
  public $visual_acuity_right, $visual_acuity_left;
  public $refraction_sph_right, $refraction_sph_left;
  public $refraction_cyl_right, $refraction_cyl_left;
  public $refraction_axis_right, $refraction_axis_left;
  public $addition_right, $addition_left;
  public $pupillary_distance;
  public $notes;
  public $search;

  public function mount($patientId)
  {
    $this->patientId = $patientId;
  }

  public function selectRefraction(ModelRefraction $refraction)
  {
    $this->refractionId = $refraction->id;

    // Load values from the selected refraction record
    $this->itching_right = $refraction->itching_right;
    $this->itching_left = $refraction->itching_left;
    $this->photophobia_right = $refraction->photophobia_right;
    $this->photophobia_left = $refraction->photophobia_left;
    $this->watering_right = $refraction->watering_right;
    $this->watering_left = $refraction->watering_left;
    $this->redness_right = $refraction->redness_right;
    $this->redness_left = $refraction->redness_left;
    $this->visual_acuity_right = $refraction->visual_acuity_right;
    $this->visual_acuity_left = $refraction->visual_acuity_left;
    $this->refraction_sph_right = $refraction->refraction_sph_right;
    $this->refraction_sph_left = $refraction->refraction_sph_left;
    $this->refraction_cyl_right = $refraction->refraction_cyl_right;
    $this->refraction_cyl_left = $refraction->refraction_cyl_left;
    $this->refraction_axis_right = $refraction->refraction_axis_right;
    $this->refraction_axis_left = $refraction->refraction_axis_left;
    $this->addition_right = $refraction->addition_right;
    $this->addition_left = $refraction->addition_left;
    $this->pupillary_distance = $refraction->pupillary_distance;
    $this->notes = $refraction->notes;

    $this->dispatchBrowserEvent('RefractionEditModal');
  }

  public function showRefraction(ModelRefraction $refraction)
  {
    $this->selectRefraction($refraction);
    $this->dispatchBrowserEvent('RefractionShowModal');
  }

  public function updateRefraction()
  {
    ModelRefraction::where('id', $this->refractionId)->update([
      'itching_right' => $this->itching_right,
      'itching_left' => $this->itching_left,
      'photophobia_right' => $this->photophobia_right,
      'photophobia_left' => $this->photophobia_left,
      'watering_right' => $this->watering_right,
      'watering_left' => $this->watering_left,
      'redness_right' => $this->redness_right,
      'redness_left' => $this->redness_left,
      'visual_acuity_right' => $this->visual_acuity_right,
      'visual_acuity_left' => $this->visual_acuity_left,
      'refraction_sph_right' => $this->refraction_sph_right,
      'refraction_sph_left' => $this->refraction_sph_left,
      'refraction_cyl_right' => $this->refraction_cyl_right,
      'refraction_cyl_left' => $this->refraction_cyl_left,
      'refraction_axis_right' => $this->refraction_axis_right,
      'refraction_axis_left' => $this->refraction_axis_left,
      'addition_right' => $this->addition_right,
      'addition_left' => $this->addition_left,
      'pupillary_distance' => $this->pupillary_distance,
      'notes' => $this->notes,
    ]);

    return redirect()->back()->with('success', 'Refraction Updated');
  }

  public function render()
  {
    $refractions = ModelRefraction::query()
      ->where('patient_id', $this->patientId)
      ->when($this->search, function ($query) {
        $query->where('visual_acuity_right', 'like', '%' . $this->search . '%')
          ->orWhere('visual_acuity_left', 'like', '%' . $this->search . '%');
      })
      ->orderBy($this->sortBy, $this->sortDirection)
      ->paginate(10);

    return view('livewire.refraction', ['refractions' => $refractions]);
  }
}
