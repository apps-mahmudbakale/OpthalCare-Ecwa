@extends('layouts/layoutMaster')

@section('title', 'Patients - Create Patient')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection
@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('content')
<div class="text-center mb-4">
  <h3 class="mb-2">Prepare for Admission</h3>
</div>
<hr>
<form action="" method="POST" class="row g-3" id="drugForm">
  <h5>Admission Drugs</h5>
  <table class="table table-striped" id="drugRequestTable">
    <thead>
    <tr>
      <th>Store</th>
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
</form>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const drugTableBody = document.getElementById('drugTableBody');
    const addDrugRowBtn = document.getElementById('addDrugRow');
    const form = document.getElementById('drugForm');

    // Fetch the drug stores and categories from the server-side (Laravel)
    const stores = @json(\App\Models\DrugStore::pluck('name', 'id'));
    const categories = @json(\App\Models\DrugCategory::pluck('name', 'id'));

    // Function to create options for select elements
    const createSelectOptions = (data, placeholder) => {
      return `<option value="" selected>${placeholder}</option>` +
        Object.entries(data).map(([id, name]) =>
          `<option value="${id}">${name}</option>`
        ).join('');
    };

    // Function to add a new drug row to the table
    const addDrugRow = () => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>
          <select name="store_id[]" class="form-select store-select" required>
            ${createSelectOptions(stores, 'Select Store...')}
          </select>
        </td>
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

    // Function to attach event listeners to the dynamic row elements
    const attachRowListeners = (row) => {
      const storeSelect = row.querySelector('.store-select');
      const categorySelect = row.querySelector('.category-select');
      const drugSelect = row.querySelector('.drug-select');
      const deleteBtn = row.querySelector('.delete-row');

      // Function to fetch drugs based on selected store and category
      const updateDrugs = async () => {
        if (!storeSelect.value || !categorySelect.value) return;

        try {
          const response = await fetch('/getDrugsbyStore', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
              store: storeSelect.value,
              category: categorySelect.value
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

      storeSelect.addEventListener('change', updateDrugs);
      categorySelect.addEventListener('change', updateDrugs);
      deleteBtn.addEventListener('click', () => row.remove());
    };

    // Event listener to add a new drug row
    addDrugRowBtn.addEventListener('click', addDrugRow);

    // Add the first row when the page loads
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
<hr>
<h5>Admission Investigation</h5>
<form action="{{ route('app.lab.store') }}" method="POST" class="row g-3">
  @csrf
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Make sure the document is ready before binding events
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
@endsection
