<?php

namespace App\Http\Livewire;

use App\Models\Allergy;
use Livewire\Component;

class Allergies extends Base
{
  public $sortBy = 'created_at';
  public $allergy_id;
  public $type;
  public $allergen;
  public $reactionToAllergen;
   public $patientId;

  public function selectAllergy($allergy_id)
  {
    $allergy = Allergy::find($allergy_id);
    $this->allergy_id = $allergy->id;
    $this->type = $allergy->type;
    $this->allergen = $allergy->allergen;
    $this->reactionToAllergen = $allergy->reaction_to_allergen;
    $this->patientId = $allergy->patient_id;
    $this->dispatchBrowserEvent('ShowAllergyEditModal');
  }
  public function updateAllergy()
  {
    Allergy::where('id', $this->allergy_id)->update([
      'type' => $this->type,
      'allergen' => $this->allergen,
      'reaction_to_allergen' => $this->reactionToAllergen,
    ]);

    return redirect()->route('app.patients.show', $this->patientId )->with('success', 'Allergy Updated Successfully');
  }
    public function render()
    {
      $allergies = Allergy::query()
      ->orderBy($this->sortBy, $this->sortDirection)
      ->paginate($this->perPage);
        return view('livewire.allergies',
         ['allergies' => $allergies]);
    }
}
