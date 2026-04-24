<div class="row">
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="misc_description" class="form-label">Description <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="misc_description" name="misc_description" 
                   placeholder="Enter service description" required>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="misc_unit_price" class="form-label">Unit Price <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="misc_unit_price" name="misc_unit_price" 
                   placeholder="0.00" step="0.01" min="0" required>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="misc_quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="misc_quantity" name="misc_quantity" 
                   value="1" min="1" required>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="misc_total" class="form-label">Total Amount</label>
            <input type="text" class="form-control" id="misc_total" name="misc_total" 
                   readonly value="0.00">
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Calculate total when unit price or quantity changes
    function calculateMiscTotal() {
        const unitPrice = parseFloat($('#misc_unit_price').val()) || 0;
        const quantity = parseInt($('#misc_quantity').val()) || 1;
        const total = unitPrice * quantity;
        $('#misc_total').val(total.toFixed(2));
    }
    
    $('#misc_unit_price, #misc_quantity').on('input change', calculateMiscTotal);
});
</script>
