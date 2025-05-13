<div class="modal-body">
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  <div class="text-center">
    <h3 class="mb-2">Request Admission</h3>
  </div>
  <form method="post" action="{{route('app.procedure-requests.store')}}" id="new-appointment-form">
    @csrf
    <div class="alert alert-danger d-none"></div>
    <div class="modal-body">
      <div class="row">
        <div class="form-group col-md-12">
          <label for="id_patient_selected">
            Patient<span class="align-middle fa-2x- text-danger"> *</span>
          </label>
          <input type="hidden" name="patient_id" value="{{$patient->id}}">
          <input type="text" name="patient_name"
                 value="{{ $patient->user->firstname . ' ' . $patient->user->middlename . ' ' . $patient->user->lastname }}"
                 readonly disabled class="form-control">
        </div>
        <div class="form-group col-md-12"> <label for="id_group">
            Procedure
            <span class="align-middle fa-2x- text-danger"> *</span> </label>
          <select name="procedure_id" class="selectpicker form-control" data-style="custom-select"
                  autocomplete="off" required="" id="id_group" tabindex="-98">
            <option value="" selected="">---------</option>
            @foreach(\App\Models\Procedure::all() as $procedure)
            <option value="{{$procedure->id}}">{{$procedure->name}}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
      <button type="submit" class="btn btn-primary">Request</button>
    </div>
  </form>
</div>

