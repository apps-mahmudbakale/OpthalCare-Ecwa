@extends('layouts/layoutMaster')

@section('title', ' Users - Edit User')

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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Users/</span> Update User</h4>

<div class="row">
  <div class="col-xl">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Update User</h5> 
      </div>
      <div class="card-body">
        <form action="{{route('app.users.update', $user->id)}}" method="POST">
            @csrf
            @method('PUT')
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">First Name</label>
            <input type="text" class="form-control" name="firstname" id="basic-default-fullname" value="{{old('firstname', isset($user) ? $user->firstname : '')}}" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-company">Last Name</label>
            <input type="text" class="form-control" id="basic-default-company" name="lastname" value="{{old('lastname', isset($user) ? $user->lastname : '')}}" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-email">Email</label>
            <div class="input-group input-group-merge">
              <input type="text" id="basic-default-email" class="form-control" name="email" value="{{old('email', isset($user) ? $user->email : '')}}" />
              <span class="input-group-text" id="basic-default-email2">@example.com</span>
            </div>
            <div class="form-text"> You can use letters, numbers & periods </div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-phone">Phone No</label>
            <input type="text" id="basic-default-phone" class="form-control phone-mask" name="phone" value="{{old('phone', isset($user) ? $user->phone : '')}}" placeholder="658 799 8941" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="formtabs-language">Role</label>
            <select id="formtabs-language" name="roles[]" class="select2 form-select" multiple>
                @foreach ($roles as $role)
                <option value="{{ $role->id }}" {{ (in_array($role->id, old('roles', [])) || isset($user) && $user->roles->contains($role->id)) ? 'selected' : '' }}>
                    {{ $role->name }}
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
