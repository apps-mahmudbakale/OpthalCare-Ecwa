<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
  <h3 class="mb-2">Bill  for Admission</h3>
</div>
<form action="{{ route('app.admissions.bill.post') }}" method="POST" class="row g-3">
  @csrf
  <div class="col-12 col-md-12">
    <label class="form-label"> Patient</label>
    <input type="hidden" name="patient_id" value="{{$admission->patient_id}}" class="form-control" />
    <input type="hidden" name="ref" value="{{$admission->ref}}" class="form-control" />
    <input type="text" class="form-control" readonly value="{{$admission->patient->user->firstname ?? '' }} {{ $admission->patient->user->lastname ?? ''}}" />
  </div>
  <div class="col-12 col-md-12">
    <label class="form-label"> Procedure </label>
    <input type="hidden" name="procedure_id" value="{{$admission->procedure_id}}" class="form-control" />
    <input type="text" class="form-control" readonly value="{{ optional($admission->procedureRequests->first())->procedure->name ?? 'N/A' }}" />
  </div>
  <div class="col-12 col-md-12">
    <label class="form-label"> Amount</label>
    <input type="number" name="amount" class="form-control" placeholder="Admission Bill" />
  </div>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
  </div>
</form>
