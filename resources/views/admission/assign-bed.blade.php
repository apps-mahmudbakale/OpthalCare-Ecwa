<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
  <h3 class="mb-2">Assign Bed</h3>
</div>
<form action="{{ route('app.admissions.update', $admission->id) }}" method="POST" class="row g-3">
  @csrf
  @method('PUT')
  <input type="hidden" name="patient_id" value="{{$admission->patient_id}}" />
  <input type="hidden" name="ref" value="{{$admission->ref}}" />

  <div class="col-12">
    <label class="form-label">Patient</label>
    <input type="text" class="form-control" readonly value="{{ $admission->patient->user->firstname ?? '' }} {{ $admission->patient->user->lastname ?? '' }}">
  </div>

  <div class="col-12">
    <label class="form-label">Procedure</label>
    <input type="hidden" name="procedure_id" value="{{ $admission->procedure_id }}" />
    <input type="text" class="form-control" readonly value="{{ optional($admission->procedure)->name ?? 'N/A' }}">
  </div>

  <div class="col-12">
    <label class="form-label">Ward</label>
    <select name="ward_id" id="ward" class="form-control">
      <option value="">Select Ward</option>
      @foreach(\App\Models\Ward::all() as $ward)
      <option value="{{ $ward->id }}">{{ $ward->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="col-12">
    <label class="form-label">Bed</label>
    <select name="bed_id" id="bed" class="form-control">
      <option value="">Select Bed</option>
      <!-- Populated dynamically -->
    </select>
  </div>

  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
  </div>
</form>

<script>
  $(document).ready(function () {
    $('#ward').on('change', function () {
      let wardId = $(this).val();
      let bedSelect = $('#bed');

      bedSelect.empty().append('<option value="">Loading beds...</option>');

      if (wardId) {
        $.ajax({
          url: 'getBedsByWard/' + wardId,
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
