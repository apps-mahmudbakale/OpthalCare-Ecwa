<div>
    <div wire:ignore.self class="modal fade" id="hmo-services-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-simple">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Manage Services for {{ $plan->hmo->name ?? '' }} ({{ $plan->name ?? '' }})</h3>
                        <p class="text-muted">Add or remove services and set custom pricing for this HMO plan.</p>
                    </div>

                    <div class="row g-3">
                        <!-- Add/Edit Service Form -->
                        <div class="col-md-12">
                            <div class="card bg-light border-0 shadow-none mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $editing_id ? 'Edit Service Price' : 'Add New Service' }}</h5>
                                    <form wire:submit.prevent="{{ $editing_id ? 'updateService' : 'addService' }}">
                                        <div class="row align-items-end g-3">
                                            <div class="col-md-5">
                                                <label class="form-label" for="service_id">Service</label>
                                                <select wire:model.defer="service_id" id="service_id" class="form-select @error('service_id') is-invalid @enderror" {{ $editing_id ? 'disabled' : '' }}>
                                                    <option value="">Select Service</option>
                                                    @foreach($allServices as $service)
                                                        <option value="{{ $service->id }}">{{ $service->name }} (Base: {{ number_format($service->price, 2) }})</option>
                                                    @endforeach
                                                </select>
                                                @error('service_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="price">HMO Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">&#8358;</span>
                                                    <input wire:model.defer="price" type="number" step="0.01" id="price" class="form-control @error('price') is-invalid @enderror" placeholder="0.00">
                                                </div>
                                                @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-3">
                                                @if($editing_id)
                                                    <button type="submit" class="btn btn-primary w-100">Update</button>
                                                    <button type="button" wire:click="cancelEdit" class="btn btn-label-secondary w-100 mt-2">Cancel</button>
                                                @else
                                                    <button type="submit" class="btn btn-success w-100">Add Service</button>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Services Table -->
                        <div class="col-md-12">
                            @if(session()->has('success'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

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
                                                <td><strong>{{ $hmoService->service->name }}</strong></td>
                                                <td>&#8358;{{ number_format($hmoService->service->price, 2) }}</td>
                                                <td>&#8358;{{ number_format($hmoService->price, 2) }}</td>
                                                <td>
                                                    @php
                                                        $diff = $hmoService->price - $hmoService->service->price;
                                                    @endphp
                                                    <span class="badge {{ $diff >= 0 ? 'bg-label-success' : 'bg-label-danger' }}">
                                                        {{ $diff >= 0 ? '+' : '' }}{{ number_format($diff, 2) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex g-2">
                                                        <button type="button" wire:click="editService({{ $hmoService->id }})" class="btn btn-sm btn-icon btn-label-primary waves-effect me-2">
                                                            <i class="ti ti-edit"></i>
                                                        </button>
                                                        <button type="button" wire:click="removeService({{ $hmoService->id }})" class="btn btn-sm btn-icon btn-label-danger waves-effect" onclick="return confirm('Are you sure you want to remove this service?')">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </div>
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
                </div>
            </div>
        </div>
    </div>

    @push('body-scripts')
    <script>
        window.addEventListener('HmoServicesModal', function() {
            $('#hmo-services-modal').modal('show');
        });
    </script>
    @endpush
</div>
