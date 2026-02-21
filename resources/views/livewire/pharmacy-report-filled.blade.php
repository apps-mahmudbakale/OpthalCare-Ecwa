<div>
  <div class="card">
    <div class="card-header">
      <form class="d-flex flex-wrap gap-3">
        <!-- Location Filter -->
        <div class="form-group flex-fill ml-2">
          <label class="mb-0" for="store_id">Filter By Location</label>
          <select wire:model="store_id" id="store_id" class="custom-select form-control">
            <option value="">- All -</option>
            @foreach ($stores as $store)
            <option value="{{ $store->id }}">{{ $store->name }}</option>
            @endforeach
          </select>
        </div>

        <!-- Start Date Filter -->
        <div class="form-group flex-fill ml-2">
          <label class="mb-0" for="startDate">Start Date</label>
          <input type="date" id="startDate" wire:model="startDate" class="form-control">
        </div>

        <!-- End Date Filter -->
        <div class="form-group flex-fill ml-2">
          <label class="mb-0" for="endDate">End Date</label>
          <input type="date" id="endDate" wire:model="endDate" class="form-control">
        </div>

        <!-- Export Button -->
        <div class="form-group flex-fill- ml-3 no-label">
          <button class="btn btn-primary mt-4 px-3" type="button" wire:click="export">
            <i class="fa fa-download"></i> Export to File
          </button>
        </div>
      </form>
    </div>

    <!-- Table -->
    <div class="table-responsive text-nowrap">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Patient Name</th>
            <th>Drug Prescribed</th>
            <th class="text-center">Quantity</th>
            <th>Location</th>
            <th>Status</th>
            <th>Requested At</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($filled as $request)
          <tr>
            <td>
              <span class="fw-medium">
                {{ $request->patient && $request->patient->user ? $request->patient->user->firstname . ' ' . $request->patient->user->lastname : 'N/A' }}
              </span>
            </td>
            <td><span class="text-primary fw-bold">{{ $request->drug?->name ?? 'N/A' }}</span></td>
            <td class="text-center"><span class="badge bg-label-info">{{ $request->qty ?? 0 }}</span></td>
            <td>{{ $request->store?->name ?? 'N/A' }}</td>
            <td>
              <span class="badge bg-label-success">
                {{ ucfirst($request->status) }}
              </span>
            </td>
            <td>{{ $request->created_at->format('d M Y') }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5">
              <div class="text-muted"><i class="ti ti-info-circle me-1"></i> No filled drug requests found for the selected filters.</div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>

      <div class="d-flex align-items-center justify-content-between px-3 mt-4">
        <small class="text-muted">Showing {{ $filled->firstItem() ?? 0 }} to {{ $filled->lastItem() ?? 0 }} of {{ $filled->total() }}</small>
        {{ $filled->links('vendor.pagination.vuexy-custom') }}
      </div>
    </div>
  </div>
</div>
