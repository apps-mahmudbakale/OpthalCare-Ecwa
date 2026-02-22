<div class="p-3">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
        <div>
            <h5 class="mb-0">{{ $image->test->name ?? 'Radiology Result' }}</h5>
            <small class="text-muted">Order Date: {{ $image->created_at->format('D, j/n/Y g:iA') }}</small>
        </div>
        <div class="text-end">
            <span class="badge bg-label-success">Result Ready</span>
        </div>
    </div>

    <div class="result-content border rounded p-3 bg-light" style="min-height: 200px; line-height: 1.6;">
        {!! $result ? $result->result : '<p class="text-center text-muted my-5">No results found.</p>' !!}
    </div>

    @if($result)
    <div class="mt-3 small text-muted border-top pt-2">
        <strong>Reported By:</strong> {{ $result->user ? $result->user->firstname . ' ' . $result->user->lastname : 'N/A' }} 
        on {{ $result->created_at->format('D, j/n/Y g:iA') }}
    </div>
    @endif
</div>
