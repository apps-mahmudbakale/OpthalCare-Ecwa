<div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Antenatal Enrollments</h5>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="$refresh">
                <i class="ti ti-refresh"></i> Refresh
            </button>
            <input type="text" wire:model="search" class="form-control form-control-sm" placeholder="Search patient..." style="width: 200px;">
        </div>
    </div>

    <!-- Status Tabs -->
    <div class="card-body border-bottom">
        <div class="d-flex gap-2">
            <button type="button" 
                class="btn btn-sm {{ $status === 'active' ? 'btn-primary' : 'btn-outline-primary' }}" 
                wire:click="$set('status', 'active')">
                <i class="ti ti-heart-handshake me-1"></i>
                Active ({{ $activeCount }})
            </button>
            <button type="button" 
                class="btn btn-sm {{ $status === 'concluded' ? 'btn-primary' : 'btn-outline-primary' }}" 
                wire:click="$set('status', 'concluded')">
                <i class="ti ti-check-circle me-1"></i>
                Concluded ({{ $concludedCount }})
            </button>
            <button type="button" 
                class="btn btn-sm {{ $status === 'all' ? 'btn-primary' : 'btn-outline-primary' }}" 
                wire:click="$set('status', 'all')">
                <i class="ti ti-list me-1"></i>
                All ({{ $totalCount }})
            </button>
        </div>
        <small class="text-muted mt-2 d-block">Current filter: <strong>{{ ucfirst($status) }}</strong> | Found: {{ $records->total() }} records</small>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Status</th>
                    <th>Complaint</th>
                    <th>Treatment Plan</th>
                    <th>Recorded By</th>
                    @if($status === 'concluded')
                    <th>Concluded</th>
                    @endif
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($records as $record)
                <tr>
                    <td>{{ $record->visit_date ? $record->visit_date->format('M d, Y') : $record->created_at->format('M d, Y') }}</td>
                    <td>{{ $record->patient->user->firstname ?? 'N/A' }} {{ $record->patient->user->lastname ?? '' }}</td>
                    <td>
                        <span class="badge bg-{{ $record->isActive() ? 'success' : 'secondary' }}">
                            {{ $record->isActive() ? 'Active' : 'Concluded' }}
                        </span>
                    </td>
                    <td class="text-wrap" style="max-width: 200px;">{{ strlen($record->complaint ?? '') > 50 ? substr($record->complaint ?? '—', 0, 50) . '...' : ($record->complaint ?? '—') }}</td>
                    <td class="text-wrap" style="max-width: 200px;">{{ strlen($record->treatment_plan ?? '') > 50 ? substr($record->treatment_plan ?? '—', 0, 50) . '...' : ($record->treatment_plan ?? '—') }}</td>
                    <td>{{ $record->user->firstname ?? 'N/A' }} {{ $record->user->lastname ?? '' }}</td>
                    @if($status === 'concluded')
                    <td>
                        <div class="text-muted small">
                            @if($record->concluded_at)
                                {{ $record->concluded_at->format('M d, Y') }}<br>
                                <small>by {{ $record->concludedBy?->firstname }} {{ $record->concludedBy?->lastname }}</small>
                            @else
                                —
                            @endif
                        </div>
                    </td>
                    @endif
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('app.antenatal-records.show', $record->id) }}">Open Antenatal Profile</a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="javascript:void(0);">Delete</a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $status === 'concluded' ? '8' : '7' }}" class="text-center">
                        @if($status === 'active')
                            No active antenatal enrollments found.
                        @elseif($status === 'concluded')
                            No concluded antenatal enrollments found.
                        @else
                            No antenatal enrollments found.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $records->links() }}
    </div>
</div>
