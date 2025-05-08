<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
    <h3 class="mb-2">Fill Prescription</h3>
    <div class="alert alert-info d-flex text-gray align-items-center" role="alert">
        <span class="alert-icon text-primary me-2">
            <i class="ti ti-user ti-xs"></i>
        </span>
      @php
      $firstRequest = $requests->first();
      $patient = $firstRequest?->patient;
      $user = $patient?->user;
      $hospitalNo = $patient?->hospital_no;
      $prefix = app(App\Settings\SystemSettings::class)->number_prefix ?? 'HRN';
      @endphp

      @if($user && $hospitalNo)
      <p class="mt-3 ml-5">
        {{ $user->firstname }} {{ $user->lastname }}
        [{{ $prefix }}{{ $hospitalNo }}]
      </p>
      @else
      <p class="mt-3 ml-5 text-red-500">Patient information not available.</p>
      @endif
    </div>
</div>
<form action="{{ route('app.pharmacy.update', $firstRequest?->request_ref) }}" method="POST" class="row g-3">
    @csrf
    @method('PUT')
  @foreach($requests as $request)
    <div class="col-3 col-md-3">
        <label class="form-label"> Name</label>
        <input type="text" name="name[]" readonly disabled value="{{ $request->drug->name }}"
            class="form-control" />
    </div>
  <div class="col-3 col-md-3">
    <label class="form-label"> QTY</label>
    <input type="text"  name="qty[]" value="{{ $request->qty }}" class="form-control" />
  </div>
    <div class="col-3 col-md-3">
        <label class="form-label"> Dose</label>
        <input type="text" readonly disabled name="dose[]" value="{{ $request->dose }}" class="form-control" />
    </div>
    <div class="col-3 col-md-3">
        <label class="form-label"> Collected By</label>
        <input type="text" name="collected_by[]" class="form-control" placeholder="Collected By" />
    </div>
  @endforeach
    <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
    </div>
</form>
