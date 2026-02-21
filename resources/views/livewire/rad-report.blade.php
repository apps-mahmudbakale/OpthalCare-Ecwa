<div>
  <div class="card">
    <!-- .card-header -->
    <div class="card-header">
      <form class="filterForm d-flex justify-content-between">
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
          <select wire:model="status" id="id_status" name="status" class="custom-select form-control filter">
            <option value="">- All -</option>
            <option>Pending</option>
            <option>Result Ready</option>
            <option>Cancelled</option>

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
        <div class="form-group flex-fill- ml-3 no-label">
          <button wire:click="export" class="btn btn-primary  px-3" style="margin-top: 1.26rem" type="button" id="export-btn">
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
        @forelse($radReports as $report)
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
            <div class="text-muted"><i class="ti ti-info-circle me-1"></i> No radiology requests found.</div>
          </td>
        </tr>
        @endforelse
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="d-flex align-items-center justify-content-between px-3 mt-4">
        <small class="text-muted">Showing {{ $radReports->firstItem() ?? 0 }} to {{ $radReports->lastItem() ?? 0 }} of {{ $radReports->total() }}</small>
        {{ $radReports->links('vendor.pagination.vuexy-custom') }}
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
