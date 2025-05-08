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
      <table class="table table-sm table-striped">
        <thead>
        <tr>
          <th>Date</th>
          <th>Service</th>
          <th>Cash Point</th>
          <th>Payment Method</th>
          <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @php $total = 0; @endphp
        @forelse($revenue as $item)
        @php $total += $item->paying_amount; @endphp
        <tr>
          <td>{{ $item->created_at->format('d M Y h:i A') }}</td>
          <td>{{ $item->billing->service ?? '-' }}</td>
          <td>{{ strtoupper($item->cashPoint->name ?? '-') }}</td>
          <td>{{ ucfirst($item->payment_method ?? 'Cash') }}</td>
          <td>{{ number_format($item->paying_amount, 2) }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center">No records found.</td>
        </tr>
        @endforelse
        </tbody>

        @if($revenue->count())
        <tfoot>
        <tr>
          <th colspan="4" class="text-right">Total</th>
          <th>{{ number_format($total, 2) }}</th>
        </tr>
        </tfoot>
        @endif
      </table>

      <!-- Pagination -->
      <div class="d-flex justify-content-between align-items-center px-3 py-2">
        <div>
          Showing {{ $revenue->firstItem() }} to {{ $revenue->lastItem() }} of {{ $revenue->total() }} entries
        </div>
        <div>
          {{ $revenue->links('pagination::bootstrap-4') }}
        </div>
      </div>
    </div>
  </div>
</div>
