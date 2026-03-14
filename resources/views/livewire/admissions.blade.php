<div>
  <div class="card">
    <!-- Filter Header -->
    <div class="card-header">
      <div class="d-flex justify-content-between flex-wrap">
        <!-- Patient Filter -->
        <div class="form-group mr-2 flex-fill">
          <label for="patient_id">Filter By Patient</label>
          <select wire:model="patient_id" id="patient_id" class="form-control">
            <option value="">All Patients</option>
            @foreach($patients as $patient)
            <option value="{{ $patient->id }}">
              {{ $patient->user->firstname }} {{ $patient->user->lastname }}
            </option>
            @endforeach
          </select>
        </div>

        <!-- Ward Filter -->
        <div class="form-group flex-fill">
          <label for="ward_id">Filter By Ward</label>
          <select wire:model="ward_id" id="ward_id" class="form-control">
            <option value="">All Wards</option>
            @foreach($wards as $ward)
            <option value="{{ $ward->id }}">{{ $ward->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
        <tr>
          <th>Date Admitted</th>
          <th>Patient</th>
          <th>Ward</th>
          <th>Bed</th>
          <th class="text-right">*</th>
        </tr>
        </thead>
        <tbody>
        @forelse($admissions as $admission)
        <tr>
          <td>{{ $admission->created_at->format('Y-m-d') ?? 'N/A' }}</td>
          <td>{{ $admission->patient->user->firstname ?? '' }} {{ $admission->patient->user->lastname ?? '' }}</td>
          <td>{{ $admission->ward->name ?? 'N/A' }}</td>
          <td>{{ $admission->bed->name ?? 'N/A' }}</td>
          <td class="text-right">
                  <a href="{{route('app.admissions.show', $admission->id)}}">
                    Open Instance
                  </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center">No active admissions found.</td>
        </tr>
        @endforelse
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="d-flex justify-content-center mt-3">
        {{ $admissions->links() }}
      </div>
    </div>
  </div>

  @include('_partials._modals.global-modal')
</div>

<!-- Modal script -->
<script>
  $(document).ready(function () {
    $('.dropdown-item').on('click', function () {
      var requestUrl = $(this).data('request-url');
      $.ajax({
        url: requestUrl,
        type: 'GET',
        success: function (response) {
          $('#global-modal .modal-body').html(response);
          $('#global-modal').modal('show');
        },
        error: function (xhr, status, error) {
          console.error(error);
        }
      });
    });
  });
</script>
