<div>
<div>
  <div class="card-header d-flex justify-content-between align-items-center">
    <div>
      <button class="btn btn-success mb-2 new-bill-btn"
              data-request-url="{{ route('app.new.bill') }}"
              data-toggle="modal" data-target="#global-modal">
        New Bill
      </button>
    </div>
    <div>
      <a href="{{ route('app.payments.search-enrollment') }}" class="btn btn-outline-primary mb-2">
        <i class="ti ti-printer me-1"></i> Reprint Enrollment
      </a>
    </div>
  </div>

  <!-- Search and Filter Section -->
  <div class="card-body">
    <form method="GET" action="{{ url()->current() }}">
      <div class="row g-3 mb-3">
        <!-- Search -->
        <div class="col-md-3">
          <label class="form-label">Search</label>
          <input type="text" class="form-control" name="search" 
                 value="{{ request('search') }}"
                 placeholder="Patient name, service, bill ref...">
        </div>

        <!-- Status Filter -->
        <div class="col-md-2">
          <label class="form-label">Status</label>
          <select class="form-select" name="status">
            <option value="all" {{ request('status', 'unpaid') == 'all' ? 'selected' : '' }}>All</option>
            <option value="paid" {{ request('status', 'unpaid') == 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="unpaid" {{ request('status', 'unpaid') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
          </select>
        </div>

        <!-- Payer Filter -->
        <div class="col-md-2">
          <label class="form-label">Payer</label>
          <select class="form-select" name="payer">
            <option value="all" {{ request('payer', 'all') == 'all' ? 'selected' : '' }}>All</option>
            <option value="self" {{ request('payer', 'all') == 'self' ? 'selected' : '' }}>Self Pay</option>
            <option value="hmo" {{ request('payer', 'all') == 'hmo' ? 'selected' : '' }}>HMO</option>
          </select>
        </div>

        <!-- Date From -->
        <div class="col-md-2">
          <label class="form-label">Date From</label>
          <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
        </div>

        <!-- Date To -->
        <div class="col-md-2">
          <label class="form-label">Date To</label>
          <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
        </div>

        <!-- Action Buttons -->
        <div class="col-md-1">
          <label class="form-label">&nbsp;</label>
          <div class="d-flex gap-1">
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-search"></i>
            </button>
            <a href="{{ url()->current() }}" class="btn btn-outline-secondary">
              <i class="fa fa-times"></i>
            </a>
          </div>
        </div>
      </div>
    </form>

    <!-- Summary Cards -->
    <div class="row mb-3">
      <div class="col-md-4">
        <div class="alert alert-info mb-0">
          <strong>Total:</strong> ₦{{ number_format($totalAmount, 2) }}
        </div>
      </div>
      <div class="col-md-4">
        <div class="alert alert-success mb-0">
          <strong>Paid:</strong> ₦{{ number_format($paidAmount, 2) }}
        </div>
      </div>
      <div class="col-md-4">
        <div class="alert alert-warning mb-0">
          <strong>Unpaid:</strong> ₦{{ number_format($unpaidAmount, 2) }}
        </div>
      </div>
    </div>

    <!-- Results Info -->
    <div class="d-flex justify-content-between align-items-center mb-2">
      <div>
        <span class="text-muted">Showing {{ $billings->firstItem() ?? 0 }} to {{ $billings->lastItem() ?? 0 }} of {{ $billings->total() }} results</span>
      </div>
      <div>
        <form method="GET" action="{{ url()->current() }}" class="d-inline">
          @foreach(request()->except('per_page') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
          @endforeach
          <select class="form-select form-select-sm" name="per_page" onchange="this.form.submit()" style="width: auto;">
            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 per page</option>
            <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25 per page</option>
            <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50 per page</option>
            <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100 per page</option>
          </select>
        </form>
      </div>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
      <tr>
        <th width="50" class="text-center">
          <div class="form-check d-flex justify-content-center">
            <input type="checkbox" id="selectAllBills" class="form-check-input" title="Select all unpaid bills" style="cursor: pointer;">
          </div>
        </th>
        <th>Patient</th>
        <th>Primary Insurance Plan</th>
        <th>Service</th>
        <th class="text-end">Outstanding Amount</th>
        <th class="text-center">Status</th>
        <th class="text-center">Actions</th>
      </tr>
      </thead>
      <tbody>
      @forelse ($billings as $billRef => $group)
      @php
      $first = $group->first();
      $patient = $first->patient;
      $user = $patient->user ?? null;
      $service = $first->service;
      $fullName = collect([$user->firstname ?? '', $user->middlename ?? '', $user->lastname ?? ''])
      ->filter()
      ->implode(' ');
      $hospitalNo = sprintf('%06d', $patient->hospital_no ?? 0);
      $insurancePlan = $first->hmoPlan ? ($first->hmoPlan->hmo->name . ' - ' . $first->hmoPlan->name) : 'Patient Self Pay';
      $formattedAmount = number_format($group->sum('amount'));
      @endphp
      
      @foreach($group as $billing)
      <tr class="billing-row" data-bill-ref="{{ $billing->bill_ref }}">
        <td class="text-center align-middle">
          @if($billing->status == 0)
            <div class="form-check d-flex justify-content-center">
              <input type="checkbox" 
                     class="form-check-input bill-select-checkbox" 
                     data-bill-id="{{ $billing->id }}"
                     data-bill-ref="{{ $billing->bill_ref }}"
                     data-patient-id="{{ $billing->user_id }}"
                     data-amount="{{ $billing->amount }}"
                     style="cursor: pointer;">
            </div>
          @else
            <span class="text-muted">—</span>
          @endif
        </td>
        <td class="align-middle">
          <a href="#" class="text-decoration-none">
            <strong>{{ $fullName }}</strong><br>
            <small class="text-muted">[HRN{{ $hospitalNo }}]</small>
          </a>
        </td>
        <td class="align-middle">
          <small>{{ $insurancePlan }}</small>
        </td>
        <td class="align-middle">{{ $billing->service }}</td>
        <td class="text-end align-middle">₦{{ number_format($billing->amount, 2) }}</td>
        <td class="text-center align-middle">
          @if($billing->status == 1)
            <span class="badge bg-success">Paid</span>
          @else
            <span class="badge bg-warning">Unpaid</span>
          @endif
        </td>
        <td class="text-center align-middle">
          <div class="dropdown">
            <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                    data-bs-toggle="dropdown" aria-expanded="false">
              <i class="ti ti-dots-vertical"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              @if($billing->status == 1)
              <li>
                <a class="dropdown-item" href="{{ route('app.payments.reprint', $billing->bill_ref) }}" target="_blank">
                  <i class="ti ti-printer me-2"></i> Reprint Receipt
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              @else
              <li>
                <button class="dropdown-item billing-show-btn"
                        data-request-url="{{ route('app.billing.show', $billing->bill_ref) }}">
                  <i class="ti ti-cash me-2"></i> Receive Payment
                </button>
              </li>
              <li><hr class="dropdown-divider"></li>
              @endif
              <li>
                <button class="dropdown-item text-danger cancel-charge-btn"
                        data-billing-id="{{ $billing->id }}"
                        data-service="{{ $billing->service }}">
                  <i class="ti ti-trash me-2"></i> Cancel This Charge
                </button>
              </li>
            </ul>
          </div>
        </td>
      </tr>
      @endforeach
      @empty
      <tr>
        <td colspan="7" class="text-center py-5">
          <i class="ti ti-file-invoice ti-lg text-muted mb-3 d-block" style="font-size: 3rem;"></i>
          <p class="text-muted mb-0">No billing records found</p>
        </td>
      </tr>
      @endforelse
      </tbody>
    </table>

    <!-- Pay Selected Button - Sticky Footer -->
    <div id="paySelectedContainer" class="d-none">
      <div class="card border-primary shadow-sm" style="position: sticky; bottom: 20px; z-index: 1000;">
        <div class="card-body py-3">
          <div class="row align-items-center">
            <div class="col-md-8">
              <div class="d-flex align-items-center">
                <i class="ti ti-checkbox ti-md text-primary me-3"></i>
                <div>
                  <h6 class="mb-0">
                    <span id="selectedCount" class="text-primary fw-bold">0</span> bill(s) selected
                  </h6>
                  <small class="text-muted">
                    Total Amount: <strong id="selectedTotalAmount" class="text-dark">₦0.00</strong>
                  </small>
                </div>
              </div>
            </div>
            <div class="col-md-4 text-end">
              <button type="button" class="btn btn-primary waves-effect waves-light" id="paySelectedBtn">
                <i class="ti ti-cash me-1"></i> Pay Selected Bills
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <hr class="my-3">
    <div class="d-flex justify-content-center">
      {{ $billings->appends(request()->except('page'))->links() }}
    </div>
  </div>
</div>

@include('_partials._modals.global-modal')

<script>
$(document).ready(function() {
    // Update selected bills display
    function updateSelectedBills() {
        const selectedCheckboxes = $('.bill-select-checkbox:checked');
        const count = selectedCheckboxes.length;
        let total = 0;
        
        selectedCheckboxes.each(function() {
            total += parseFloat($(this).data('amount'));
        });
        
        $('#selectedCount').text(count);
        $('#selectedTotalAmount').text('₦' + total.toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        
        if (count > 0) {
            $('#paySelectedContainer').removeClass('d-none');
        } else {
            $('#paySelectedContainer').addClass('d-none');
        }
    }
    
    // Select all checkbox
    $('#selectAllBills').on('change', function() {
        $('.bill-select-checkbox').prop('checked', $(this).is(':checked'));
        updateSelectedBills();
    });
    
    // Individual checkbox change
    $(document).on('change', '.bill-select-checkbox', function() {
        const totalCheckboxes = $('.bill-select-checkbox').length;
        const checkedCheckboxes = $('.bill-select-checkbox:checked').length;
        $('#selectAllBills').prop('checked', totalCheckboxes === checkedCheckboxes);
        updateSelectedBills();
    });
    
    // Pay selected bills button
    $('#paySelectedBtn').on('click', function() {
        const selectedCheckboxes = $('.bill-select-checkbox:checked');
        
        if (selectedCheckboxes.length === 0) {
            alert('Please select at least one bill to pay');
            return;
        }
        
        // Get selected bill IDs and details
        const selectedBills = [];
        let patientId = null;
        let billRef = null;
        
        selectedCheckboxes.each(function() {
            selectedBills.push($(this).data('bill-id'));
            if (!patientId) patientId = $(this).data('patient-id');
            if (!billRef) billRef = $(this).data('bill-ref');
        });
        
        // Check if all selected bills are from the same patient
        let samePatient = true;
        selectedCheckboxes.each(function() {
            if ($(this).data('patient-id') != patientId) {
                samePatient = false;
            }
        });
        
        if (!samePatient) {
            alert('Please select bills from the same patient only');
            return;
        }
        
        // Store selected bills in sessionStorage
        sessionStorage.setItem('selectedBills', selectedBills.join(','));
        
        // Open payment modal
        const url = '{{ url("app/billing") }}/' + billRef;
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#global-modal .modal-body').html(response);
                $('#global-modal').modal('show');
                
                // Set the selected bills in the hidden input
                setTimeout(function() {
                    $('#selectedBillsInput').val(selectedBills.join(','));
                    
                    // Calculate and set the amount
                    let total = 0;
                    selectedCheckboxes.each(function() {
                        total += parseFloat($(this).data('amount'));
                    });
                    $('#payingAmount').val(total.toFixed(2));
                }, 100);
            },
            error: function(xhr, status, error) {
                console.error('Error loading payment form:', error);
                alert('Failed to load payment form');
            }
        });
    });
});
</script>
