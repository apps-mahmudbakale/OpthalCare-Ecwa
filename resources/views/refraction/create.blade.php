@extends('layouts/layoutMaster')

@section('title', 'Patients - Create Patient')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection
<style>
  .radio-group {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 100px; /* Large gap on bigger screens */
  }

  .radio-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    font-size: 14px;
  }

  .radio-buttons {
    display: flex;
    gap: 10px;
  }

  /* Fancy radio buttons */
  .radio-buttons input {
    display: none;
  }

  .radio-buttons label {
    display: inline-block;
    padding: 8px 14px;
    border-radius: 20px;
    background-color: #f0f0f0;
    color: #333;
    font-size: 14px;
    cursor: pointer;
    transition: 0.3s;
    border: 2px solid transparent;
  }

  .radio-buttons input:checked + label {
    background-color: #007bff;
    color: white;
    border-color: #0056b3;
    font-weight: bold;
  }

  /* Responsive layout for mobile */
  @media (max-width: 768px) {
    .radio-group {
      gap: 40px; /* Reduce gap on smaller screens */
    }
  }
</style>
@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('content')
<div class="text-center mb-4">
    <h3 class="mb-2">Record Refraction for
        {{ $patient->user->firstname }}
        {{ $patient->user->lastname }}
    </h3>
