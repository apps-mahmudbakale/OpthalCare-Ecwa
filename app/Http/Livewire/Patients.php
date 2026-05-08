<?php

namespace App\Http\Livewire;

use App\Models\Patient;
use Livewire\WithPagination;

class Patients extends Base
{
  use WithPagination;

  public $sortBy = 'hospital_no';
  public $sortDirection = 'desc';
  public $search = '';
  public $perPage = 10;

  public $deleteId;
  public $forceDelete = false;
  
  protected $listeners = ['deletePatient' => 'delete', 'forceDeletePatient' => 'forceDelete'];

  public function render()
  {
    $query = Patient::query();

    if ($this->search) {
      $query->join('users', 'patients.user_id', '=', 'users.id')
        ->where('patients.hospital_no', 'like', '%' . $this->search . '%')
        ->orWhere('patients.phone', 'like', '%' . $this->search . '%')
        ->orWhere('patients.date_of_birth', 'like', '%' . $this->search . '%')
        ->orWhere('users.firstname', 'like', '%' . $this->search . '%')
        ->orWhere('users.lastname', 'like', '%' . $this->search . '%')
        ->orWhere('patients.middlename', 'like', '%' . $this->search . '%')
        ->select('patients.*');  // Select only the patients columns to avoid ambiguity
    }

    $patients = $query->orderBy($this->sortBy, $this->sortDirection)
      ->paginate($this->perPage);

    return view('livewire.patients', [
      'patients' => $patients
    ]);
  }

  public function confirmDelete($id)
  {
    $this->deleteId = $id;
    $this->forceDelete = false;
    
    // Check if patient has records first
    $patient = Patient::findOrFail($id);
    $hasRecords = $this->checkPatientHasRecords($patient);
    
    if ($hasRecords) {
      $this->dispatchBrowserEvent('confirm-delete-with-records', [
        'patientId' => $id,
        'patientName' => $patient->user->firstname . ' ' . $patient->user->lastname,
        'recordsCount' => $this->getRecordsCount($patient)
      ]);
    } else {
      $this->dispatchBrowserEvent('confirm-delete', [
        'type' => 'warning',
        'title' => 'Are you sure?',
        'text' => 'This action cannot be undone. The patient will be permanently deleted.',
        'confirmButtonText' => 'Yes, delete it!',
        'cancelButtonText' => 'Cancel'
      ]);
    }
  }

  public function delete()
  {
    try {
      $patient = Patient::findOrFail($this->deleteId);
      
      if (!$this->forceDelete && $this->checkPatientHasRecords($patient)) {
        $this->dispatchBrowserEvent('alert', [
          'type' => 'error',
          'message' => 'Patient has existing medical records. Use force delete to remove all data.'
        ]);
        return;
      }
      
      // If force delete is enabled, delete all related records
      if ($this->forceDelete) {
        $this->deleteAllPatientRecords($patient);
      }
      
      // Delete the associated user record as well
      $user = $patient->user;
      
      // Delete patient wallet if exists
      if ($patient->wallet) {
        $patient->wallet->delete();
      }
      
      // Delete patient tags
      \App\Models\PatientTags::where('patient_id', $patient->id)->delete();
      
      // Delete patient first (due to foreign key constraints)
      $patient->delete();
      
      // Then delete the user
      if ($user) {
        $user->delete();
      }
      
      $this->dispatchBrowserEvent('alert', [
        'type' => 'success',
        'message' => $this->forceDelete ? 'Patient and all related records deleted successfully!' : 'Patient deleted successfully!'
      ]);
      
      // Refresh the component
      $this->render();
      
    } catch (\Exception $e) {
      $this->dispatchBrowserEvent('alert', [
        'type' => 'error',
        'message' => 'Error deleting patient: ' . $e->getMessage()
      ]);
    }
  }
  
  public function forceDelete($id)
  {
    $this->deleteId = $id;
    $this->forceDelete = true;
    $this->delete();
  }
  
