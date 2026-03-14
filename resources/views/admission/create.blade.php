<div class="modal-body">
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  <div class="text-center">
    <h3 class="mb-2">Request Admission</h3>
  </div>
  <form method="post" action="{{route('app.admissions.store-request')}}" id="new-admission-form">
    @csrf
    <div class="alert alert-danger d-none"></div>
    <div class="modal-body">
      <div class="row">
        <div class="form-group col-md-12 mb-3">
          <label for="id_patient_selected">
            Patient<span class="align-middle fa-2x- text-danger"> *</span>
          </label>
          <input type="hidden" name="patient_id" value="{{$patient->id}}">
          <input type="text" name="patient_name"
                 value="{{ $patient->user->firstname . ' ' . $patient->user->middlename . ' ' . $patient->user->lastname }}"
                 readonly disabled class="form-control">
        </div>
        <div class="form-group col-md-12 mb-3">
          <label for="ward_id">Ward<span class="text-danger"> *</span></label>
          <select name="ward_id" id="ward_id" class="form-control" required>
            <option value="">Select Ward</option>
            @foreach($wards as $ward)
              <option value="{{$ward->id}}">{{$ward->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-12 mb-3">
          <label for="bed_id">Bed<span class="text-danger"> *</span></label>
          <select name="bed_id" id="bed_id" class="form-control" required>
            <option value="">Select Ward First</option>
          </select>
        </div>
        <div class="form-group col-md-12">
          <label for="reason_for_admission">Reason for Admission<span class="text-danger"> *</span></label>
          <textarea name="reason_for_admission" id="reason_for_admission" class="form-control" rows="3" required></textarea>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
      <button type="submit" class="btn btn-primary">Submit Request</button>
    </div>
  </form>
</div>

<script>
  $(document).ready(function () {
    $('#ward_id').on('change', function () {
      let wardId = $(this).val();
      let bedSelect = $('#bed_id');

      bedSelect.empty().append('<option value="">Loading beds...</option>');

      if (wardId) {
        $.ajax({
          url: '{{ route("app.getBedsByWard", ["wardId" => ":wardId"]) }}'.replace(':wardId', wardId),
          type: 'GET',
          success: function (response) {
            bedSelect.empty().append('<option value="">Select Bed</option>');
            $.each(response, function (key, bed) {
              bedSelect.append('<option value="' + bed.id + '">' + bed.name + '</option>');
            });
          },
          error: function () {
            bedSelect.empty().append('<option value="">Error loading beds</option>');
          }
        });
      } else {
        bedSelect.empty().append('<option value="">Select Ward First</option>');
      }
    });
  });
</script>

