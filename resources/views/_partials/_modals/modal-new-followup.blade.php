<!-- New Follow-up Modal -->
<div wire:ignore.self class="modal fade" id="new-followup-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="text-center mb-4">
                    <h3 class="mb-2">New Follow-up Visit</h3>
                    <p class="text-muted">{{ $patient->user->firstname }} {{ $patient->user->lastname }}</p>
                </div>

                <form method="POST" action="{{ route('app.antenatal-records.store') }}" class="row g-3">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patientId }}">
                    <input type="hidden" name="visit_type" value="followup">

                    <!-- Visit Date -->
                    <div class="col-md-6">
                        <label class="form-label" for="visit_date">Visit Date</label>
                        <input type="date" id="visit_date" name="visit_date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>

                    <!-- Physical Examination Section -->
                    <div class="col-12">
                        <h5 class="text-primary mt-4 mb-3">Physical Examination</h5>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="height_of_fundus">Height of Fundus</label>
                        <input type="text" id="height_of_fundus" name="height_of_fundus" class="form-control" placeholder="e.g., 28 cm">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="presentation_and_position">Presentation and Position</label>
                        <input type="text" id="presentation_and_position" name="presentation_and_position" class="form-control" placeholder="e.g., Vertex, LOA">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="fetal_heart">Fetal Heart</label>
                        <input type="text" id="fetal_heart" name="fetal_heart" class="form-control" placeholder="e.g., 140 bpm, regular">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="urine">Urine</label>
                        <select id="urine" name="urine" class="form-select">
                            <option value="">Select...</option>
                            <option value="Normal">Normal</option>
                            <option value="Protein +">Protein +</option>
                            <option value="Protein ++">Protein ++</option>
                            <option value="Protein +++">Protein +++</option>
                            <option value="Sugar +">Sugar +</option>
                            <option value="Sugar ++">Sugar ++</option>
                            <option value="Sugar +++">Sugar +++</option>
                            <option value="Blood +">Blood +</option>
                            <option value="Blood ++">Blood ++</option>
                            <option value="Blood +++">Blood +++</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="blood_pressure">Blood Pressure</label>
                        <input type="text" id="blood_pressure" name="blood_pressure" class="form-control" placeholder="e.g., 120/80 mmHg">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="weight">Weight (kg)</label>
                        <input type="number" id="weight" name="weight" class="form-control" step="0.1" min="0" max="999.99" placeholder="e.g., 65.5">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="edema">Edema</label>
                        <select id="edema" name="edema" class="form-select">
                            <option value="">Select...</option>
                            <option value="None">None</option>
                            <option value="Mild">Mild</option>
                            <option value="Moderate">Moderate</option>
                            <option value="Severe">Severe</option>
                            <option value="Pitting">Pitting</option>
                            <option value="Non-pitting">Non-pitting</option>
                        </select>
                    </div>

                    <!-- Clinical Notes Section -->
                    <div class="col-12">
                        <h5 class="text-primary mt-4 mb-3">Clinical Notes</h5>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="followup_complaint">Complaint</label>
                        <textarea id="followup_complaint" name="followup_complaint" class="form-control" rows="3" placeholder="Patient's complaints or symptoms..."></textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="followup_treatment">Treatment Plan</label>
                        <textarea id="followup_treatment" name="followup_treatment" class="form-control" rows="3" placeholder="Treatment plan and recommendations..."></textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="followup_notes">Notes</label>
                        <textarea id="followup_notes" name="followup_notes" class="form-control" rows="3" placeholder="Additional notes and observations..."></textarea>
                    </div>

                    <div class="col-12 text-center mt-4">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary">Cancel</button>
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Save Follow-up Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>