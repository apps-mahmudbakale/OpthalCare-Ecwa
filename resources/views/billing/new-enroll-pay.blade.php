@extends('layouts/layoutMaster')

@section('title', 'Billings')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/fullcalendar/fullcalendar.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-calendar.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/fullcalendar/fullcalendar.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('assets/js/app-calendar-events.js') }}"></script>
<script src="{{ asset('assets/js/app-calendar.js') }}"></script>
@endsection

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="card">
  <div class="px-3 py-4">
    <div class="text-center mb-4">
      <h3 class="mb-2">Receive Payment</h3>
    </div>
    <form action="{{route('app.payments.new-enroll')}}" method="POST">
      @csrf
      <div class="form-group">
        <input type="hidden" name="billing_id" value="{{$billingRecord->id}}">
        <input type="hidden" name="patient_id" value="{{$billingRecord->user_id}}">
        <div class="form-label-group">
          <select name="location_id" class="custom-select" id="fls0" required="required">
            <option value=""> Choose...</option>
            @foreach(\App\Models\CashPoint::all() as $cashpoint)
            <option value="{{$cashpoint->id}}">{{$cashpoint->name}}</option>
            @endforeach
          </select>
          <label for="fls0">Cash Point</label>
        </div>
      </div>
      <div class="form-group">
        <div class="form-label-group">
          <select name="payment_method_id" class="custom-select" id="fls1" required="required">
            <option value=""> Choose...</option>
            @foreach(\App\Models\PaymentMethod::all() as $method)
            <option value="{{$method->id}}">{{$method->name}}</option>
            @endforeach
          </select>
          <label for="fls1">Payment Method</label>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-6">
          <div class="form-label-group">
            <input value="{{ $billingRecord->amount }}" name="amount" required="required"
                   autocomplete="off" type="text" class="form-control form-control-lg -text-right"
            >
            <label for="fls2">Paying Amount</label>
          </div>

        </div>
        <div class="form-group col-md-6">
          <div class="form-label-group">
            <input id="fls3" name="reference" autocomplete="off" type="text"
                   class="form-control form-control-lg -text-right">
            <label for="fls3">Reference</label>
          </div>
        </div>
      </div>
      <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                aria-label="Close">Cancel</button>
      </div>
    </form>

  </div>
</div>
@endsection
