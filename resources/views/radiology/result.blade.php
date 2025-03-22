<div class="text-center mb-4">
  <h6 class="mb-2">{{ \App\Models\Radiology::where('id', $request->imaging_id)->first()->name }} Result for {{\App\Models\Patient::where('id', $request->imaging_id)->first()->user->firstname }} {{\App\Models\Patient::where('id', $request->imaging_id)->first()->user->lastname }} </h6>
</div>
<form method="post" action="{{route('app.radiology.add.result')}}" class="row g-3">
  @csrf
  <div class="col-12 col-md-12">
    <div class="alert alert-primary d-flex align-items-center">
        <span class="alert-icon text-primary me-2">
            <i class="ti ti-user ti-xs"></i>
        </span>
      <p class="mt-3 ml-5">{{$request->request_note}}</p>
    </div>
    <label class="form-label"> Result</label>
    <input type="hidden" name="patient_id" value="{{$request->patient_id}}">
    <input type="hidden" name="imaging_id" value="{{$request->id}}">
    <textarea name="result" class="form-control" id="" cols="30" rows="10"></textarea>
  </div>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
  </div>
</form>
