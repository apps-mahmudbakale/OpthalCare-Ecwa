<!-- Antenatal Vitals Modal -->
<div wire:ignore.self class="modal fade" id="new-vitals-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        @php
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
            Record Vital Signs for {{ $patient->user->firstname }} {{ $patient->user->lastname }}
          </h3>
          <p class="text-muted">Antenatal Visit - {{ $record->visit_date ? $record->visit_date->format('M d, Y') : $record->created_at->format('M d, Y') }}</p>
        </div>

        <form action="{{ route('app.vitals.store') }}" method="POST" class="row g-3" id="antenatalVitalsForm">
          @csrf
          <input type="hidden" name="patient_id" value="{{ $patient->id }}">

          <div class="col-md-12">
            <table class="table table-striped" id="antenatalVitalSignsTable">
              <thead>
              <tr>
                <th scope="col">Parameter <span class="text-danger">*</span></th>
                <th scope="col">Value <span class="text-danger">*</span></th>
                <th scope="col">Action</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>
                  <select class="form-select" name="parameter[]" aria-label="Parameter" required>
                    @foreach ($parameter_options as $value => $text)
                    <option value="{{ $value }}">{{ $text }}</option>
                    @endforeach
                  </select>
                </td>
                <td><input type="text" name="value[]" class="form-control" placeholder="Enter value" required></td>
                <td>
                  <button type="button" class="btn btn-danger btn-sm delete-row">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </td>
              </tr>
              </tbody>
            </table>

            <button type="button" class="btn btn-primary mt-2" id="addMoreAntenatalBtn">Add More Reading</button>
          </div>

          <div class="col-12 text-center">
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary">Close</button>
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Record Vitals</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript to add/remove rows -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const antenatalParameterOptions = @json($parameter_options);

    $('#addMoreAntenatalBtn').on('click', function () {
      const selectOptions = Object.entries(antenatalParameterOptions)
        .map(([value, text]) => `<option value="${value}">${text}</option>`)
        .join('');

      const newRow = `
                <tr>
                    <td>
                        <select class="form-select" name="parameter[]" required>${selectOptions}</select>
                    </td>
                    <td><input type="text" name="value[]" class="form-control" placeholder="Enter value" required></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </td>
                </tr>
            `;

      $('#antenatalVitalSignsTable tbody').append(newRow);
    });

    $(document).on('click', '.delete-row', function () {
      // Don't allow deletion if it's the only row
      if ($('#antenatalVitalSignsTable tbody tr').length > 1) {
        $(this).closest('tr').remove();
      } else {
        alert('At least one vital sign entry is required.');
      }
    });

    // Form validation
    $('#antenatalVitalsForm').on('submit', function(e) {
      let isValid = true;
      let errorMessage = '';

      // Check each row for valid parameter and value
      $('#antenatalVitalSignsTable tbody tr').each(function() {
        const parameter = $(this).find('select[name="parameter[]"]').val();
        const value = $(this).find('input[name="value[]"]').val().trim();

        if (!parameter || parameter === '') {
          isValid = false;
          errorMessage = 'Please select a parameter for all entries.';
          return false;
        }

        if (!value || value === '') {
          isValid = false;
          errorMessage = 'Please enter a value for all entries.';
          return false;
        }
      });

      if (!isValid) {
        e.preventDefault();
        alert(errorMessage);
        return false;
      }
    });
  });
</script>