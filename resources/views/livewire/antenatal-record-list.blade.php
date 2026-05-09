<div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Antenatal Records</h5>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="$refresh">
                <i class="ti ti-refresh"></i> Refresh
            </button>
            <input type="text" wire:model="search" class="form-control form-control-sm" placeholder="Search patient..." style="width: 200px;">
        </div>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Visit Type</th>
                    <th>Complaint</th>
                    <th>Treatment Plan</th>
                    <th>Recorded By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($records as $record)
                <tr>
                    <td>{{ $record->visit_date ? $record->visit_date->format('M d, Y') : $record->created_at->format('M d, Y') }}</td>
                    <td>{{ $record->patient->user->firstname ?? 'N/A' }} {{ $record->patient->user->lastname ?? '' }}</td>
                    <td>
                        <span class="badge bg-{{ $record->visit_type === 'followup' ? 'info' : 'primary' }}">
                            {{ $record->visit_type === 'followup' ? 'Follow Up' : 'New Visit' }}
                        </span>
                    </td>
                    <td class="text-wrap" style="max-width: 200px;">{{ strlen($record->complaint ?? '') > 50 ? substr($record->complaint ?? '—', 0, 50) . '...' : ($record->complaint ?? '—') }}</td>
                    <td class="text-wrap" style="max-width: 200px;">{{ strlen($record->treatment_plan ?? '') > 50 ? substr($record->treatment_plan ?? '—', 0, 50) . '...' : ($record->treatment_plan ?? '—') }}</td>
                    <td>{{ $record->user->firstname ?? 'N/A' }} {{ $record->user->lastname ?? '' }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('app.antenatal-records.show', $record->id) }}">Open Profile</a>
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
                    <td colspan="7" class="text-center">No antenatal records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $records->links() }}
    </div>
</div>
