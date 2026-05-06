<div>
    @if(isset($isHmoPatient) && $isHmoPatient)
        <!-- HMO Patient Message -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="ti ti-shield-check ti-lg text-info mb-3"></i>
                <h5 class="text-info">HMO Patient</h5>
                <p class="text-muted mb-0">
                    This patient is covered by an HMO plan. All bills are handled through the HMO billing system.
                </p>
                <a href="{{ route('hmo.billing') }}" class="btn btn-info btn-sm mt-3">
                    <i class="ti ti-external-link ti-xs me-1"></i>
                    View HMO Billing
                </a>
            </div>
        </div>
    @else
        <!-- Regular Billing Content -->
        <!-- Search and Filter Section -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-md-6">
                        <label class="form-label">Search</label>
                        <input type="text" class="form-control" wire:model.debounce.500ms="search" 
                               placeholder="Search by service or bill ref...">
                    </div>

                    <!-- Clear Filters -->
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-secondary" wire:click="clearFilters">
                            <i class="ti ti-x"></i> Clear
                        </button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Results Info -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <span class="text-muted">Showing {{ $billings->firstItem() ?? 0 }} to {{ $billings->lastItem() ?? 0 }} of {{ $billings->total() }} results</span>
        </div>
        <div>
            <select class="form-select form-select-sm" wire:model="perPage" style="width: auto;">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>
        </div>
    </div>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th></th>
                <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                    Date 
                    @if($sortBy === 'created_at')
                        <i class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </th>
                <th>Service</th>
                <th class="text-right">Quantity</th>
                <th class="text-right" wire:click="sortBy('amount')" style="cursor: pointer;">
                    Amount
                    @if($sortBy === 'amount')
                        <i class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </th>
                <th>Payer</th>
                <th>Status</th>
                <th>*</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($billings as $billing)
                <tr>
                    <td></td>
                    <td class="align-middle">{{ $billing->created_at->diffForHumans() }}</td>
                    <td>{{ $billing->service }}</td>
                    <td>{{ $billing->quantity }}</td>
                    <td class="text-right">{{ number_format($billing->amount) }}</td>
                    <td>
                        @if ($billing->hmoPlan)
                            <span class="text-primary">{{ $billing->hmoPlan->hmo->name ?? 'HMO' }}</span><br>
                            <small class="text-muted">{{ $billing->hmoPlan->name }}</small>
                        @else
                            <span class="text-dark">Self Pay</span>
                        @endif
                    </td>
                    <td class="text-right">
                        @if ($billing->status == 1)
                            <span class="badge bg-label-success">Paid</span>
                        @else
                            <span class="badge bg-label-warning">Unpaid</span>
                        @endif
                    </td>
                    <td class="align-middle text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                                data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                                aria-haspopup="true">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu" style="">
                                <li><button class="dropdown-item"
                                        data-request-url="{{ route('app.billing.show', $billing->bill_ref) }}"
                                        data-toggle="modal" data-target="#global-modal">Receive
                                        Payment</button></li>
                                {{-- <li>
                              <hr class="dropdown-divider">
                          </li>
                          <l><a class="dropdown-item text-bg-danger" href="javascript:void(0);">Cancel</a></l> --}}
                            </ul>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No billing records found</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $billings->links() }}
        </div>
    @endif
</div>
@include('_partials._modals.global-modal')
<script>
    $(document).ready(function() {
        $('.dropdown-item').on('click', function() {
            var requestUrl = $(this).data('request-url');

            $.ajax({
                url: requestUrl,
                type: 'GET',
                success: function(response) {
                    // Assuming the response contains the HTML for the modal content
                    $('#global-modal .modal-body').html(response);
                    $('#global-modal').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(error);
                }
            });
        });
    });
</script>
