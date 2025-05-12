<div>
  <div class="card">
    <!-- Filter Header -->
    <div class="card-header">
      <form class="filterForm d-flex justify-content-between align-items-end flex-wrap">
        <!-- Cashier Filter -->
        <div class="form-group flex-fill ml-2">
          <label for="id_cashier" class="mb-0">Filter By Cashier</label>
          <select wire:model="cashier" id="id_cashier" class="custom-select form-control">
            <option value="">- All -</option>
            @foreach(\App\Models\User::all() as $cashier)
            <option value="{{ $cashier->id }}">{{ $cashier->firstname . ' ' . $cashier->lastname }}</option>
            @endforeach
          </select>
        </div>

        <!-- Cash Point Filter -->
        <div class="form-group flex-fill ml-2">
          <label for="id_cashpoint" class="mb-0">Filter By Cash Point</label>
          <select wire:model="cashpoint" id="id_cashpoint" class="custom-select form-control">
            <option value="">- All -</option>
            @foreach(\App\Models\Cashpoint::all() as $point)
            <option value="{{ $point->id }}">{{ strtoupper($point->name) }}</option>
            @endforeach
          </select>
        </div>

        <!-- Date Filter -->
        <div class="form-group flex-fill ml-2">
          <label for="Date" class="mb-0">Transaction Date</label>
          <input wire:model="Date" type="date" id="Date" class="form-control">
        </div>

        <!-- Export Button -->
        <div class="form-group flex-fill ml-2 d-flex align-items-end">
          <button wire:click="export" type="button" class="btn btn-primary px-3">
            <i class="fa fa-download"></i>
          </button>
        </div>
      </form>
    </div>

    <!-- Table Content -->
    <div class="table-responsive">
      <!-- Grouped Revenue Table -->
      <div class="table-responsive">
        <table class="table table-sm table-striped">
          <thead>
          <tr>
            <th>Cash Point</th>
            <th>Total Revenue (₦)</th>
          </tr>
          </thead>
          <tbody>
          @forelse($revenue as $row)
          <tr>
            <td>{{ strtoupper($row->cashPoint->name ?? 'N/A') }}</td>
            <td>{{ number_format($row->total_revenue, 2) }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="2" class="text-center">No records found.</td>
          </tr>
          @endforelse
          </tbody>
        </table>
      </div>
      <!-- Pagination -->

    </div>
  </div>
</div>
