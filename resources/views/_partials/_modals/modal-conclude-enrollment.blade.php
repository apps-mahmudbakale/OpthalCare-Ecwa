<!-- Conclude Enrollment Modal -->
<div class="modal fade" id="conclude-enrollment-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti ti-check-circle me-2 text-success"></i>
                    Conclude Antenatal Enrollment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('app.antenatal-records.conclude', $record->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="ti ti-alert-triangle me-2"></i>
                        <strong>Warning:</strong> This action will conclude the antenatal enrollment for 
                        <strong>{{ $patient->user->firstname }} {{ $patient->user->lastname }}</strong>. 
                        This cannot be undone.
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Patient Name</label>
                            <p class="fw-bold">{{ $patient->user->firstname }} {{ $patient->user->lastname }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Enrollment Date</label>
                            <p class="fw-bold">{{ $record->visit_date ? $record->visit_date->format('M d, Y') : $record->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Package</label>
                            <p class="fw-bold">{{ $record->enrolmentPackage?->name ?? 'No package selected' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Current Status</label>
                            <p class="fw-bold">
                                <span class="badge bg-{{ $record->isActive() ? 'success' : 'secondary' }}">
                                    {{ $record->isActive() ? 'Active' : 'Concluded' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="conclusion_notes" class="form-label">
                            Conclusion Notes <span class="text-muted">(Optional)</span>
                        </label>
                        <textarea 
                            class="form-control" 
                            id="conclusion_notes" 
                            name="conclusion_notes" 
                            rows="4" 
                            placeholder="Enter any notes about the conclusion of this enrollment..."
                        ></textarea>
                        <div class="form-text">
                            Provide details about the reason for concluding this enrollment (e.g., delivery completed, patient transferred, etc.)
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="ti ti-check me-1"></i>
                        Conclude Enrollment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>