</div>
<form action="{{ route('app.refraction.store') }}" method="POST" class="row g-3">
    @csrf
    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
    <h4>Case History</h4>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <th></th>
            <th>(RE)</th>
            <th>(LE)</th>
        </thead>
        <tbody>
            <tr>
                <td width="70%">ITCHING</td>
                <td><input type="text" name="itching_right" class="form-control"></td>
                <td><input type="text" name="itching_left" class="form-control"></td>
            </tr>
            <tr>
                <td width="70%">PHOTOPHOBIA</td>
                <td><input type="text" name="photophobia_right" class="form-control"></td>
                <td><input type="text" name="photophobia_left" class="form-control"></td>
            </tr>
            <tr>
                <td width="70%">PAIN</td>
                <td><input type="text" name="pain_right" class="form-control"></td>
                <td><input type="text" name="pain_left" class="form-control"></td>
            </tr>
            <tr>
                <td width="70%">BLUR VISION AT FAR</td>
                <td><input type="text" name="blur_vision_far_right" class="form-control"></td>
                <td><input type="text" name="blur_vision_far_left" class="form-control"></td>
            </tr>
            <tr>
                <td width="70%">BLUR VISION AT NEAR</td>
                <td><input type="text" name="blur_vision_near_right" class="form-control"></td>
                <td><input type="text" name="blur_vision_near_left" class="form-control"></td>
            </tr>
            <tr>
                <td width="70%">DIPLOPIA</td>
                <td><input type="text" name="diplopia_right" class="form-control"></td>
                <td><input type="text" name="diplopia_left" class="form-control"></td>
            </tr>
            <tr>
                <td width="70%">BURNING SENSATION</td>
                <td><input type="text" name="burning_sensation_right" class="form-control"></td>
                <td><input type="text" name="burning_sensation_left" class="form-control"></td>
            </tr>
            <tr>
                <td width="70%">TEARING</td>
                <td><input type="text" name="tearing_right" class="form-control"></td>
                <td><input type="text" name="tearing_left" class="form-control"></td>
            </tr>
            <tr>
                <td width="70%">DISCHARGE</td>
                <td><input type="text" name="discharge_right" class="form-control"></td>
                <td><input type="text" name="discharge_left" class="form-control"></td>
            </tr>
        </tbody>
    </table>
  <div class="radio-group">
    <div class="radio-item">
      <span>Occipital Headache</span>
      <div class="radio-buttons">
        <input type="radio" name="occipital_headache" id="occipital_yes" value="yes">
        <label for="occipital_yes">Yes</label>
        <input type="radio" name="occipital_headache" id="occipital_no" value="no">
        <label for="occipital_no">No</label>
      </div>
    </div>

    <div class="radio-item">
      <span>Frontal Headache</span>
      <div class="radio-buttons">
        <input type="radio" name="frontal_headache" id="frontal_yes" value="yes">
        <label for="frontal_yes">Yes</label>
        <input type="radio" name="frontal_headache" id="frontal_no" value="no">
        <label for="frontal_no">No</label>
      </div>
    </div>

    <div class="radio-item">
      <span>Temporal Headache</span>
      <div class="radio-buttons">
        <input type="radio" name="temporal_headache" id="temporal_yes" value="yes">
        <label for="temporal_yes">Yes</label>
        <input type="radio" name="temporal_headache" id="temporal_no" value="no">
        <label for="temporal_no">No</label>
      </div>
    </div>

    <div class="radio-item">
      <span>Hypertensive</span>
      <div class="radio-buttons">
        <input type="radio" name="hypertensive" id="hypertensive_yes" value="yes">
        <label for="hypertensive_yes">Yes</label>
        <input type="radio" name="hypertensive" id="hypertensive_no" value="no">
        <label for="hypertensive_no">No</label>
      </div>
    </div>

    <div class="radio-item">
      <span>Diabetic</span>
      <div class="radio-buttons">
        <input type="radio" name="diabetic" id="diabetic_yes" value="yes">
        <label for="diabetic_yes">Yes</label>
        <input type="radio" name="diabetic" id="diabetic_no" value="no">
        <label for="diabetic_no">No</label>
      </div>
    </div>
  </div>

  <h4>External Examination</h4>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <th></th>
            <th>RIGHT</th>
            <th>LEFT</th>
        </thead>
        <tbody>
            <tr>
                <td width="70%">ADNEXA</td>
                <td><input type="text" name="adnexa_right" class="form-control"></td>
                <td><input type="text" name="adnexa_left" class="form-control"></td>
            </tr>
            <tr>
                <td width="70%">CONJUCTIVA </td>
                <td><input type="text" name="conjuctiva_right" class="form-control"></td>
                <td><input type="text" name="conjuctiva_left" class="form-control"></td>
            </tr>
            <tr>
                <td width="70%">SCLERA</td>
                <td><input type="text" name="sclera_right" class="form-control"></td>
                <td><input type="text" name="sclera_left" class="form-control"></td>
            </tr>
            <tr>
                <td width="70%">PUPIL</td>
                <td><input type="text" name="pupil_right" class="form-control"></td>
                <td><input type="text" name="pupil_left" class="form-control"></td>
            </tr>
            <tr>
                <td width="70%">PALPEBRA</td>
                <td><input type="text" name="palpebra_right" class="form-control"></td>
                <td><input type="text" name="palpebra_left" class="form-control"></td>
            </tr>
            <tr>
                <td width="70%">CORNEA</td>
                <td><input type="text" name="cornea_right" class="form-control"></td>
                <td><input type="text" name="cornea_left" class="form-control"></td>
            </tr>
        </tbody>
    </table>
    <h4>Visual Acuity Test</h4>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <th></th>
            <th>DISTANCE</th>
            <th>PH</th>
        </thead>
        <tbody>
            <tr>
                <td width="70%">RIGHT</td>
                <td><input type="text" name="distance_right" class="form-control"></td>
                <td><input type="text" name="ph_right" class="form-control"></td>
            </tr>
            <tr>
                <td width="70%">LEFT</td>
                <td><input type="text" name="distance_left" class="form-control"></td>
                <td><input type="text" name="ph_left" class="form-control"></td>
            </tr>
        </tbody>
    </table>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <th></th>
            <th>NEAR</th>
        </thead>
        <tbody>
            <tr>
                <td width="80%">RIGHT</td>
                <td><input type="text" name="near_right" class="form-control"></td>
            </tr>
            <tr>
                <td width="80%">LEFT</td>
                <td><input type="text" name="near_left" class="form-control"></td>
            </tr>
        </tbody>
    </table>
    <h4>Present Glasses</h4>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <th></th>
            <th>SPH</th>
            <th>CYL</th>
            <th>AXIS</th>
            <th>PRISM</th>
            <th>BASE</th>
            <th>VA</th>
            <th>ADD</th>
            <th>VA</th>
        </thead>
        <tbody>
            <tr>
                <td width=10%">RIGHT</td>
                <td><input type="text" name="sph_glass_right" class="form-control"></td>
                <td><input type="text" name="cyl_glass_right" class="form-control"></td>
                <td><input type="text" name="axis_glass_right" class="form-control"></td>
                <td><input type="text" name="prism_glass_right" class="form-control"></td>
                <td><input type="text" name="base_glass_right" class="form-control"></td>
                <td><input type="text" name="va_glass_right" class="form-control"></td>
                <td><input type="text" name="add_glass_right" class="form-control"></td>
                <td><input type="text" name="va2_glass_right" class="form-control"></td>
            </tr>
            <tr>
                <td width="10%">LEFT</td>
                <td><input type="text" name="sph_glass_left" class="form-control"></td>
                <td><input type="text" name="cyl_glass_left" class="form-control"></td>
                <td><input type="text" name="axis_glass_left" class="form-control"></td>
                <td><input type="text" name="prism_glass_left" class="form-control"></td>
                <td><input type="text" name="base_glass_left" class="form-control"></td>
                <td><input type="text" name="va_glass_left" class="form-control"></td>
                <td><input type="text" name="add_glass_left" class="form-control"></td>
                <td><input type="text" name="va2_glass_left" class="form-control"></td>
            </tr>
        </tbody>
    </table>
    <h4>Auto Refraction</h4>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <th></th>
            <th>AUTO REFRACTION</th>
            <th>VA</th>
        </thead>
        <tbody>
            <tr>
                <td width="50%">RIGHT</td>
                <td><input type="text" name="auto_refraction_right" class="form-control"></td>
                <td><input type="text" name="va_auto_right" class="form-control"></td>
            </tr>
            <tr>
                <td width="50%">LEFT</td>
                <td><input type="text" name="auto_refraction_left" class="form-control"></td>
                <td><input type="text" name="va_auto_left" class="form-control"></td>
            </tr>
        </tbody>
    </table>
  <h4>RETINOSCOPY FINDINGS</h4>
  <table class="table table-striped table-bordered">
    <thead class="table-dark">
    <th></th>
    <th>SPH</th>
    <th>CYL</th>
    <th>AXIS</th>
    <th>VA</th>
    </thead>
    <tbody>
    <tr>
      <td width="50%">RIGHT</td>
      <td><input type="text" name="sph_retino_right" class="form-control form-control-lg"></td>
      <td><input type="text" name="cyl_retino_right" class="form-control"></td>
      <td><input type="text" name="axis_retino_right" class="form-control"></td>
      <td><input type="text" name="va_retino_right" class="form-control"></td>
    </tr>
    <tr>
      <td width="50%">LEFT</td>
      <td><input type="text" name="sph_retino_left" class="form-control"></td>
      <td><input type="text" name="cyl_retino_left" class="form-control"></td>
      <td><input type="text" name="axis_retino_left" class="form-control"></td>
      <td><input type="text" name="va_retino_left" class="form-control"></td>
    </tr>
    </tbody>
  </table>
  <h4>SUBJECTIVE REFRACTION</h4>
  <table class="table table-striped table-bordered">
    <thead class="table-dark">
    <th></th>
    <th>SPH</th>
    <th>CYL</th>
    <th>AXIS</th>
    <th>PRISM</th>
    <th>BASE</th>
    <th>VA</th>
    <th>ADD</th>
    <th>VA</th>
    </thead>
    <tbody>
    <tr>
      <td width="10%">RIGHT</td>
      <td><input type="text" name="sph_subj_right" class="form-control"></td>
      <td><input type="text" name="cyl_subj_right" class="form-control"></td>
      <td><input type="text" name="axis_subj_right" class="form-control"></td>
      <td><input type="text" name="prism_subj_right" class="form-control"></td>
      <td><input type="text" name="base_subj_right" class="form-control"></td>
      <td><input type="text" name="va_subj_right" class="form-control"></td>
      <td><input type="text" name="add_subj_right" class="form-control"></td>
      <td><input type="text" name="va2_subj_right" class="form-control"></td>
    </tr>
    <tr>
      <td width="10%">LEFT</td>
      <td><input type="text" name="sph_subj_left" class="form-control"></td>
      <td><input type="text" name="cyl_subj_left" class="form-control"></td>
      <td><input type="text" name="axis_subj_left" class="form-control"></td>
      <td><input type="text" name="prism_subj_left" class="form-control"></td>
      <td><input type="text" name="base_subj_left" class="form-control"></td>
      <td><input type="text" name="va_subj_left" class="form-control"></td>
      <td><input type="text" name="add_subj_left" class="form-control"></td>
      <td><input type="text" name="va2_subj_left" class="form-control"></td>
    </tr>
    </tbody>
  </table>
  <div class="col-12">
    <label for="">Diagnosis</label>
    <textarea name="diagnosis" id="" cols="5" rows="3" class="form-control"></textarea>
  </div>
  <div class="col-12">
    <label for="">Additional Information</label>
    <textarea name="additional_info" id="" cols="5" rows="3" class="form-control"></textarea>
  </div>
    <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
    </div>
</form>
@endsection
