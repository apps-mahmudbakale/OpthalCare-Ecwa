<div>
    @if($deliveries->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Delivery Date</th>
                        <th>Type</th>
                        <th>Gestation</th>
                        <th>Baby Gender</th>
                        <th>Birth Weight</th>
                        <th>APGAR</th>
                        <th>Recorded By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deliveries as $delivery)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $delivery->delivery_date->format('M d, Y') }}</div>
                                <small class="text-muted">{{ $delivery->delivery_date->format('h:i A') }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $delivery->delivery_type == 'normal' ? 'success' : ($delivery->delivery_type == 'cesarean' ? 'warning' : 'info') }}">
                                    {{ ucfirst($delivery->delivery_type) }}
                                </span>
                            </td>
                            <td>{{ $delivery->gestation ?? '—' }}</td>
                            <td>
                                @if($delivery->baby_gender)
                                    <span class="badge bg-{{ $delivery->baby_gender == 'male' ? 'primary' : 'pink' }}">
                                        {{ ucfirst($delivery->baby_gender) }}
                                    </span>
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $delivery->birth_weight ? $delivery->birth_weight . ' kg' : '—' }}</td>
                            <td>
                                @if($delivery->apgar_1_min || $delivery->apgar_5_min)
                                    {{ $delivery->apgar_1_min ?? '—' }}/{{ $delivery->apgar_5_min ?? '—' }}
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $delivery->user->firstname }} {{ $delivery->user->lastname }}</div>
                                <small class="text-muted">{{ $delivery->created_at->format('M d, Y h:i A') }}</small>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-icon btn-light" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('app.deliveries.show', $delivery->id) }}">
                                                <i class="ti ti-eye me-2"></i>View Details
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#" 
                                               onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" 
                                               wire:click="delete({{ $delivery->id }})">
                                                <i class="ti ti-trash me-2"></i>Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $deliveries->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="ti ti-baby-carriage" style="font-size: 3rem; color: #ddd;"></i>
            </div>
            <h6 class="text-muted">No delivery records found</h6>
            <p class="text-muted mb-0">Delivery records will appear here once added.</p>
        </div>
    @endif
</div>
