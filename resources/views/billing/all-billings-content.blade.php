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
        <span class="text-muted">Showing {{ $paginated->firstItem() ?? 0 }} to {{ $paginated->lastItem() ?? 0 }} of {{ $paginated->total() }} results</span>
      </div>
      <div>
        <form method="GET" action="{{ url()->current() }}" class="d-inline">
          @foreach(request()->except('per_page') as $key => $value)
            @if(!is_array($value))
              <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
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
    <!-- Bulk Actions Bar (hidden by default) -->
    <div id="bulkActionsBar" class="alert alert-primary d-none mb-3" role="alert">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <i class="ti ti-checkbox me-1"></i>
          <strong><span id="selectedCount">0</span> item(s) selected</strong>
          <span class="ms-2">Total: <strong id="selectedTotal">₦0.00</strong></span>
        </div>
        <div>
          <button type="button" class="btn btn-sm btn-success me-2" id="bulkPayBtn">
            <i class="ti ti-cash me-1"></i> Pay Selected
          </button>
          <button type="button" class="btn btn-sm btn-outline-danger" id="bulkCancelBtn">
            <i class="ti ti-trash me-1"></i> Cancel Selected
          </button>
          <button type="button" class="btn btn-sm btn-outline-secondary ms-2" id="clearSelectionBtn">
            <i class="ti ti-x me-1"></i> Clear
          </button>
        </div>
      </div>
    </div>

    <table class="table table-hover">
      <thead>
      <tr>
        <th width="30" class="text-center">
          <div class="form-check d-flex justify-content-center align-items-center m-0">
            <input type="checkbox" id="selectAllBills" class="form-check-input m-0">
          </div>
        </th>
        <th>Patient</th>
        <th>Primary Insurance Plan</th>
        <th>Service</th>
        <th class="text-end">Outstanding Amount</th>
        <th class="text-center">Status</th>
        <th class="text-center" width="60">Actions</th>
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
      <tr data-billing-id="{{ $billing->id }}" 
          data-bill-ref="{{ $billing->bill_ref }}"
          data-patient-id="{{ $billing->user_id }}"
          data-status="{{ $billing->status }}">
        <td class="text-center align-middle">
          @if($billing->status == 0)
          <div class="form-check d-flex justify-content-center align-items-center m-0">
            <input type="checkbox" 
                   class="form-check-input bill-line-checkbox m-0" 
                   data-billing-id="{{ $billing->id }}"
                   data-amount="{{ $billing->amount }}"
                   data-bill-ref="{{ $billing->bill_ref }}"
                   data-patient-id="{{ $billing->user_id }}">
          </div>
          @else
          <div class="text-center">
            <i class="ti ti-lock text-muted" title="Paid - Cannot select"></i>
          </div>
          @endif
        </td>
        <td class="align-middle">
          <a href="#" class="text-decoration-none">
            <strong>{{ $fullName }}</strong>
            <br>
            <small class="text-muted">[HRN{{ $hospitalNo }}]</small>
          </a>
        </td>
        <td class="align-middle">
          <small>{{ $insurancePlan }}</small>
        </td>
        <td class="align-middle">{{ $billing->service }}</td>
        <td class="text-end align-middle">
          <strong>₦{{ number_format($billing->amount, 2) }}</strong>
        </td>
        <td class="text-center align-middle">
          @if($billing->status == 1)
            <span class="badge bg-label-success">Paid</span>
          @else
            <span class="badge bg-label-warning">Unpaid</span>
          @endif
        </td>
        <td class="align-middle text-center">
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
        <td colspan="7" class="text-center py-4">
          <i class="ti ti-inbox ti-lg text-muted mb-3 d-block"></i>
          <p class="text-muted mb-0">No billing records found</p>
        </td>
      </tr>
      @endforelse
      </tbody>
    </table>

    <hr class="my-2">
    <div class="d-flex justify-content-center">
      {{ $paginated->appends(request()->except('page'))->links() }}
    </div>
  </div>
</div>

@include('_partials._modals.global-modal')

<style>
/* Improve checkbox alignment and styling */
.form-check-input {
    cursor: pointer;
    width: 1.25rem;
    height: 1.25rem;
}

.form-check-input:hover {
    border-color: #696cff;
}

.table > :not(caption) > * > * {
    vertical-align: middle;
}

/* Ensure consistent row height */
.table tbody tr {
    height: 60px;
}

