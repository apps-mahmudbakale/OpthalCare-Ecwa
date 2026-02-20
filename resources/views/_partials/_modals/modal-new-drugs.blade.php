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

<!-- New Drugs Modal -->
<div wire:ignore.self class="modal fade" id="new-drugs-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">
            New Drugs for <span>{{ $user->firstname ?? '' }} {{ $user->lastname ?? '' }}</span>
          </h3>
        </div>

        <form action="{{ route('app.pharmacy.store') }}" method="POST" class="row g-3" id="drugForm">
          @csrf
          <input type="hidden" name="patient_id" value="{{ $patientId }}">
          <table class="table table-striped" id="drugRequestTable">
            <thead>
            <tr>
              <th>Category</th>
              <th>Drug</th>
              <th>Qty</th>
              <th>Dose</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody id="drugTableBody"></tbody>
          </table>
          <div class="col-12">
            <button type="button" class="btn btn-primary mt-2" id="addDrugRow">Add Drug</button>
          </div>
          <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const drugTableBody = document.getElementById('drugTableBody');
    const addDrugRowBtn = document.getElementById('addDrugRow');
    const form = document.getElementById('drugForm');
    const categories = @json(\App\Models\DrugCategory::pluck('name', 'id'));

    const createSelectOptions = (data, placeholder) => {
      return `<option value="" selected>${placeholder}</option>` +
        Object.entries(data).map(([id, name]) =>
          `<option value="${id}">${name}</option>`
        ).join('');
    };

    const addDrugRow = () => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>
          <select name="category_id[]" class="form-select category-select" required>
            ${createSelectOptions(categories, 'Select Category...')}
          </select>
        </td>
        <td>
          <select name="drug_id[]" class="form-select drug-select" required>
            <option value="" selected>Select Drug...</option>
          </select>
        </td>
        <td>
          <input type="number" name="qty[]" class="form-control" placeholder="Quantity" min="1" required>
        </td>
        <td>
          <input type="text" name="dose[]" class="form-control" placeholder="Dose" required>
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm delete-row">×</button>
        </td>
      `;
      drugTableBody.appendChild(row);
      attachRowListeners(row);
    };

    const attachRowListeners = (row) => {
      const categorySelect = row.querySelector('.category-select');
      const drugSelect = row.querySelector('.drug-select');
      const deleteBtn = row.querySelector('.delete-row');

      const updateDrugs = async () => {
        if (!categorySelect.value) return;

        try {
          const response = await fetch('{{ url('/getDrugsByCategory') }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
              category_id: categorySelect.value
            })
          });

          const drugs = await response.json();
          drugSelect.innerHTML = createSelectOptions(
            drugs.reduce((acc, drug) => ({ ...acc, [drug.id]: drug.name }), {}),
            'Select Drug...'
          );
        } catch (error) {
          console.error('Error fetching drugs:', error);
        }
      };

      categorySelect.addEventListener('change', updateDrugs);
      deleteBtn.addEventListener('click', () => row.remove());
    };

    addDrugRowBtn.addEventListener('click', addDrugRow);

    // Add initial row
    addDrugRow();

    // Form validation
    form.addEventListener('submit', (e) => {
      if (!form.checkValidity()) {
        e.preventDefault();
        form.reportValidity();
      }
    });
  });
</script>
