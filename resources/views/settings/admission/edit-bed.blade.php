@extends('layouts/layoutMaster')

@section('title', 'Edit Bed')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Admission Settings / Beds /</span> Edit
        </h4>
        <a href="{{ route('app.beds.index') }}" class="btn btn-outline-secondary">
            <i class="ti ti-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Bed</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.beds.update', $bed->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Bed Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   id="name"
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $bed->name) }}"
                                   placeholder="Enter bed name"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ward_id" class="form-label">Ward <span class="text-danger">*</span></label>
                            <select id="ward_id" 
                                    name="ward_id" 
                                    class="form-select @error('ward_id') is-invalid @enderror"
                                    required>
                                <option value="">Select Ward</option>
                                @foreach($wards as $ward)
                                    <option value="{{ $ward->id }}" {{ old('ward_id', $bed->ward_id) == $ward->id ? 'selected' : '' }}>
                                        {{ $ward->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ward_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                            <input type="number" 
                                   id="price"
                                   name="price" 
                                   class="form-control @error('price') is-invalid @enderror" 
                                   value="{{ old('price', $bed->price) }}"
                                   placeholder="Enter bed price"
                                   step="0.01"
                                   min="0"
                                   required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="available"
                                       name="available"
                                       value="1"
                                       {{ old('available', $bed->available) ? 'checked' : '' }}>
                                <label class="form-check-label" for="available">
                                    Available
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('app.beds.index') }}" class="btn btn-label-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-1"></i> Update Bed
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
