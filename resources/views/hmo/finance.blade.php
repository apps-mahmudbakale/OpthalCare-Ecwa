@extends('layouts.layoutMaster')

@section('title', 'HMO Finance & Wallets')

@section('content')
<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">HMO /</span> Finance & Wallets</h4>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">HMO Provider Wallets</h5>
            <form action="{{ route('app.hmo.finance') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Search HMO..." style="width:220px;">
                <button class="btn btn-primary">Search</button>
            </form>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>HMO Group</th>
                        <th>Phone / Email</th>
                        <th>Wallet Balance</th>
                        <th>Last Activity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($hmos as $hmo)
                        @php $balance = $hmo->wallet->balance ?? 0; @endphp
                        <tr>
                            <td><strong>{{ $hmo->name }}</strong></td>
                            <td>{{ $hmo->phone }}<br><small>{{ $hmo->email }}</small></td>
                            <td>
                                <span class="badge fs-6 {{ $balance < 0 ? 'bg-label-danger' : 'bg-label-success' }}">
                                    ₦{{ number_format($balance, 2) }}
                                    @if($balance < 0) <small>(Outstanding)</small> @endif
                                </span>
                            </td>
                            <td>
                                {{ $hmo->wallet && $hmo->wallet->updated_at ? $hmo->wallet->updated_at->diffForHumans() : 'N/A' }}
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal" data-bs-target="#fundModal"
                                    data-id="{{ $hmo->id }}" data-name="{{ $hmo->name }}">
                                    <i class="ti ti-plus me-1"></i> Fund Wallet
                                </button>
                                <a href="{{ route('app.hmo.finance.history', $hmo) }}" class="btn btn-sm btn-outline-info">
                                    <i class="ti ti-list me-1"></i> History
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No HMO Groups found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $hmos->links() }}</div>
    </div>
</div>

<!-- Fund Wallet Modal -->
<div class="modal fade" id="fundModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fund HMO Wallet — <span id="modalHmoName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="fundForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Funding Amount (₦)</label>
                        <input type="number" name="amount" class="form-control" placeholder="0.00" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description / Reference</label>
                        <input type="text" name="description" class="form-control" value="Wallet Funding" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm Funding</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fundModal = document.getElementById('fundModal');
        fundModal.addEventListener('show.bs.modal', (e) => {
            const btn = e.relatedTarget;
            document.getElementById('modalHmoName').textContent = btn.dataset.name;
            document.getElementById('fundForm').action = `{{ url('app/hmo') }}/${btn.dataset.id}/fund-wallet`;
        });
    });
</script>
@endsection
