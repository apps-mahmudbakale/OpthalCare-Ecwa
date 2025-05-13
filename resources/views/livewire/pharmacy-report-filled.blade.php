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
    <div class="table-responsive">
      <table class="table table-sm table-striped">
        <thead>
        <tr>
          <th>Patient Name</th>
          <th>Location</th>
          <th>Status</th>
          <th>Requested At</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($expired as $request)
        <tr>
          <td>{{ $request->patient->user->firstname.' '.$request->patient->user->lastname ?? 'N/A' }}</td>
          <td>{{ $request->store->name ?? 'N/A' }}</td>
          <td>{{ ucfirst($request->status) }}</td>
          <td>{{ $request->created_at->format('Y-m-d') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5">No filled drug requests found for the selected filters.</td>
        </tr>
        @endforelse
        </tbody>
      </table>

      <div class="d-flex justify-content-center">
        {{ $expired->links() }}
      </div>
    </div>
  </div>
</div>
