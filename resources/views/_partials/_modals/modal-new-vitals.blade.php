<!-- Edit User Modal -->
<div wire:ignore.self class="modal fade" id="new-vitals-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        @php
        use App\Models\Patient;
        use App\Models\Admission;

        $patientId = optional(request()->route('patient'))->id;

        if (!$patientId && request()->route('admission')) {
        $admission = Admission::find(request()->route('admission')->id);
        $patientId = optional($admission)->patient_id;
        }

        $patient = Patient::find($patientId);

        $parameter_options = [
        '' => '---------',
        'Temperature' => 'Temperature',
        'Pulse' => 'Pulse',
        'Weight' => 'Weight',
        'Blood Pressure' => 'Blood Pressure',
        'Fundus Height' => 'Fundus Height',
        'Glucose' => 'Glucose',
        'Head Circumference' => 'Head Circumference',
        'Height' => 'Height',
        'Length of Arm' => 'Length of Arm',
        'MUAC' => 'MUAC',
        'Mid-Arm Circumference' => 'Mid-Arm Circumference',
        'PCV' => 'PCV',
        'Pain Scale' => 'Pain Scale',
        'Protein' => 'Protein',
        'Respiration' => 'Respiration',
        'SpO2' => 'SpO2',
        'Surface Area' => 'Surface Area',
        'Urine' => 'Urine',
        'BMI' => 'BMI',
        'EWS' => 'EWS',
        'BSA' => 'BSA',
        'Dilation' => 'Dilation',
        'Fetal Heart Rate' => 'Fetal Heart Rate',
        ];
        @endphp

        <div class="text-center mb-4">
          <h3 class="mb-2">
            Record Vital Signs for {{ optional(optional($patient)->user)->firstname }}
          </h3>
        </div>

        <form action="{{ route('app.vitals.store') }}" method="POST" class="row g-3">
          @csrf
          <input type="hidden" name="patient_id" value="{{ $patientId }}">

          <div class="col-md-12">
            <table class="table table-striped" id="vitalSignsTable">
              <thead>
              <tr>
                <th scope="col">Parameter</th>
                <th scope="col">Value</th>
                <th scope="col">Action</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>
                  <select class="form-select" name="parameter[]" aria-label="Parameter">
                    @foreach ($parameter_options as $value => $text)
                    <option value="{{ $value }}">{{ $text }}</option>
                    @endforeach
                  </select>
                </td>
                <td><input type="text" name="value[]" class="form-control"></td>
                <td>
                  <button type="button" class="btn btn-danger btn-sm delete-row">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </td>
              </tr>
              </tbody>
            </table>

            <button type="button" class="btn btn-primary mt-2" id="addMoreBtn">Add More Reading</button>
          </div>

          <div class="col-12 text-center">
            <button type="button" data-bs-dismiss="modal" class="btn btn-secondary text-black">Close</button>
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript to add/remove rows -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const parameterOptions = @json($parameter_options);

    $('#addMoreBtn').on('click', function () {
      const selectOptions = Object.entries(parameterOptions)
        .map(([value, text]) => `<option value="${value}">${text}</option>`)
        .join('');

      const newRow = `
                <tr>
                    <td>
                        <select class="form-select" name="parameter[]">${selectOptions}</select>
                    </td>
                    <td><input type="text" name="value[]" class="form-control"></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </td>
                </tr>
            `;

      $('#vitalSignsTable tbody').append(newRow);
    });

    $(document).on('click', '.delete-row', function () {
      $(this).closest('tr').remove();
    });
  });
</script>
