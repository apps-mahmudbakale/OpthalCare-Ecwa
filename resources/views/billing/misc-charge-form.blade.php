<div class="card border-primary mb-3">
    <div class="card-header bg-primary text-white">
        <i class="ti ti-receipt me-1"></i> Miscellaneous Charge Details
    </div>
    <div class="card-body">
        <div class="form-group mb-3">
            <label for="misc-service-name" class="form-label">Service/Item Description <span class="text-danger">*</span></label>
            <input type="text" 
                   name="misc_service_name" 
                   id="misc-service-name" 
                   class="form-control" 
                   placeholder="e.g., Medical Report, Certificate, Special Service..."
                   required>
            <small class="text-muted">Enter a description for this charge</small>
        </div>
        
        <div class="form-group mb-3">
            <label for="misc-amount" class="form-label">Amount <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text">₦</span>
                <input type="number" 
                       name="misc_amount" 
                       id="misc-amount" 
                       class="form-control" 
                       placeholder="0.00"
                       step="0.01"
                       min="0"
                       required>
            </div>
            <small class="text-muted">Enter the charge amount</small>
        </div>
        
        <div class="alert alert-info mb-0">
            <i class="ti ti-info-circle me-1"></i>
            <strong>Note:</strong> This will create a custom billing item with the description and amount you specify.
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Update the form submission to include misc charge data
    const originalForm = $('#patient-search').closest('form');
    
    // Override form submission when misc charge is active
    originalForm.off('submit').on('submit', function(e) {
        if ($('#service-category').val() === 'miscellaneous') {
            e.preventDefault();
            
            const serviceName = $('#misc-service-name').val();
            const amount = $('#misc-amount').val();
            const patientId = $('#patient-id').val();
            
            if (!serviceName || !amount || !patientId) {
                alert('Please fill in all required fields including patient selection.');
                return false;
            }
            
            // Submit via AJAX
            $.ajax({
                url: '{{ route('app.billing.misc-charge-store') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    patient_id: patientId,
                    service_name: serviceName,
                    amount: amount
                },
                success: function(response) {
                    // Close modal and show success message
                    $('#global-modal').modal('hide');
                    
                    // Show success notification
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Miscellaneous charge added successfully!',
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        alert('Miscellaneous charge added successfully!');
                        location.reload();
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Failed to add miscellaneous charge.';
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message
                        });
                    } else {
                        alert(message);
                    }
                }
            });
            
            return false;
        }
    });
});
</script>
