@extends('layouts/layoutMaster')

@section('title', ' Roles - Create Role')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/form-layouts.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Roles/</span> Create Role</h4>

<div class="row">
  <div class="col-xl">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Create Role</h5> 
      </div>
      <div class="card-body">
        <form action="{{route('app.roles.store')}}" method="POST">
            @csrf
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Name</label>
            <input type="text" class="form-control" name="name" id="basic-default-fullname" value="{{old('fname', isset($role) ? $role->name : '')}}" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="formtabs-language">Permissions</label>
            <select id="formtabs-language" name="permissions[]" class="select2 form-select" multiple>
                @foreach ($permissions as $permission)
                <option value="{{ $permission->id }}" {{ (in_array($permission->id, old('permissiions', [])) || isset($role) && $role->permissions->contains($permission->id)) ? 'selected' : '' }}>
                    {{ $permission->name }}
                </option>
                @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Send</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
