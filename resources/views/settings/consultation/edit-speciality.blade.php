@extends('layouts/layoutMaster')

@section('title', 'Edit Speciality')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Consultation Settings / Specialities /</span> Edit
        </h4>
        <a href="{{ route('app.specialities.index') }}" class="btn btn-outline-secondary">
            <i class="ti ti-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Speciality</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.specialities.update', $speciality->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Speciality Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   id="name"
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $speciality->name) }}"
                                   placeholder="Enter speciality name"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('app.specialities.index') }}" class="btn btn-label-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-1"></i> Update Speciality
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection