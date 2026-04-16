<div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Visit Date</th>
                    <th>Recorded By</th>
                    <th>Complaint</th>
                    <th>Treatment Plan</th>
                    <th>Note</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($records as $record)
                <tr>
                    <td>{{ $record->visit_date ? $record->visit_date->format('M d, Y') : $record->created_at->format('M d, Y') }}</td>
                    <td>{{ $record->user->firstname ?? 'N/A' }} {{ $record->user->lastname ?? '' }}</td>
                    <td class="text-wrap" style="max-width: 200px;">{{ $record->complaint ?? '—' }}</td>
                    <td class="text-wrap" style="max-width: 200px;">{{ $record->treatment_plan ?? '—' }}</td>
                    <td class="text-wrap" style="max-width: 200px;">{{ $record->note ?? '—' }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button"
                                class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('app.antenatal-records.show', $record->id) }}">Open Profile</a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item text-danger" wire:click="delete({{ $record->id }})"
                                        wire:confirm="Are you sure you want to delete this record?">
                                        Delete
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No antenatal records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $records->links() }}
    </div>

    <!-- New Record Modal -->
    <div wire:ignore.self class="modal fade" id="new-antenatal-record-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Antenatal Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('app.antenatal-records.store') }}">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patientId }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Visit Date</label>
                                <input type="date" name="visit_date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>

                            {{-- Obstetric History --}}
                            <div class="col-12 mb-2"><hr><h6 class="text-muted">Obstetric History</h6></div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Gravida</label>
                                <input type="number" name="gravida" class="form-control" min="0" placeholder="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Parity</label>
                                <input type="number" name="parity" class="form-control" min="0" placeholder="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Alive</label>
                                <input type="number" name="alive" class="form-control" min="0" placeholder="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Miscarriage</label>
                                <input type="number" name="miscarriage" class="form-control" min="0" placeholder="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Menstrual Period</label>
                                <input type="date" name="last_menstrual_period" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Current Pregnancy</label>
                                <input type="text" name="current_pregnancy" class="form-control" placeholder="e.g. 28 weeks, Twin, etc.">
                            </div>

                            {{-- Clinical Notes --}}
                            <div class="col-12 mb-2"><hr><h6 class="text-muted">Clinical Notes</h6></div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Complaint</label>
                                <textarea name="complaint" class="form-control" rows="3" placeholder="Chief complaint..."></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Treatment Plan</label>
                                <textarea name="treatment_plan" class="form-control" rows="4" placeholder="Treatment plan..."></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="note" class="form-control" rows="3" placeholder="Additional notes..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
