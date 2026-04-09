<div>
    <div class="table-responsive text-nowrap mt-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Drug</th>
                    <th>Dose</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($requests as $request)
                    <tr>
                        <td>
                            <span class="fw-medium">{{ $request->created_at->format('d M Y') }}</span><br>
                            <small class="text-muted">{{ $request->created_at->format('h:i A') }}</small>
                        </td>
                        <td>
                            <span class="badge bg-label-primary">{{ $request->drug->name ?? 'N/A' }}</span>
                        </td>
                        <td>{{ $request->dose }}</td>
                        <td>{{ $request->qty }}</td>
                        <td>
                            @php
                                $statusBadge = [
                                    'Pending' => 'bg-label-warning',
                                    'Filled' => 'bg-label-success',
                                    'Cancelled' => 'bg-label-danger',
                                ];
                                $class = $statusBadge[$request->status] ?? 'bg-label-secondary';
                            @endphp
                            <span class="badge {{ $class }}">{{ $request->status }}</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('app.pharmacy.request.print', $request->id) }}" target="_blank"
                                    class="btn btn-sm btn-icon btn-outline-secondary" title="Print Prescription">
                                    <i class="ti ti-printer ti-xs"></i>
                                </a>
                                @if($request->status === 'Pending')
                                <form action="{{ route('app.pharmacy.drug-request.destroy', $request->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Cancel this drug request and remove its bill?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Cancel">
                                        <i class="ti ti-trash ti-xs"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No drug prescriptions found for this patient.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="row mt-3">
        <div class="col-sm-12 col-md-12">
            {{ $requests->links() }}
        </div>
    </div>
</div>