/* Hover effect for selectable rows */
.table tbody tr[data-status="0"]:hover {
    background-color: rgba(105, 108, 255, 0.04);
}

/* Style for locked (paid) rows */
.table tbody tr[data-status="1"] {
    background-color: rgba(40, 199, 111, 0.04);
}
</style>

<script>
$(document).ready(function() {
    // Track selected bills
    let selectedBills = [];

    // Update selection UI
    function updateSelectionUI() {
        const count = selectedBills.length;
        const total = selectedBills.reduce((sum, bill) => sum + parseFloat(bill.amount), 0);

        $('#selectedCount').text(count);
        $('#selectedTotal').text('₦' + total.toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2}));

        if (count > 0) {
            $('#bulkActionsBar').removeClass('d-none');
        } else {
            $('#bulkActionsBar').addClass('d-none');
        }

        // Update "select all" checkbox state
        const totalCheckboxes = $('.bill-line-checkbox').length;
        const checkedCheckboxes = $('.bill-line-checkbox:checked').length;
        $('#selectAllBills').prop('checked', totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes);
    }

    // Select/Deselect all
    $('#selectAllBills').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('.bill-line-checkbox').prop('checked', isChecked);
        
        selectedBills = [];
        if (isChecked) {
            $('.bill-line-checkbox').each(function() {
                selectedBills.push({
                    id: $(this).data('billing-id'),
                    amount: $(this).data('amount'),
                    billRef: $(this).data('bill-ref'),
                    patientId: $(this).data('patient-id')
                });
            });
        }
        updateSelectionUI();
    });

    // Individual checkbox change
    $(document).on('change', '.bill-line-checkbox', function() {
        const billingId = $(this).data('billing-id');
        const amount = $(this).data('amount');
        const billRef = $(this).data('bill-ref');
        const patientId = $(this).data('patient-id');

        if ($(this).is(':checked')) {
            selectedBills.push({ id: billingId, amount: amount, billRef: billRef, patientId: patientId });
        } else {
            selectedBills = selectedBills.filter(bill => bill.id !== billingId);
        }

        updateSelectionUI();
    });

    // Clear selection
    $('#clearSelectionBtn').on('click', function() {
        $('.bill-line-checkbox').prop('checked', false);
        $('#selectAllBills').prop('checked', false);
        selectedBills = [];
        updateSelectionUI();
    });

    // Bulk pay selected bills
    $('#bulkPayBtn').on('click', function() {
        if (selectedBills.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one bill to pay.'
            });
            return;
        }

        // Check if all selected bills belong to the same patient
        const uniquePatients = [...new Set(selectedBills.map(bill => bill.patientId))];
        if (uniquePatients.length > 1) {
            Swal.fire({
                icon: 'error',
                title: 'Multiple Patients',
                text: 'Please select bills from the same patient only.'
            });
            return;
        }

        // Get unique bill references
        const uniqueRefs = [...new Set(selectedBills.map(bill => bill.billRef))];
        const patientId = selectedBills[0].patientId;
        const totalAmount = selectedBills.reduce((sum, bill) => sum + parseFloat(bill.amount), 0);
        const billIds = selectedBills.map(bill => bill.id).join(',');

        // Show payment form for multiple bills
        showBulkPaymentForm(patientId, billIds, totalAmount, selectedBills);
    });

    function showBulkPaymentForm(patientId, billIds, totalAmount, bills) {
        // Build the payment form HTML
        const formHtml = `
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="text-center mb-4">
                <h3 class="mb-2">Receive Payment</h3>
                <p class="text-muted">Pay selected bills together</p>
            </div>

            <!-- Selected Bills Summary -->
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-3">Selected Services (${bills.length})</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${bills.map(bill => {
                                    const row = $('tr[data-billing-id="' + bill.id + '"]');
                                    const service = row.find('td:eq(3)').text();
                                    return `
                                        <tr>
                                            <td>${service}</td>
                                            <td class="text-end">₦${parseFloat(bill.amount).toLocaleString('en-NG', {minimumFractionDigits: 2})}</td>
                                        </tr>
                                    `;
                                }).join('')}
                            </tbody>
                            <tfoot>
                                <tr class="table-active">
                                    <td><strong>Total:</strong></td>
                                    <td class="text-end"><strong>₦${totalAmount.toLocaleString('en-NG', {minimumFractionDigits: 2})}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <form id="bulkPaymentForm">
                <input type="hidden" name="patient_id" value="${patientId}">
                <input type="hidden" name="selected_bill_ids" value="${billIds}">
                <input type="hidden" name="total_amount" value="${totalAmount}">
                
                <div class="form-group mb-3">
                    <label for="bulk_cashpoint" class="form-label">Cash Point <span class="text-danger">*</span></label>
                    <select name="location_id" class="form-select" id="bulk_cashpoint" required>
                        <option value="">Choose...</option>
                        @foreach(\App\Models\CashPoint::all() as $cashpoint)
                          <option value="{{$cashpoint->id}}">{{$cashpoint->name}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label for="bulk_payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                    <select name="payment_method_id" class="form-select" id="bulk_payment_method" required>
                        <option value="">Choose...</option>
                        @foreach(\App\Models\PaymentMethod::all() as $method)
                          <option value="{{$method->id}}">{{$method->name}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="bulk_amount" class="form-label">Paying Amount <span class="text-danger">*</span></label>
                        <input value="${totalAmount.toFixed(2)}" 
                               name="amount" 
                               id="bulk_amount"
                               required 
                               readonly
                               type="number" 
                               step="0.01"
                               class="form-control">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="bulk_reference" class="form-label">Reference</label>
                        <input id="bulk_reference" 
                               name="reference" 
                               type="text"
                               class="form-control">
                    </div>
                </div>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="ti ti-check me-1"></i> Submit Payment
                    </button>
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i> Cancel
                    </button>
                </div>
            </form>
        `;

        // Show the form in modal
        $('#global-modal .modal-body').html(formHtml);
        $('#global-modal').modal('show');

        // Handle form submission
        $('#bulkPaymentForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                _token: '{{ csrf_token() }}',
                patient_id: patientId,
                selected_bill_ids: billIds,
                payment_method_id: $('#bulk_payment_method').val(),
                location_id: $('#bulk_cashpoint').val(),
                amount: totalAmount,
                reference: $('#bulk_reference').val()
            };

            // Disable submit button
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<span class="spinner-border spinner-border-sm me-1"></span> Processing...').prop('disabled', true);

            $.ajax({
                url: '{{ route('app.payments.bulk-store') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#global-modal').modal('hide');
                    
                    // Open receipt in new window
                    if (response.receipt_url) {
                        window.open(response.receipt_url, '_blank');
                    }
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Payment processed successfully!',
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    submitBtn.html(originalText).prop('disabled', false);
                    const message = xhr.responseJSON?.message || 'Payment processing failed.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message
                    });
                }
            });
        });
    }

    // Bulk cancel selected bills
    $('#bulkCancelBtn').on('click', function() {
        if (selectedBills.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one bill to cancel.'
            });
            return;
        }

        Swal.fire({
            title: 'Confirm Cancellation',
            text: `Are you sure you want to cancel ${selectedBills.length} selected charge(s)?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, cancel them!',
            cancelButtonText: 'No, keep them'
        }).then((result) => {
            if (result.isConfirmed) {
                // Cancel each selected bill
                let completed = 0;
                let failed = 0;

                selectedBills.forEach(function(bill) {
                    $.ajax({
                        url: '{{ route('app.billing.cancel-line', ':id') }}'.replace(':id', bill.id),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            completed++;
                            if (completed + failed === selectedBills.length) {
                                finishBulkCancel(completed, failed);
                            }
                        },
                        error: function(xhr) {
                            failed++;
                            if (completed + failed === selectedBills.length) {
                                finishBulkCancel(completed, failed);
                            }
                        }
                    });
                });
            }
        });
    });

    function finishBulkCancel(completed, failed) {
        if (failed === 0) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: `Successfully cancelled ${completed} charge(s).`,
                timer: 2000
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Partial Success',
                text: `Cancelled ${completed} charge(s). Failed to cancel ${failed} charge(s).`
            }).then(() => {
                location.reload();
            });
        }
    }

    // Handle single charge cancellation
    $(document).on('click', '.cancel-charge-btn', function(e) {
        e.preventDefault();
        const billingId = $(this).data('billing-id');
        const service = $(this).data('service');

        Swal.fire({
            title: 'Confirm Cancellation',
            text: `Are you sure you want to cancel this charge: ${service}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('app.billing.cancel-line', ':id') }}'.replace(':id', billingId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Cancelled!',
                            text: 'The charge has been cancelled.',
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        const message = xhr.responseJSON?.message || 'Failed to cancel the charge.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message
                        });
                    }
                });
            }
        });
    });
});
</script>
