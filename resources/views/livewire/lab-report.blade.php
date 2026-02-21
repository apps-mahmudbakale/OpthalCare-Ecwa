<div>
  <div class="card">
    <!-- Filter Header -->
    <div class="card-header">
      <form class="filterForm d-flex justify-content-between align-items-end flex-wrap">
        <div class="form-group flex-fill ml-2">
          <label class="mb-0" for="id_category">Filter By Category</label>
          <select wire:model="category_id" id="id_category" class="custom-select form-control">
            <option value="">- All -</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ strtoupper($category->name) }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group flex-fill ml-2">
          <label class="mb-0" for="id_status">Filter By Request Status</label>
          <select wire:model="status" id="id_status" class="custom-select form-control">
            <option value="">- All -</option>
            <option value="Pending">Pending</option>
            <option value="Specimen Collected">Specimen Collected</option>
            <option value="Result Ready">Result Ready</option>
            <option value="Cancelled">Cancelled</option>
          </select>
        </div>

        <div class="form-group flex-fill ml-2">
          <label class="mb-0">Start Date</label>
          <input wire:model="startDate" type="text" class="form-control flatpickr" placeholder="YYYY-MM-DD">
        </div>

        <!-- End Date -->
        <div class="form-group flex-fill ml-2">
          <label class="mb-0">End Date</label>
          <input wire:model="endDate" type="text" class="form-control flatpickr" placeholder="YYYY-MM-DD">
        </div>

        <div class="form-group flex-fill ml-2 no-label">
          <button wire:click="export" class="btn btn-primary px-3 mt-4" type="button" id="export-btn">
            <i class="fa fa-download"></i>
          </button>
        </div>
      </form>
    </div><!-- /.card-header -->

    <!-- Table -->
    <div class="table-responsive text-nowrap">
      <table class="table table-hover">
        <thead>
        <tr>
          <th>Date</th>
          <th>Patient</th>
          <th>Investigation</th>
          <th>Category</th>
          <th>Status</th>
        </tr>
        </thead>
        <tbody class="table-border-bottom-0">
        @forelse($labReports as $report)
        <tr>
          <td>{{ $report->created_at->format('d M Y') }}</td>
          <td>
            <span class="fw-medium">
              {{ $report->patient && $report->patient->user ? $report->patient->user->firstname . ' ' . $report->patient->user->lastname : 'N/A' }}
            </span>
          </td>
          <td><span class="text-primary fw-bold">{{ $report->test?->name ?? 'N/A' }}</span></td>
          <td>{{ $report->test?->category->name ?? 'N/A' }}</td>
          <td>
            @php
              $statusClass = match($report->status) {
                'Pending' => 'warning',
                'Specimen Collected' => 'info',
                'Result Ready' => 'success',
                'Cancelled' => 'danger',
                default => 'secondary'
              };
            @endphp
            <span class="badge bg-label-{{ $statusClass }}">
              {{ $report->status }}
            </span>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center py-5">
            <div class="text-muted"><i class="ti ti-info-circle me-1"></i> No lab requests found.</div>
          </td>
        </tr>
        @endforelse
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="d-flex align-items-center justify-content-between px-3 mt-4">
        <small class="text-muted">Showing {{ $labReports->firstItem() ?? 0 }} to {{ $labReports->lastItem() ?? 0 }} of {{ $labReports->total() }}</small>
        {{ $labReports->links('vendor.pagination.vuexy-custom') }}
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('livewire:initialized', () => {
    flatpickr(".flatpickr", {
      dateFormat: "Y-m-d",
      allowInput: true
    });
  });
</script>
