<h2 class="text-center">Fund {{$patient->user->firstname." ".$patient->user->lastname}}'s Wallet</h2>
<div class="alert alert-success">Available
  Balance: ₦ {{$patient->wallet ? $patient->wallet->balance : 0;}}</div>
<form action="{{route('app.patient.fund.wallet.save')}}" method="post">
  @csrf
  <input type="hidden" name="patient_id" value="{{$patient->id}}">
  <div class="form-group">
    <div class="form-label-group">
      <select name="transaction_type" class="custom-select" id="fls0" required="required">
        <option value=""> Choose...</option>
        <option value="cash">Cash</option>
        <option value="pos">POS</option>
        <option value="transfer">Bank Transfer</option>
        <option value="card">Card</option>
      </select>
      <label for="fls0">Channel</label>
    </div>
  </div>
  <div class="form-group">
    <div class="form-label-group">
      <input value="" id="fls2" name="amount" required="required" autocomplete="off" type="text"
             class="form-control form-control-lg -text-right" data-mask="currency" data-prefix="₦ "
             data-allow-decimal="true" data-decimal-limit="2">
      <label for="fls2">Funding Amount</label>
    </div>
  </div>
  <div class="form-group">
    <div class="form-label-group">
      <input id="fls3" name="reference" autocomplete="off" type="text"
             class="form-control form-control-lg -text-right">
      <label for="fls3">Reference</label>
    </div>
  </div>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
  </div>
</form>

