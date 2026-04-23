<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
    <h3 class="mb-2">Receive Payment</h3>
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
            <input value="{{ $amount }}" 
                   name="amount" 
                   id="payingAmount"
                   required 
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
