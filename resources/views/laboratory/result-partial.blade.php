<div class="p-3">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
        <div>
            <h5 class="mb-0">{{ $lab->test->name ?? 'N/A' }}</h5>
            <small class="text-muted">Order Date: {{ $lab->created_at->format('D, j/n/Y g:iA') }}</small>
        </div>
        <div class="text-end">
            <span class="badge bg-label-success">Result Ready</span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="bg-light">
                <tr>
                    <th>Parameter</th>
                    <th>Value</th>
                    <th>Reference</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
                @if($result)
                    @foreach($result->items as $item)
                    <tr>
                        <td class="fw-medium">{{ $item->templateItem?->parameter?->name ?? 'N/A' }}</td>
                        <td>{{ $item->value }}</td>
                        <td>{{ $item->templateItem->reference ?? 'N/A' }}</td>
                        <td>{{ $item->remark }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center py-4">No result recorded.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if($result)
    <div class="mt-3 small text-muted border-top pt-2">
        <strong>Approved By:</strong> {{ $result->user ? $result->user->firstname . ' ' . $result->user->lastname : 'N/A' }} 
        on {{ $result->created_at->format('D, j/n/Y g:iA') }}
    </div>
    @endif
</div>
