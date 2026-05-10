<!-- New Antenatal Record Modal -->
<div class="modal fade" id="new-antenatal-record-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti ti-baby-carriage me-2 text-primary"></i>
                    New Antenatal Visit
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('app.antenatal-records.store') }}">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $patientId }}">
                <input type="hidden" name="from_patient_profile" value="1">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Visit Type <span class="text-danger">*</span></label>
                            <select name="visit_type" class="form-select" required>
                                <option value="new">New Visit</option>
                                <option value="followup">Follow-up Visit</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Visit Date</label>
                            <input type="date" name="visit_date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>

                        {{-- Obstetric History (for new visits only) --}}
                        <div id="obstetric-history" class="col-12">
                            <div class="col-12 mb-2"><hr><h6 class="text-muted">Obstetric History</h6></div>
                            <div class="row">
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
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Enrolment Package</label>
                                    <select name="enrolment_package_id" class="form-select">
                                        <option value="">-- None --</option>
                                        @foreach(\App\Models\AntenatalPackage::orderBy('name')->get() as $pkg)
                                            <option value="{{ $pkg->id }}">{{ $pkg->name }} (₦{{ number_format($pkg->price) }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Follow-up Fields (for follow-up visits only) --}}
                        <div id="followup-fields" class="col-12" style="display: none;">
                            <div class="col-12 mb-2"><hr><h6 class="text-muted">Physical Examination</h6></div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Height of Fundus</label>
                                    <input type="text" name="height_of_fundus" class="form-control" placeholder="e.g. 28cm">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Presentation and Position</label>
                                    <input type="text" name="presentation_and_position" class="form-control" placeholder="e.g. Vertex, LOA">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fetal Heart</label>
                                    <input type="text" name="fetal_heart" class="form-control" placeholder="e.g. 140 bpm">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Urine</label>
                                    <input type="text" name="urine" class="form-control" placeholder="e.g. Protein +, Sugar -">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Blood Pressure</label>
                                    <input type="text" name="blood_pressure" class="form-control" placeholder="e.g. 120/80 mmHg">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Weight (kg)</label>
                                    <input type="number" name="weight" class="form-control" step="0.1" placeholder="65.5">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Edema</label>
                                    <input type="text" name="edema" class="form-control" placeholder="e.g. None, +, ++">
                                </div>
                            </div>
                        </div>

                        {{-- Clinical Notes --}}
                        <div class="col-12 mb-2"><hr><h6 class="text-muted">Clinical Notes</h6></div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" id="complaint-label">Complaint</label>
                            <textarea name="complaint" class="form-control" rows="3" placeholder="Chief complaint..."></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" id="treatment-label">Treatment Plan</label>
                            <textarea name="treatment_plan" class="form-control" rows="3" placeholder="Treatment plan..."></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" id="notes-label">Notes</label>
                            <textarea name="note" class="form-control" rows="3" placeholder="Additional notes..."></textarea>
                        </div>

                        {{-- Follow-up specific fields --}}
                        <div id="followup-notes" style="display: none;">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Follow-up Complaint</label>
                                <textarea name="followup_complaint" class="form-control" rows="2" placeholder="Follow-up complaint..."></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Follow-up Treatment</label>
                                <textarea name="followup_treatment" class="form-control" rows="2" placeholder="Follow-up treatment..."></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Follow-up Notes</label>
                                <textarea name="followup_notes" class="form-control" rows="2" placeholder="Follow-up notes..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i>
                        Save Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const visitTypeSelect = document.querySelector('select[name="visit_type"]');
    const obstetricHistory = document.getElementById('obstetric-history');
    const followupFields = document.getElementById('followup-fields');
    const followupNotes = document.getElementById('followup-notes');
    const complaintLabel = document.getElementById('complaint-label');
    const treatmentLabel = document.getElementById('treatment-label');
    const notesLabel = document.getElementById('notes-label');

    function toggleFields() {
        const isFollowup = visitTypeSelect.value === 'followup';
        
        if (isFollowup) {
            obstetricHistory.style.display = 'none';
            followupFields.style.display = 'block';
            followupNotes.style.display = 'block';
            complaintLabel.textContent = 'Initial Complaint';
            treatmentLabel.textContent = 'Initial Treatment Plan';
            notesLabel.textContent = 'Initial Notes';
        } else {
            obstetricHistory.style.display = 'block';
            followupFields.style.display = 'none';
            followupNotes.style.display = 'none';
            complaintLabel.textContent = 'Complaint';
            treatmentLabel.textContent = 'Treatment Plan';
            notesLabel.textContent = 'Notes';
        }
    }

    visitTypeSelect.addEventListener('change', toggleFields);
    toggleFields(); // Initialize on load
});
</script>