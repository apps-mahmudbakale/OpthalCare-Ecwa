<!-- New Delivery Modal -->
<div class="modal fade" id="new-delivery-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Delivery Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('app.deliveries.store') }}">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $patientId }}">
                <input type="hidden" name="antenatal_record_id" value="{{ $record->id }}">
                
                <div class="modal-body">
                    <div class="row">
                        <!-- Delivery Information -->
                        <div class="col-12 mb-3">
                            <h6 class="text-primary"><i class="ti ti-baby-carriage me-2"></i>Delivery Information</h6>
                            <hr class="mt-1 mb-3">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Delivery Date & Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="delivery_date" class="form-control" required value="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Delivery Type <span class="text-danger">*</span></label>
                            <select name="delivery_type" class="form-select" required>
                                <option value="">Select Type</option>
                                <option value="normal">Normal Vaginal Delivery</option>
                                <option value="cesarean">Cesarean Section</option>
                                <option value="assisted">Assisted Delivery</option>
                                <option value="vacuum">Vacuum Extraction</option>
                                <option value="forceps">Forceps Delivery</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Presentation</label>
                            <select name="presentation" class="form-select">
                                <option value="">Select Presentation</option>
                                <option value="vertex">Vertex</option>
                                <option value="breech">Breech</option>
                                <option value="transverse">Transverse</option>
                                <option value="compound">Compound</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Gestation (Weeks)</label>
                            <input type="number" name="gestation_weeks" class="form-control" min="0" max="50" placeholder="40">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Gestation (Days)</label>
                            <input type="number" name="gestation_days" class="form-control" min="0" max="6" placeholder="0">
                        </div>

                        <!-- Labor Information -->
                        <div class="col-12 mb-3 mt-3">
                            <h6 class="text-primary"><i class="ti ti-clock me-2"></i>Labor Information</h6>
                            <hr class="mt-1 mb-3">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Labor Onset</label>
                            <input type="datetime-local" name="labor_onset" class="form-control">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Duration (Hours)</label>
                            <input type="number" name="labor_duration_hours" class="form-control" min="0" placeholder="0">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Duration (Minutes)</label>
                            <input type="number" name="labor_duration_minutes" class="form-control" min="0" max="59" placeholder="0">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Labor Complications</label>
                            <textarea name="labor_complications" class="form-control" rows="2" placeholder="Any complications during labor..."></textarea>
                        </div>

                        <!-- Baby Information -->
                        <div class="col-12 mb-3 mt-3">
                            <h6 class="text-primary"><i class="ti ti-baby me-2"></i>Baby Information</h6>
                            <hr class="mt-1 mb-3">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Baby Gender</label>
                            <select name="baby_gender" class="form-select">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Birth Weight (kg)</label>
                            <input type="number" name="birth_weight" class="form-control" step="0.01" min="0" max="10" placeholder="3.5">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Birth Length (cm)</label>
                            <input type="number" name="birth_length" class="form-control" min="0" max="100" placeholder="50">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Head Circumference (cm)</label>
                            <input type="number" name="head_circumference" class="form-control" min="0" max="100" placeholder="35">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">APGAR Score (1 min)</label>
                            <input type="number" name="apgar_1_min" class="form-control" min="0" max="10" placeholder="9">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">APGAR Score (5 min)</label>
                            <input type="number" name="apgar_5_min" class="form-control" min="0" max="10" placeholder="10">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Baby Condition</label>
                            <textarea name="baby_condition" class="form-control" rows="2" placeholder="Baby's general condition..."></textarea>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Baby Complications</label>
                            <textarea name="baby_complications" class="form-control" rows="2" placeholder="Any complications with baby..."></textarea>
                        </div>

                        <!-- Placenta Information -->
                        <div class="col-12 mb-3 mt-3">
                            <h6 class="text-primary"><i class="ti ti-circle me-2"></i>Placenta Information</h6>
                            <hr class="mt-1 mb-3">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Placenta Delivery</label>
                            <select name="placenta_delivery" class="form-select">
                                <option value="">Select Status</option>
                                <option value="complete">Complete</option>
                                <option value="incomplete">Incomplete</option>
                                <option value="retained">Retained</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Placenta Weight (grams)</label>
                            <input type="number" name="placenta_weight" class="form-control" min="0" placeholder="500">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Placenta Condition</label>
                            <textarea name="placenta_condition" class="form-control" rows="2" placeholder="Placenta appearance and condition..."></textarea>
                        </div>

                        <!-- Mother's Condition -->
                        <div class="col-12 mb-3 mt-3">
                            <h6 class="text-primary"><i class="ti ti-user-heart me-2"></i>Maternal Condition</h6>
                            <hr class="mt-1 mb-3">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Blood Loss (ml)</label>
                            <input type="number" name="blood_loss" class="form-control" min="0" placeholder="300">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Perineal Condition</label>
                            <input type="text" name="perineal_condition" class="form-control" placeholder="Intact, episiotomy, tear, etc.">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Maternal Condition</label>
                            <textarea name="maternal_condition" class="form-control" rows="2" placeholder="Mother's general condition post-delivery..."></textarea>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Complications</label>
                            <textarea name="complications" class="form-control" rows="2" placeholder="Any complications during or after delivery..."></textarea>
                        </div>

                        <!-- Post-delivery Care -->
                        <div class="col-12 mb-3 mt-3">
                            <h6 class="text-primary"><i class="ti ti-medical-cross me-2"></i>Post-delivery Care</h6>
                            <hr class="mt-1 mb-3">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Immediate Care</label>
                            <textarea name="immediate_care" class="form-control" rows="2" placeholder="Immediate care provided..."></textarea>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Medications Given</label>
                            <textarea name="medications_given" class="form-control" rows="2" placeholder="Medications administered..."></textarea>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Feeding Plan</label>
                            <textarea name="feeding_plan" class="form-control" rows="2" placeholder="Breastfeeding plan, formula, etc..."></textarea>
                        </div>

                        <!-- General Notes -->
                        <div class="col-12 mb-3 mt-3">
                            <h6 class="text-primary"><i class="ti ti-notes me-2"></i>Notes & Recommendations</h6>
                            <hr class="mt-1 mb-3">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Delivery Notes</label>
                            <textarea name="delivery_notes" class="form-control" rows="3" placeholder="Detailed delivery notes..."></textarea>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Recommendations</label>
                            <textarea name="recommendations" class="form-control" rows="3" placeholder="Follow-up recommendations..."></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Delivery Record</button>
                </div>
            </form>
        </div>
    </div>
</div>