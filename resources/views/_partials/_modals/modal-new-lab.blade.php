@php
use App\Models\Patient;
use App\Models\Admission;

$patientId = optional(request()->route('patient'))->id;

if (!$patientId && request()->route('admission')) {
$admission = Admission::find(request()->route('admission')->id);
$patientId = optional($admission)->patient_id;
}

$patient = Patient::find($patientId);
$user = optional($patient)->user;
@endphp

<!-- Edit User Modal -->
<div wire:ignore.self class="modal fade" id="new-lab-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">New Lab for {{ $user->firstname ?? '' }} {{ $user->lastname ?? '' }}</h3>
        </div>

        <form action="{{ route('app.lab.store') }}" method="POST" class="row g-3">
          @csrf
          <input type="hidden" name="patient_id" value="{{ $patientId }}">
          <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

          <table class="table table-striped" id="labRequestTable">
            <thead>
            <tr>
              <th scope="col">Lab Test</th>
              <th scope="col">Priority</th>
              <th scope="col">Request Note</th>
              <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>
                <select name="test_id[]" class="form-control">
                  <option value="">----</option>
                  @foreach (\App\Models\Laboratory::all() as $lab)
                  <option value="{{ $lab->id }}">{{ $lab->name }}</option>
                  @endforeach
                </select>
              </td>
              <td>
                <select name="priority[]" class="form-control">
                  <option value="">---</option>
                  <option value="Low">Low</option>
                  <option value="Medium">Medium</option>
                  <option value="High">High</option>
                  <option value="Urgent">Urgent</option>
                </select>
              </td>
              <td>
                <textarea name="request_note[]" class="form-control" cols="10" rows="2"></textarea>
              </td>
              <td>
                <button type="button" class="btn btn-danger btn-sm delete-row">
                  <span aria-hidden="true">&times;</span>
                </button>
              </td>
            </tr>
            </tbody>
          </table>

          <div class="col-12">
            <button type="button" class="btn btn-primary mt-2" id="addMoreBtn">More Lab Test</button>
          </div>

          <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-label-secondary">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $(document).on('click', '#addMoreBtn', function () {
      const newRow = `
        <tr>
          <td>
            <select name="test_id[]" class="form-control">
              <option value="">----</option>
              @foreach (\App\Models\Laboratory::all() as $lab)
                <option value="{{ $lab->id }}">{{ $lab->name }}</option>
              @endforeach
            </select>
          </td>
          <td>
            <select name="priority[]" class="form-control">
              <option value="">---</option>
              <option value="Low">Low</option>
              <option value="Medium">Medium</option>
              <option value="High">High</option>
              <option value="Urgent">Urgent</option>
            </select>
          </td>
          <td>
            <textarea name="request_note[]" class="form-control" cols="10" rows="2"></textarea>
          </td>
          <td>
            <button type="button" class="btn btn-danger btn-sm delete-row">
              <span aria-hidden="true">&times;</span>
            </button>
          </td>
        </tr>
      `;
      $('#labRequestTable tbody').append(newRow);
    });

    $(document).on('click', '.delete-row', function () {
      $(this).closest('tr').remove();
    });
  });
</script>
