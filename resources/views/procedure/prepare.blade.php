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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('page-script')
<script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('content')
<div class="card p-3">
  <div class="text-center mb-4">
    <h3 class="mb-2">Prepare for Admission</h3>
  </div>
  <hr>
  <form action="{{route('app.admissions.store')}}" method="POST" class="row g-3" id="admissionForm">
    @csrf
    <input type="hidden" name="patient_id" value="{{$procedure->patient_id}}">
    <input type="hidden" name="request_ref" value="{{$procedure->request_ref}}">
    <div class="card p-4">
      <!-- Admission Drugs -->
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
    </div>
    <hr>
    <div class="card p-4">
      <!-- Admission Investigation -->
      <h5>Admission Investigation</h5>
      <table class="table table-striped" id="labRequestTable">
        <thead>
        <tr>
          <th>Lab Test</th>
          <th>Priority</th>
          <th>Request Note</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody id="labTableBody">
        <tr>
          <td>
            <select name="labs[test_id][]" class="form-control">
              <option value="">----</option>
              @foreach (\App\Models\Laboratory::all() as $lab)
              <option value="{{ $lab->id }}">{{ $lab->name }}</option>
              @endforeach
            </select>
          </td>
          <td>
            <select name="labs[priority][]" class="form-control">
              <option value="">---</option>
              <option value="Low">Low</option>
              <option value="Medium">Medium</option>
              <option value="High">High</option>
              <option value="Urgent">Urgent</option>
            </select>
          </td>
          <td>
            <textarea name="labs[request_note][]" class="form-control" cols="10" rows="2"></textarea>
          </td>
          <td>
            <button type="button" class="btn btn-danger btn-sm delete-row">×</button>
          </td>
        </tr>
        </tbody>
      </table>
      <div class="col-12">
        <button type="button" class="btn btn-primary mt-2" id="addLabRow">More Lab Test</button>
      </div>
    </div>
<!--    <hr>-->
<!--    <div class="card h-100  card-border-shadow-primary p-4">-->
<!--      <!-- Admission Room -->-->
<!--      <h5>Admission Room</h5>-->
<!--      <div class="col-md-12">-->
<!--        <label for="ward_id">Ward</label>-->
<!--        <select name="ward_id" id="ward_id" class="form-control" required>-->
<!--          <option value="">Select Ward...</option>-->
<!--          @foreach(\App\Models\Ward::all() as $ward)-->
<!--          <option value="{{ $ward->id }}">{{ $ward->name }}</option>-->
<!--          @endforeach-->
<!--        </select>-->
<!--      </div>-->
<!--      <div class="col-md-12">-->
<!--        <label for="bed_id">Bed</label>-->
<!--        <select name="bed_id" id="bed_id" class="form-control" required>-->
<!--          <option value="">Select Bed...</option>-->
<!--        </select>-->
<!--      </div>-->
<!--    </div>-->


    <!-- Submit Button -->
    <div class="col-12 text-center mt-4">
      <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit Admission</button>
      <button type="reset" class="btn btn-label-secondary">Reset</button>
    </div>
  </form>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const drugTableBody = document.getElementById('drugTableBody');
      const addDrugRowBtn = document.getElementById('addDrugRow');
      const form = document.getElementById('admissionForm');
      const stores = @json(\App\Models\DrugStore::pluck('name', 'id'));
      const categories = @json(\App\Models\DrugCategory::pluck('name', 'id'));

      // Function to create select options
      const createSelectOptions = (data, placeholder) => {
        return `<option value="" selected>${placeholder}</option>` +
          Object.entries(data).map(([id, name]) =>
            `<option value="${id}">${name}</option>`
          ).join('');
      };

      // Add Drug Row
      const addDrugRow = () => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <select name="drugs[store_id][]" class="form-select store-select" required>
                    ${createSelectOptions(stores, 'Select Store...')}
                </select>
            </td>
            <td>
                <select name="drugs[category_id][]" class="form-select category-select" required>
                    ${createSelectOptions(categories, 'Select Category...')}
                </select>
            </td>
            <td>
                <select name="drugs[drug_id][]" class="form-select drug-select" required>
                    <option value="" selected>Select Drug...</option>
                </select>
            </td>
            <td>
                <input type="number" name="drugs[qty][]" class="form-control" placeholder="Quantity" min="1" required>
            </td>
            <td>
                <input type="text" name="drugs[dose][]" class="form-control" placeholder="Dose" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm delete-row">×</button>
            </td>
        `;
        drugTableBody.appendChild(row);
        attachDrugRowListeners(row);
      };

      // Attach listeners to drug row
      const attachDrugRowListeners = (row) => {
        const storeSelect = row.querySelector('.store-select');
        const categorySelect = row.querySelector('.category-select');
        const drugSelect = row.querySelector('.drug-select');
        const deleteBtn = row.querySelector('.delete-row');

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

      // Add Lab Row
      $('#addLabRow').on('click', function () {
        const newRow = `
            <tr>
                <td>
                    <select name="labs[test_id][]" class="form-control">
                        <option value="">----</option>
                        @foreach (\App\Models\Laboratory::all() as $lab)
                            <option value="{{ $lab->id }}">{{ $lab->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="labs[priority][]" class="form-control">
                        <option value="">---</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        <option value="Urgent">Urgent</option>
                    </select>
                </td>
                <td>
                    <textarea name="labs[request_note][]" class="form-control" cols="10" rows="2"></textarea>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">×</button>
                </td>
            </tr>
        `;
        $('#labTableBody').append(newRow);
      });

      // Delete Lab Row
      $(document).on('click', '.delete-row', function () {
        $(this).closest('tr').remove();
      });

      // Fetch Beds by Ward
      document.getElementById('ward_id').addEventListener('change', async function () {
        const wardId = this.value;
        const bedSelect = document.getElementById('bed_id');

        if (!wardId) {
          bedSelect.innerHTML = '<option value="">Select Bed...</option>';
          return;
        }

        try {
          const response = await fetch('/app/getBedsByWard', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ward_id: wardId })
          });

          const beds = await response.json();
          bedSelect.innerHTML = '<option value="">Select Bed...</option>' +
            Object.entries(beds).map(([id, name]) =>
              `<option value="${id}">${name}</option>`
            ).join('');
        } catch (error) {
          console.error('Error fetching beds:', error);
        }
      });

      // Add initial drug row
      addDrugRowBtn.addEventListener('click', addDrugRow);
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
</div>
@endsection