  private function checkPatientHasRecords(Patient $patient)
  {
    $hasCheckIns = $patient->checkIns()->count() > 0;
    $hasBillings = \App\Models\Billing::where('user_id', $patient->user_id)->count() > 0;
    $hasAppointments = \App\Models\Appointment::where('patient_id', $patient->id)->count() > 0;
    $hasLabRequests = \App\Models\LabRequest::where('patient_id', $patient->id)->count() > 0;
    $hasDrugRequests = \App\Models\DrugRequest::where('patient_id', $patient->id)->count() > 0;
    $hasAdmissions = \App\Models\Admission::where('patient_id', $patient->id)->count() > 0;
    $hasRadiologyRequests = \App\Models\RadiologyRequest::where('patient_id', $patient->id)->count() > 0;
    $hasLabResults = \App\Models\LabResult::where('patient_id', $patient->id)->count() > 0;
    $hasDiagnoses = \App\Models\Diagnosis::where('patient_id', $patient->id)->count() > 0;
    $hasAllergies = \App\Models\Allergy::where('patient_id', $patient->id)->count() > 0;
    $hasDeliveries = $patient->deliveries()->count() > 0;
    $hasAntenatalRecords = $patient->antenatalRecords()->count() > 0;
    
    return $hasCheckIns || $hasBillings || $hasAppointments || $hasLabRequests || 
           $hasDrugRequests || $hasAdmissions || $hasRadiologyRequests || $hasLabResults ||
           $hasDiagnoses || $hasAllergies || $hasDeliveries || $hasAntenatalRecords;
  }
  
  private function getRecordsCount(Patient $patient)
  {
    return [
      'check_ins' => $patient->checkIns()->count(),
      'billings' => \App\Models\Billing::where('user_id', $patient->user_id)->count(),
      'appointments' => \App\Models\Appointment::where('patient_id', $patient->id)->count(),
      'lab_requests' => \App\Models\LabRequest::where('patient_id', $patient->id)->count(),
      'drug_requests' => \App\Models\DrugRequest::where('patient_id', $patient->id)->count(),
      'admissions' => \App\Models\Admission::where('patient_id', $patient->id)->count(),
      'radiology_requests' => \App\Models\RadiologyRequest::where('patient_id', $patient->id)->count(),
      'lab_results' => \App\Models\LabResult::where('patient_id', $patient->id)->count(),
      'diagnoses' => \App\Models\Diagnosis::where('patient_id', $patient->id)->count(),
      'allergies' => \App\Models\Allergy::where('patient_id', $patient->id)->count(),
      'deliveries' => $patient->deliveries()->count(),
      'antenatal_records' => $patient->antenatalRecords()->count(),
    ];
  }
  
  private function deleteAllPatientRecords(Patient $patient)
  {
    // Delete check-ins
    $patient->checkIns()->delete();
    
    // Delete billings
    \App\Models\Billing::where('user_id', $patient->user_id)->delete();
    
    // Delete appointments
    \App\Models\Appointment::where('patient_id', $patient->id)->delete();
    
    // Delete lab requests and results
    \App\Models\LabRequest::where('patient_id', $patient->id)->delete();
    \App\Models\LabResult::where('patient_id', $patient->id)->delete();
    
    // Delete drug requests
    \App\Models\DrugRequest::where('patient_id', $patient->id)->delete();
    
    // Delete radiology requests
    \App\Models\RadiologyRequest::where('patient_id', $patient->id)->delete();
    
    // Delete admissions
    \App\Models\Admission::where('patient_id', $patient->id)->delete();
    
    // Delete diagnoses
    \App\Models\Diagnosis::where('patient_id', $patient->id)->delete();
    
    // Delete allergies
    \App\Models\Allergy::where('patient_id', $patient->id)->delete();
    
    // Delete deliveries and antenatal records
    $patient->deliveries()->delete();
    $patient->antenatalRecords()->delete();
    
    // Delete other related records
    \App\Models\VisionAcuity::where('patient_id', $patient->id)->delete();
    \App\Models\IOP::where('patient_id', $patient->id)->delete();
    \App\Models\OpticalRequest::where('patient_id', $patient->id)->delete();
    \App\Models\ProcedureRequest::where('patient_id', $patient->id)->delete();
    \App\Models\NursingNote::where('patient_id', $patient->id)->delete();
    \App\Models\NursingTask::where('patient_id', $patient->id)->delete();
    \App\Models\ProgressNote::where('patient_id', $patient->id)->delete();
    \App\Models\AntenatalPackageUsage::where('patient_id', $patient->id)->delete();
  }
}
