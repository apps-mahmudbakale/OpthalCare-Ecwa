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
            <label class="form-label d-block">Permissions</label>
            <div class="row">
              @foreach ($permissions as $permission)
              <div class="col-md-6 mb-2">
                <label class="switch switch-primary">
                  <input type="checkbox" class="switch-input" name="permissions[]" value="{{ $permission->id }}"
                         {{ (in_array($permission->id, old('permissions', [])) || (isset($role) && $role->permissions->contains($permission->id))) ? 'checked' : '' }}>
                  <span class="switch-toggle-slider">
            <span class="switch-on">
              <i class="icon-base ti tabler-check"></i>
            </span>
            <span class="switch-off">
              <i class="icon-base ti tabler-x"></i>
            </span>
          </span>
                  <span class="switch-label">{{ ucfirst($permission->name) }}</span>
                </label>
              </div>
              @endforeach
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Send</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
