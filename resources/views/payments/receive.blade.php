<div class="alert alert-warning">Outstanding
    Balance: ₦8,285.00</div>

<div class="form-group">
    <div class="form-label-group">
        <select name="location_id" class="custom-select" id="fls0" required="required">
            <option value=""> Choose...</option>

        </select>
        <label for="fls0">Cash Point</label>
    </div>
</div>
<div class="form-group">
    <div class="form-label-group">
        <select name="payment_method_id" class="custom-select" id="fls1" required="required">
            <option value=""> Choose...</option>
        </select>
        <label for="fls1">Payment Method</label>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <div class="form-label-group">
            <input value="8,285.00" id="fls2" name="amount" required="required" autocomplete="off" type="text"
                class="form-control form-control-lg -text-right" data-mask="currency" data-prefix="₦ "
                data-allow-decimal="true" data-decimal-limit="2">
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
