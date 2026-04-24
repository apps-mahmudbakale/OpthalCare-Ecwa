<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
    <h3 class="mb-2">Receive Payment</h3>
    <p class="text-muted">Select bill lines to pay together</p>
</div>

@php
$bills = \App\Models\Billing::where('bill_ref', $ref)->where('status', 0)->get();
$totalAmount = $bills->sum('amount');
@endphp

<!-- Bill Lines Selection -->
<div class="card mb-3">
    <div class="card-body">
        <h6 class="card-title mb-3">Unpaid Services ({{ $bills->count() }})</h6>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th width="40">
                            <input type="checkbox" id="selectAll" class="form-check-input">
                        </th>
                        <th>Service</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bills as $bill)
                    <tr>
                        <td>
                            <input type="checkbox" 
                                   class="form-check-input bill-checkbox" 
                                   data-bill-id="{{ $bill->id }}"
                                   data-amount="{{ $bill->amount }}"
                                   checked>
                        </td>
                        <td>{{ $bill->service }}</td>
                        <td class="text-end">₦{{ number_format($bill->amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-active">
                        <td colspan="2"><strong>Selected Total:</strong></td>
                        <td class="text-end"><strong id="selectedTotal">₦{{ number_format($totalAmount, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<form id="billingPaymentForm" action="{{route('app.payments.store')}}" method="POST">
    @csrf
    <input type="hidden" name="bill_ref" value="{{$ref}}">
    <input type="hidden" name="patient_id" value="{{$billing->user_id}}">
    <input type="hidden" name="selected_bills" id="selectedBillsInput" value="">
    
    <div class="form-group mb-3">
        <label for="fls0" class="form-label">Cash Point <span class="text-danger">*</span></label>
        <select name="location_id" class="form-select" id="fls0" required>
            <option value="">Choose...</option>
            @foreach(\App\Models\CashPoint::all() as $cashpoint)
              <option value="{{$cashpoint->id}}">{{$cashpoint->name}}</option>
            @endforeach
        </select>
    </div>
    
    <div class="form-group mb-3">
        <label for="fls1" class="form-label">Payment Method <span class="text-danger">*</span></label>
        <select name="payment_method_id" class="form-select" id="fls1" required>
            <option value="">Choose...</option>
            @foreach(\App\Models\PaymentMethod::all() as $method)
              <option value="{{$method->id}}">{{$method->name}}</option>
            @endforeach
        </select>
    </div>
    
    <div class="row">
        <div class="form-group col-md-6 mb-3">
            <label for="fls2" class="form-label">Paying Amount <span class="text-danger">*</span></label>
            <input value="{{ $totalAmount }}" 
                   name="amount" 
                   id="payingAmount"
                   required 
                   readonly
                   autocomplete="off" 
                   type="number" 
                   step="0.01"
                   class="form-control">
        </div>
        <div class="form-group col-md-6 mb-3">
            <label for="fls3" class="form-label">Reference</label>
            <input id="fls3" 
                   name="reference" 
                   autocomplete="off" 
                   type="text"
                   class="form-control">
        </div>
    </div>
    
    <div class="text-center">
        @if($billing->service == 'Consultation / Check-In Fee')
            <button type="submit" class="btn btn-primary me-2">
                <i class="ti ti-check me-1"></i> Submit & Generate Clearance Code
            </button>
        @else
            <button type="submit" class="btn btn-primary me-2">
                <i class="ti ti-check me-1"></i> Submit Payment
            </button>
        @endif
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
            <i class="ti ti-x me-1"></i> Cancel
        </button>
    </div>
</form>

<script>
$(document).ready(function() {
    // Calculate and update selected total
    function updateSelectedTotal() {
        let total = 0;
        let selectedBills = [];
        
        $('.bill-checkbox:checked').each(function() {
            total += parseFloat($(this).data('amount'));
            selectedBills.push($(this).data('bill-id'));
        });
        
        $('#selectedTotal').text('₦' + total.toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        $('#payingAmount').val(total.toFixed(2));
        $('#selectedBillsInput').val(selectedBills.join(','));
        
        // Disable submit if no bills selected
        if (selectedBills.length === 0) {
            $('#billingPaymentForm button[type="submit"]').prop('disabled', true);
        } else {
            $('#billingPaymentForm button[type="submit"]').prop('disabled', false);
        }
    }
    
    // Select/Deselect all
    $('#selectAll').on('change', function() {
        $('.bill-checkbox').prop('checked', $(this).is(':checked'));
        updateSelectedTotal();
    });
    
    // Individual checkbox change
    $('.bill-checkbox').on('change', function() {
        // Update "select all" checkbox state
        const totalCheckboxes = $('.bill-checkbox').length;
        const checkedCheckboxes = $('.bill-checkbox:checked').length;
        $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
        
        updateSelectedTotal();
    });
    
    // Initialize
    updateSelectedTotal();
});
</script>
