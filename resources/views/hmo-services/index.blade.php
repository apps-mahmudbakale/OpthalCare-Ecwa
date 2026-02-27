<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
    <h3 class="mb-2">Manage Services for {{ $hmoPlan->hmo->name ?? '' }} ({{ $hmoPlan->name ?? '' }})</h3>
    <p class="text-muted">Add or remove services and set custom pricing for this HMO plan.</p>
</div>

<div class="row g-3">
    <!-- Services Table -->
    <div class="col-md-12">
        <div id="service-alert-container"></div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Service Name</th>
                        <th>Base Price</th>
                        <th>HMO Price</th>
                        <th>Diff</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($assignedServices as $hmoService)
                        <tr>
                            <td>
                                <strong>{{ $hmoService->service_name }}</strong>
                                <br><small class="text-muted">{{ ucfirst($hmoService->type) }}</small>
                            </td>
                            <td>&#8358;{{ number_format($hmoService->service_base_price, 2) }}</td>
                            <td>
                                <form class="edit-service-form d-flex align-items-center" action="{{ route('app.hmo-services.update', $hmoService->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" step="0.01" name="price" value="{{ $hmoService->price }}" class="form-control form-control-sm w-px-100 me-2" required>
                                    <button type="submit" class="btn btn-sm btn-icon btn-label-primary waves-effect"><i class="ti ti-check"></i></button>
                                </form>
                            </td>
                            <td>
                                @php
                                    $diff = $hmoService->price - $hmoService->service_base_price;
                                @endphp
                                <span class="badge {{ $diff >= 0 ? 'bg-label-success' : 'bg-label-danger' }}">
                                    {{ $diff >= 0 ? '+' : '' }}{{ number_format($diff, 2) }}
                                </span>
                            </td>
                            <td>
                                <form class="delete-service-form d-inline" action="{{ route('app.hmo-services.destroy', $hmoService->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-icon btn-label-danger waves-effect" onclick="return confirm('Are you sure you want to remove this service?')">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No services assigned to this plan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function submitAjaxForm(event, formElement) {
        event.preventDefault();
        var form = $(formElement);
        var url = form.attr('action');
        var method = form.attr('method');
        var data = form.serialize();
        
        var submitBtn = form.find('button[type="submit"]');
        var originalBtnHtml = submitBtn.html();
        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);

        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function(response) {
                if (response.success) {
                    $('#service-alert-container').html('<div class="alert alert-success alert-dismissible" role="alert">' + response.message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    
                    // Reload the modal by re-triggering the original button click
                    var triggerUrl = "{{ route('app.hmo-plans.services.index', $hmoPlan->id) }}";
                    $('a.dropdown-item[data-request-url="'+triggerUrl+'"]').click();
                }
            },
            error: function(xhr) {
                submitBtn.html(originalBtnHtml).attr('disabled', false);
                var message = 'An error occurred.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                $('#service-alert-container').html('<div class="alert alert-danger alert-dismissible" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            }
        });
    }

    $('#add-service-form').on('submit', function(e) {
        submitAjaxForm(e, this);
    });

    $('.edit-service-form').on('submit', function(e) {
        submitAjaxForm(e, this);
    });

    $('.delete-service-form').on('submit', function(e) {
        submitAjaxForm(e, this);
    });

    // Fetching Logic for Services via BillingService endpoint
    var $serviceSelect = $('#service_id');
    var $typeSelect = $('#type');
    var $priceInput = $('#price');

    $typeSelect.on('change', function() {
        var selectedCategory = $(this).val();
        
        $serviceSelect.empty().append('<option value="" data-price="">Select Service</option>').prop('disabled', true);
        $priceInput.val('');
        
        if (selectedCategory !== "") {
            $serviceSelect.append('<option value="" data-price="">Loading...</option>');
            
            $.ajax({
                url: "{{ route('bill.services') }}",
                type: 'POST',
                data: {
                    category: selectedCategory,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $serviceSelect.empty().append('<option value="" data-price="">Select Service</option>');
                    
                    if (response && response.length > 0) {
                        $.each(response, function(index, item) {
                            var price = item.price || 0;
                            var name = item.name || 'Unknown';
                            $serviceSelect.append('<option value="' + item.id + '" data-price="' + price + '">' + name + ' (Base: ' + Number(price).toLocaleString('en', {minimumFractionDigits: 2}) + ')</option>');
                        });
                        $serviceSelect.prop('disabled', false);
                    } else {
                        $serviceSelect.append('<option value="" data-price="">No services found.</option>');
                    }
                },
                error: function() {
                    $serviceSelect.empty().append('<option value="" data-price="">Error loading services</option>');
                }
            });
        }
    });

    // Auto-populate price logic when a Service is selected
    $serviceSelect.on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var price = selectedOption.data('price');
        
        if (price !== undefined && price !== "") {
            $priceInput.val(price);
        } else {
            $priceInput.val('');
        }
    });
});
</script>
