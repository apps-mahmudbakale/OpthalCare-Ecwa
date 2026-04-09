<div>
    <div class="table-responsive text-nowrap mt-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Investigation</th>
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
                            {{ $request->test->name ?? 'N/A' }}
                        </td>
                        <td>
                            @php
                                $statusBadge = [
                                    'Pending' => 'bg-label-warning',
                                    'Specimen Collected' => 'bg-label-info',
                                    'Result Ready' => 'bg-label-success',
                                    'Cancelled' => 'bg-label-danger',
                                ];
                                $class = $statusBadge[$request->status] ?? 'bg-label-secondary';
                            @endphp
                            <span class="badge {{ $class }}">{{ $request->status }}</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                @if ($request->status == 'Result Ready')
                                    <a href="javascript:void(0);" 
                                       data-request-url="{{ route('app.lab.print.result', ['lab' => $request->id, 'modal' => 1]) }}"
                                       data-target="#global-modal-lg"
                                       class="btn btn-sm btn-icon btn-outline-secondary" title="View Result">
                                        <i class="ti ti-eye ti-xs"></i>
                                    </a>
                                    <a href="{{ route('app.lab.print.result', $request->id) }}" target="_blank"
                                        class="btn btn-sm btn-icon btn-outline-secondary" title="Print Result">
                                        <i class="ti ti-printer ti-xs"></i>
                                    </a>
                                @endif
                                <a href="javascript:void(0);" 
                                   data-request-url="{{ route('app.lab.edit', $request->id) }}"
                                   data-target="#global-modal-lg"
                                   class="btn btn-sm btn-icon btn-outline-secondary" title="Edit">
                                    <i class="ti ti-edit ti-xs"></i>
                                </a>
                                @if($request->status === 'Pending')
                                <form action="{{ route('app.lab.destroy', $request->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Cancel this lab request and remove its bill?')">
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
                        <td colspan="4" class="text-center py-4 text-muted">No lab requests found for this patient.</td>
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
