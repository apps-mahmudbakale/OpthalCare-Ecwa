<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
    <h3 class="mb-2">Fill Prescription</h3>
    <div class="alert alert-primary d-flex align-items-center" role="alert">
        <span class="alert-icon text-primary me-2">
            <i class="ti ti-user ti-xs"></i>
        </span>
        {{ $request->patient->user->firstname }} {{ $request->patient->user->firstname }}
        [{{ app(App\Settings\SystemSettings::class)->number_prefix ?: 'HRN' }}{{ $request->patient->hospital_no }}]
    </div>
</div>
<form action="{{ route('app.pharmacy.update', $request->id) }}" method="POST" class="row g-3">
    @csrf
    @method('PUT')
    <div class="col-4 col-md-4">
        <label class="form-label"> Name</label>
        <input type="text" name="name" readonly disabled value="{{ $request->drug->name }}"
            class="form-control" />
    </div>
    <div class="col-4 col-md-4">
        <label class="form-label"> Dose</label>
        <input type="text" readonly disabled name="dose" value="{{ $request->dose }}" class="form-control" />
    </div>
    <div class="col-4 col-md-4">
        <label class="form-label"> Collected By</label>
        <input type="text" name="collected_by" class="form-control" placeholder="Collected By" />
    </div>
    <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
    </div>
</form>
