<div>
  <div class="card">
    <!-- .card-header -->
    <div class="card-header">
      <form class="filterForm d-flex justify-content-between">
        <div class="form-group flex-fill ml-2-">
          <label class="mb-0" for="location_id">Filter By Location</label>
          <select id="location_id" wire:model="store_id" name="store_id" class="custom-select form-control filter">
            <option value="">- All -</option>
            @foreach(\App\Models\DrugStore::all() as $store)
            <option value="{{$store->id}}">{{$store->name}}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group flex-fill- ml-3 no-label">
          <button wire:click="export" class="btn btn-primary px-3" style="margin-top: 1.26rem" type="button">
          <i class="fa fa-download"></i> Export to File
          </button>
        </div>
      </form>
    </div><!-- /.card-header -->

    <!-- .table-responsive -->
    <div class="table-responsive">
      <!-- .table -->
      <table class="table table-sm- table-striped">
        <thead>
        <tr>
          <th>Drug/Generic</th>
          <th class="text-right">Quantity</th>
          <th>Date Expired</th>
          <th>Location</th>
        </tr>
        </thead>
        <tbody>
        @forelse($expired as $drug)
        <tr>
          <td class="align-middle">{{$drug->name}}</td>
          <td class="text-right">{{$drug->quantity}}</td>
          <td class="align-middle">{{ \Carbon\Carbon::parse($drug->expiry_date)->format('d M Y') }}</td>
          <td class="align-middle">{{$drug->store?->name ?? 'N/A'}}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center">No expired drugs found.</td>
        </tr>
        @endforelse
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="d-flex align-items-center justify-content-between px-3 mt-4">
        <small class="text-muted">Showing {{ $expired->firstItem() ?? 0 }} to {{ $expired->lastItem() ?? 0 }} of {{ $expired->total() }}</small>
        {{ $expired->links('vendor.pagination.vuexy-custom') }}
      </div>
    </div>
  </div>
</div>
