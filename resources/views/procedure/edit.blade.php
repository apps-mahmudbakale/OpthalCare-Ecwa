@extends('layouts/layoutMaster')

@section('title', 'Patients - Create Patient')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('content')
    <form action="{{ route('app.procedure.store') }}" method="POST" class="row g-3">
        @csrf
        <div class="col-12 col-md-12">
            <label class="form-label"> Name</label>
            <input type="text" name="name" class="form-control" placeholder="Name" />
        </div>
        <div class="col-12 col-md-12">
            <label class="form-label">Category</label>
            <select name="category_id" id="" class="form-control">
                <option value="">----</option>
                @foreach (\App\Models\ProcedureCategory::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-12">
            <label class="form-label"> Procedure Cost</label>
            <input type="number" name="price" class="form-control" placeholder="Procedure Cost" />
        </div>

        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                aria-label="Close">Cancel</button>
        </div>
    </form>
@endsection
