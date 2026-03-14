<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">HMO /</span> Finance & Wallets</h4>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">HMO Provider Wallets</h5>
            <input type="text" wire:model="search" class="form-control w-25" placeholder="Search HMO...">
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>HMO Group</th>
                        <th>Phone/Email</th>
                        <th>Wallet Balance</th>
                        <th>Last Activity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($hmos as $hmo)
                        <tr>
                            <td><strong>{{ $hmo->name }}</strong></td>
                            <td>{{ $hmo->phone }}<br><small>{{ $hmo->email }}</small></td>
                            <td>
                                <span class="badge bg-label-success fs-6">
                                    ₦{{ number_format($hmo->wallet->balance ?? 0, 2) }}
                                </span>
                            </td>
                            <td>
                                {{ $hmo->wallet && $hmo->wallet->updated_at ? $hmo->wallet->updated_at->diffForHumans() : 'N/A' }}
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#fundModal" wire:click="selectHmo({{ $hmo->id }})">
                                    <i class="ti ti-plus me-1"></i> Fund Wallet
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#historyModal" wire:click="showHistory({{ $hmo->id }})">
                                    <i class="ti ti-list me-1"></i> History
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No HMO Groups found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $hmos->links() }}
        </div>
    </div>

    <!-- Fund Wallet Modal -->
    <div wire:ignore.self class="modal fade" id="fundModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Fund HMO Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="fundWallet">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Funding Amount (₦)</label>
                            <input type="number" wire:model="fundingAmount" class="form-control @error('fundingAmount') is-invalid @enderror" placeholder="0.00">
                            @error('fundingAmount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description / Reference</label>
                            <input type="text" wire:model="fundingDescription" class="form-control @error('fundingDescription') is-invalid @enderror" placeholder="e.g. Q1 Advance Payment">
                            @error('fundingDescription') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading class="spinner-border spinner-border-sm me-1"></span>
                            Confirm Funding
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <div wire:ignore.self class="modal fade" id="historyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transaction History: {{ $selectedHmoName }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Ref</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($historyTransactions as $tx)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($tx['created_at'])->format('d M, Y H:i') }}</td>
                                        <td>
                                            @if($tx['type'] == 'credit')
                                                <span class="badge bg-label-success">Credit</span>
                                            @else
                                                <span class="badge bg-label-danger">Debit</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold">₦{{ number_format($tx['amount'], 2) }}</td>
                                        <td>{{ $tx['description'] }}</td>
                                        <td><small class="text-muted">{{ $tx['reference'] ?? '-' }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No transactions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.livewire.on('closeModal', () => {
                var modal = bootstrap.Modal.getInstance(document.getElementById('fundModal'));
                if(modal) modal.hide();
            });
        });
    </script>
</div>
