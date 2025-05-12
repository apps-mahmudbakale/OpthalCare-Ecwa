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
            @foreach($allCashiers as $c)
            <option value="{{ $c->id }}">{{ $c->firstname . ' ' . $c->lastname }}</option>
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
            <i class="fa fa-download"></i> Export
          </button>
        </div>
      </form>
    </div>

    <!-- Table Content -->
    <div class="table-responsive">
      <table class="table table-sm table-bordered">
        <thead class="thead-light">
        <tr>
          <th>Cashier</th>
          <th>Payment Method</th>
          <th>Total Amount (₦)</th>
        </tr>
        </thead>
        <tbody>
        @forelse($revenue as $cashierId => $methods)
        @php $user = $cashiers[$cashierId] ?? null; @endphp

        @if($user)
        @foreach($methods as $method)
        <tr>
          <td>{{ $user->firstname . ' ' . $user->lastname }}</td>
          <td>{{ ucfirst($method->payment_method ?? 'Cash') }}</td>
          <td>{{ number_format($method->total, 2) }}</td>
        </tr>
        @endforeach
        <tr class="bg-light font-weight-bold">
          <td colspan="2">Total for {{ $user->firstname }}</td>
          <td>{{ number_format($methods->sum('total'), 2) }}</td>
        </tr>
        @endif
        @empty
        <tr>
          <td colspan="3" class="text-center">No records found.</td>
        </tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
