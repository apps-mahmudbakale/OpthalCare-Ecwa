<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
    <h3 class="mb-2">Add Service for {{ $hmoPlan->hmo->name ?? '' }} ({{ $hmoPlan->name ?? '' }})</h3>
    <p class="text-muted">Set a custom HMO price for a specific service category.</p>
</div>

<div class="row g-3">
    <!-- Add Service Form -->
    <div class="col-md-12">
        <div class="card bg-light border-0 shadow-none mb-4">
            <div class="card-body">
                <form id="add-service-form" action="{{ route('app.hmo-plans.services.store', $hmoPlan->id) }}" method="POST">
                    @csrf
                    <div class="row align-items-end g-3">
                        <div class="col-md-12 mb-2">
                            <label class="form-label" for="type">Category</label>
                            <select id="type" name="type" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label" for="service_id">Service</label>
                            <select name="service_id" id="service_id" class="form-select" required disabled>
                                <option value="" data-price="">Select Service</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label" for="price">HMO Price</label>
                            <div class="input-group">
                                <span class="input-group-text">&#8358;</span>
                                <input name="price" type="number" step="0.01" id="price" class="form-control" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4 text-center">
                            <button type="submit" class="btn btn-success">Save Service Price</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle Category Selection
        $('#type').on('change', function() {
            var categoryType = $(this).val();
            var serviceSelect = $('#service_id');
            var priceInput = $('#price');

            // Reset Sub-Service and Price
            serviceSelect.html('<option value="" data-price="">Loading...</option>');
            serviceSelect.prop('disabled', true);
            priceInput.val('');

            if (categoryType) {
                // Fetch services for the selected category via AJAX
                $.ajax({
                    url: "{{ route('bill.services') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        serviceCategory: categoryType
                    },
                    success: function(response) {
                        serviceSelect.empty();
                        serviceSelect.append('<option value="" data-price="">Select Service</option>');
                        
                        if(response && response.services && response.services.length > 0) {
                            $.each(response.services, function(index, service) {
                                serviceSelect.append('<option value="' + service.id + '" data-price="' + service.price + '">' + service.name + '</option>');
                            });
                            serviceSelect.prop('disabled', false);
                        } else {
                            serviceSelect.html('<option value="" data-price="">No services available</option>');
                        }
                    },
                    error: function() {
                        serviceSelect.html('<option value="" data-price="">Error loading services</option>');
                    }
                });
            } else {
                serviceSelect.html('<option value="" data-price="">Select Category First</option>');
            }
        });

        // Auto-fill price when a service is selected
        $('#service_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var basePrice = selectedOption.data('price');
            if (basePrice !== undefined && basePrice !== '') {
                $('#price').val(parseFloat(basePrice).toFixed(2));
            } else {
                $('#price').val('');
            }
        });

        // Handle Form Submission via AJAX to stay in Modal
        $('#add-service-form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var data = form.serialize();
            var submitBtn = form.find('button[type="submit"]');

            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');

            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response) {
                    if (response.success) {
                        // Show success alert temporarily inside modal
                        var alertHtml = '<div class="alert alert-success alert-dismissible" role="alert">' +
                            response.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        
                        form.closest('.card-body').prepend(alertHtml);
                        setTimeout(function(){
                            // Reload the *Add Service* modal or auto-close? The user might want to add another.
                            // We will simply clear the form
                            form[0].reset();
                            $('#service_id').html('<option value="" data-price="">Select Category First</option>').prop('disabled', true);
                            submitBtn.prop('disabled', false).html('Save Service Price');
                        }, 1500);
                        
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorMsg = xhr.responseJSON.message || 'Error processing request.';
                    var alertHtml = '<div class="alert alert-danger alert-dismissible" role="alert">' +
                            errorMsg +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    
                    form.closest('.card-body').prepend(alertHtml);
                    submitBtn.prop('disabled', false).html('Save Service Price');
                }
            });
        });
    });
</script>
