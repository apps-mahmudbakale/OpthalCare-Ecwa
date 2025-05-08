<div>
  <div class="card">
    <!-- Filter Header -->
    <div class="card-header">
      <form class="filterForm d-flex justify-content-between align-items-end flex-wrap">
        <!-- Service Filter -->
        <div class="form-group flex-fill ml-2">
          <label for="id_service" class="mb-0">Filter By Service</label>
          <select wire:model="service" id="id_service" class="custom-select form-control">
            <option value="">- All -</option>
            <option value="admissions">Admission</option>
            <option value="ophthicals">Ophthicals</option>
            <option value="consultations">Consultation</option>
            <option value="laboratory">Laboratory</option>
            <option value="procedure">Medical Procedure</option>
            <option value="pharmacy">Pharmacy</option>
            <option value="radiology">Radiology</option>
          </select>
        </div>

        <!-- Cash Point Filter -->
        <div class="form-group flex-fill ml-2">
          <label for="id_cashpoint" class="mb-0">Filter By Cash Point</label>
          <select wire:model="cashpoint" id="id_cashpoint" class="custom-select form-control">
            <option value="">- All -</option>
            @foreach($cashPoints as $point)
            <option value="{{ $point->id }}">{{ strtoupper($point->name) }}</option>
            @endforeach
          </select>
        </div>

        <!-- Payment Method Filter -->
        <div class="form-group flex-fill ml-2">
          <label for="payment_method" class="mb-0">Filter By Payment Method</label>
          <select wire:model="method" id="payment_method" class="form-control">
            <option value="">- All -</option>
            <option value="cash">Cash</option>
            <option value="pos">POS</option>
            <option value="transfer">Transfer</option>
            <!-- Add more as needed -->
          </select>
        </div>

        <!-- Date Filter -->
        <div class="form-group flex-fill ml-2">
          <label for="endDate" class="mb-0">Transaction Date</label>
          <input wire:model="Date" type="date" id="endDate" class="form-control">
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
        @forelse($revenue as $item)
        <tr>
          <td>{{ $item->created_at->format('d M Y h:i A') }}</td>
          <td>{{ $item->billing->service ?? '' }}</td>
          <td>{{ $item->cashPoint->name }}</td>
          <td>{{ $item->payment_method ?? 'Cash' }}</td>
          <td>{{ number_format($item->paying_amount, 2) }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center">No records found.</td>
        </tr>
        @endforelse
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="d-flex justify-content-between align-items-center px-3 py-2">
        <div>
          Showing {{ $revenue->firstItem() }} to {{ $revenue->lastItem() }} of {{ $revenue->total() }} entries
        </div>
        <div>
          {{ $revenue->links('vendor.pagination.vuexy-custom') }}
        </div>
      </div>
    </div>
  </div>
</div>
