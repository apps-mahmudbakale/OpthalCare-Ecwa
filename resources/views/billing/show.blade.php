<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
    <h3 class="mb-2">Receive Payment</h3>
</div>
<form action="{{route('app.payments.store')}}" method="POST">
    @csrf
    <div class="form-group">
      <input type="hidden" name="billing_id" value="{{$billing->id}}">
      <input type="hidden" name="patient_id" value="{{$billing->user_id}}">
        <div class="form-label-group">
            <select name="location_id" class="custom-select" id="fls0" required="required">
                <option value=""> Choose...</option>
                @foreach(\App\Models\CashPoint::all() as $cashpoint)
                  <option value="{{$cashpoint->id}}">{{$cashpoint->name}}</option>
                @endforeach
            </select>
            <label for="fls0">Cash Point</label>
        </div>
    </div>
    <div class="form-group">
        <div class="form-label-group">
            <select name="payment_method_id" class="custom-select" id="fls1" required="required">
                <option value=""> Choose...</option>
                  @foreach(\App\Models\PaymentMethod::all() as $method)
                  <option value="{{$method->id}}">{{$method->name}}</option>
                  @endforeach
            </select>
            <label for="fls1">Payment Method</label>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <div class="form-label-group">
                <input value="{{ $billing->amount }}" name="amount" required="required"
                    autocomplete="off" type="text" class="form-control form-control-lg -text-right"
                  >
                <label for="fls2">Paying Amount</label>
            </div>

        </div>
        <div class="form-group col-md-6">
            <div class="form-label-group">
                <input id="fls3" name="reference" autocomplete="off" type="text"
                    class="form-control form-control-lg -text-right">
                <label for="fls3">Reference</label>
            </div>
        </div>
    </div>
    <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
    </div>
</form>
