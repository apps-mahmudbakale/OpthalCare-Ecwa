@extends('layouts/layoutMaster')

@section('title', 'Vital Care Settings')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('page-style')
  <!-- Page -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">
@endsection

@section('vendor-script')
  <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/cards-advance.js') }}"></script>
  {{-- <script src="{{asset('assets/js/modal-edit-user.js')}}"></script> --}}
  <script src="https://unpkg.com/papaparse@latest/papaparse.min.js"></script>

@endsection

@section('content')
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Patient Profile</span>
  </h4>

  <div class="row">
    <!--/ Sales By Country -->
    <div class="col-xl-12 col-md-12 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2">Update Patient Allergy</h5>
          </div>
        </div>
        <div class="card-body">
          <form action="{{route('app.allergies.update', $allergy->id)}}" method="POST" class="row g-3">
            <form  method="POST" class="row g-3">
              @csrf
              @method('PUT')
              <div class="col-12 col-md-12">
                <label class="form-label">Type</label>
                <select name="type" id="type" class="form-control">
                  <option value="{{$allergy->type}}" selected>{{$allergy->type_text}}</option>
                  <option value="1">Drug</option>
                  <option value="2">Food</option>
                  <option value="3">Latex</option>
                  <option value="4">Environmental Irritant</option>
                  <option value="5">Mold</option>
                  <option value="6">Other</option>
                </select>
              </div>
              <div class="col-12 col-md-12">
                <label class="form-label"> Allergen</label>
                <input type="text" name="allergen" value="{{old('allergen', isset($allergy) ? $allergy->allergen : '')}}" class="form-control" placeholder="allergen name"
                        />
              </div>
              <div class="col-12 col-md-12">
                <label class="form-label"> Reation To Allergen</label>
                <input type="text" name="reaction_to_allergen" value="{{old('reaction_to_allergen', isset($allergy) ? $allergy->reaction_to_allergen : '')}}" class="form-control" placeholder="I get dizzy"
                       />
              </div>
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                <a href="{{route('app.patients.show', $allergy->patient_id)}}" class="btn btn-label-secondary" data-bs-dismiss="modal"
                   aria-label="Close">Cancel</a>
              </div>
            </form>
        </div>
      </div>
    </div>
    <!--/ Sales By Country -->
  </div>
@endsection
