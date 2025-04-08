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
<form action="{{ route('app.refraction.update', $refraction->id) }}" method="POST" class="row g-3">
  @csrf
  @method('PUT')
  <input type="hidden" name="patient_id" value="{{ $patient->id }}">
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
      <td><input type="text" name="distance_right" value="{{$refraction->distance_right ?? ''}}" class="form-control"></td>
      <td><input type="text" name="ph_right" value="{{$refraction->ph_right ?? ''}}" class="form-control"></td>
    </tr>
    <tr>
      <td width="70%">LEFT</td>
      <td><input type="text" name="distance_left" value="{{$refraction->distance_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="ph_left" value="{{$refraction->ph_left ?? ''}}" class="form-control"></td>
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
      <td><input type="text" name="near_right" value="{{$refraction->near_right ?? ''}}" class="form-control"></td>
    </tr>
    <tr>
      <td width="80%">LEFT</td>
      <td><input type="text" name="near_left" value="{{$refraction->near_left ?? ''}}" class="form-control"></td>
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
      <td><input type="text" name="sph_glass_right" value="{{$refraction->sph_glass_right ?? ''}}" class="form-control"></td>
      <td><input type="text" name="cyl_glass_right" value="{{$refraction->cyl_glass_right ?? ''}}" class="form-control"></td>
      <td><input type="text" name="axis_glass_right" value="{{$refraction->axis_glass_right ?? ''}}" class="form-control"></td>
      <td><input type="text" name="prism_glass_right" value="{{$refraction->prism_glass_right ?? ''}}" class="form-control"></td>
      <td><input type="text" name="base_glass_right" value="{{$refraction->base_glass_right ?? ''}}" class="form-control"></td>
      <td><input type="text" name="va_glass_right" value="{{$refraction->va_glass_right ?? ''}}" class="form-control"></td>
      <td><input type="text" name="add_glass_right" value="{{$refraction->add_glass_right ?? ''}}" class="form-control"></td>
      <td><input type="text" name="va2_glass_right" value="{{$refraction->va2_glass_right ?? ''}}" class="form-control"></td>
    </tr>
    <tr>
      <td width="10%">LEFT</td>
      <td><input type="text" name="sph_glass_left" value="{{$refraction->sph_glass_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="cyl_glass_left" value="{{$refraction->cyl_glass_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="axis_glass_left" value="{{$refraction->axis_glass_left ?? ''}}"class="form-control"></td>
      <td><input type="text" name="prism_glass_left" value="{{$refraction->prism_glass_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="base_glass_left" value="{{$refraction->base_glass_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="va_glass_left"   value="{{$refraction->va_glass_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="add_glass_left" value="{{$refraction->add_glass_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="va2_glass_left" value="{{$refraction->va2_glass_left ?? ''}}" class="form-control"></td>
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
      <td><input type="text" name="auto_refraction_right" value="{{$refraction->auto_refraction_glass_right ?? ''}}" class="form-control"></td>
      <td><input type="text" name="va_auto_right" value="{{$refraction->va_auto_glass_right ?? ''}}" class="form-control"></td>
    </tr>
    <tr>
      <td width="50%">LEFT</td>
      <td><input type="text" name="auto_refraction_left" value="{{$refraction->auto_refraction_glass_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="va_auto_left" value="{{$refraction->va_auto_glass_left ?? ''}}" class="form-control"></td>
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
      <td><input type="text" name="sph_retino_right" value="{{$refraction->sph_retino_right ?? ''}}" class="form-control form-control-lg"></td>
      <td><input type="text" name="cyl_retino_right" value="{{$refraction->cyl_retino_right ?? ''}}" class="form-control"></td>
      <td><input type="text" name="axis_retino_right" value="{{$refraction->axis_retino_right ?? ''}}" class="form-control"></td>
      <td><input type="text" name="va_retino_right" value="{{$refraction->va_retino_right ?? ''}}" class="form-control"></td>
    </tr>
    <tr>
      <td width="50%">LEFT</td>
      <td><input type="text" name="sph_retino_left" value="{{$refraction->sph_retino_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="cyl_retino_left" value="{{$refraction->cyl_retino_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="axis_retino_left" value="{{$refraction->axis_retino_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="va_retino_left" value="{{$refraction->va_retino_left ?? ''}}" class="form-control"></td>
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
      <td><input type="text" name="sph_subj_right" value="{{$refraction->sph_subj_right ?? ''}}" class="form-control"></td>
      <td><input type="text" name="cyl_subj_right"  value="{{$refraction->cyl_subj_right ?? ''}}" class="form-control"></td>
      <td><input type="text" name="axis_subj_right"   value="{{$refraction->axis_sph_subj_right ?? ''}}"class="form-control"></td>
      <td><input type="text" name="prism_subj_right"  value="{{$refraction->prism_subj_right ?? ''}}" class="form-control"></td>
      <td><input type="text" name="base_subj_right"  value="{{$refraction->base_subj_right ?? ''}}" class="form-control"></td>
      <td><input type="text" name="va_subj_right"  value="{{$refraction->va_subj_right ?? ''}}"class="form-control"></td>
      <td><input type="text" name="add_subj_right"  value="{{$refraction->add_subj_right ?? ''}}"class="form-control"></td>
      <td><input type="text" name="va2_subj_right"  value="{{$refraction->va2_subj_right ?? ''}}" class="form-control"></td>
    </tr>
    <tr>
      <td width="10%">LEFT</td>
      <td><input type="text" name="sph_subj_left"  value="{{$refraction->sph_subj_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="cyl_subj_left" value="{{$refraction->cyl_subj_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="axis_subj_left" value="{{$refraction->axis_subj_left ?? ''}}"class="form-control"></td>
      <td><input type="text" name="prism_subj_left" value="{{$refraction->prism_subj_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="base_subj_left" value="{{$refraction->base_subj_left ?? ''}}"  class="form-control"></td>
      <td><input type="text" name="va_subj_left" value="{{$refraction->va_subj_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="add_subj_left" value="{{$refraction->add_subj_left ?? ''}}" class="form-control"></td>
      <td><input type="text" name="va2_subj_left" value="{{$refraction->va2_subj_left ?? ''}}" class="form-control"></td>
    </tr>
    </tbody>
  </table>
  <div class="col-12">
    <label for="">Diagnosis</label>
    <textarea name="diagnosis" id="" cols="5" rows="3" class="form-control">{{$refraction->diagnosis ?? ''}}</textarea>
  </div>
  <div class="col-12">
    <label for="">Additional Information</label>
    <textarea name="additional_info" id="" cols="5" rows="3" class="form-control">{{$refraction->additional_info ?? ''}}</textarea>
  </div>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
  </div>
</form>
@endsection
