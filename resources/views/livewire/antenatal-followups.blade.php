<div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Follow-up Records</h5>
        <div class="d-flex gap-2">
            <input type="text" wire:model="search" class="form-control form-control-sm" placeholder="Search follow-ups..." style="width: 200px;">
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Visit Date</th>
                    <th>Fundus Height</th>
                    <th>Presentation</th>
                    <th>Fetal Heart</th>
                    <th>BP</th>
                    <th>Weight</th>
                    <th>Edema</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($followups as $followup)
                    <tr>
                        <td>
                            <span class="badge bg-info">{{ $followup->visit_date ? $followup->visit_date->format('M d, Y') : $followup->created_at->format('M d, Y') }}</span>
                        </td>
                        <td>{{ $followup->height_of_fundus ?? '—' }}</td>
                        <td>{{ $followup->presentation_and_position ?? '—' }}</td>
                        <td>{{ $followup->fetal_heart ?? '—' }}</td>
                        <td>{{ $followup->blood_pressure ?? '—' }}</td>
                        <td>{{ $followup->weight ? $followup->weight . ' kg' : '—' }}</td>
                        <td>{{ $followup->edema ?? '—' }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#view-followup-modal-{{ $followup->id }}">
                                            <i class="ti ti-eye me-1"></i> View Details
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit-followup-modal-{{ $followup->id }}">
                                            <i class="ti ti-edit me-1"></i> Edit
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" 
                                           onclick="confirm('Are you sure you want to delete this follow-up record?') || event.stopImmediatePropagation()" 
                                           wire:click="deleteFollowup({{ $followup->id }})">
                                            <i class="ti ti-trash me-1"></i> Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- View Modal -->
                            <div class="modal fade" id="view-followup-modal-{{ $followup->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Follow-up Details - {{ $followup->visit_date ? $followup->visit_date->format('M d, Y') : $followup->created_at->format('M d, Y') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="text-primary">Physical Examination</h6>
                                                    <table class="table table-sm">
                                                        <tr><td class="text-muted">Height of Fundus:</td><td>{{ $followup->height_of_fundus ?? '—' }}</td></tr>
                                                        <tr><td class="text-muted">Presentation & Position:</td><td>{{ $followup->presentation_and_position ?? '—' }}</td></tr>
                                                        <tr><td class="text-muted">Fetal Heart:</td><td>{{ $followup->fetal_heart ?? '—' }}</td></tr>
                                                        <tr><td class="text-muted">Urine:</td><td>{{ $followup->urine ?? '—' }}</td></tr>
                                                        <tr><td class="text-muted">Blood Pressure:</td><td>{{ $followup->blood_pressure ?? '—' }}</td></tr>
                                                        <tr><td class="text-muted">Weight:</td><td>{{ $followup->weight ? $followup->weight . ' kg' : '—' }}</td></tr>
                                                        <tr><td class="text-muted">Edema:</td><td>{{ $followup->edema ?? '—' }}</td></tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="text-primary">Clinical Notes</h6>
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">Complaint:</label>
                                                        <p class="mb-2">{{ $followup->followup_complaint ?? 'No complaint recorded.' }}</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">Treatment:</label>
                                                        <p class="mb-2">{{ $followup->followup_treatment ?? 'No treatment recorded.' }}</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">Notes:</label>
                                                        <p class="mb-0">{{ $followup->followup_notes ?? 'No notes recorded.' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit-followup-modal-{{ $followup->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Follow-up - {{ $followup->visit_date ? $followup->visit_date->format('M d, Y') : $followup->created_at->format('M d, Y') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('app.antenatal-records.update', $followup->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="visit_type" value="followup">
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <!-- Visit Date -->
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="edit_visit_date_{{ $followup->id }}">Visit Date</label>
                                                        <input type="date" id="edit_visit_date_{{ $followup->id }}" name="visit_date" class="form-control" value="{{ $followup->visit_date ? $followup->visit_date->format('Y-m-d') : $followup->created_at->format('Y-m-d') }}">
                                                    </div>

                                                    <!-- Physical Examination Section -->
                                                    <div class="col-12">
                                                        <h6 class="text-primary mt-3 mb-3">Physical Examination</h6>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label" for="edit_height_of_fundus_{{ $followup->id }}">Height of Fundus</label>
                                                        <input type="text" id="edit_height_of_fundus_{{ $followup->id }}" name="height_of_fundus" class="form-control" value="{{ $followup->height_of_fundus }}" placeholder="e.g., 28 cm">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label" for="edit_presentation_and_position_{{ $followup->id }}">Presentation and Position</label>
                                                        <input type="text" id="edit_presentation_and_position_{{ $followup->id }}" name="presentation_and_position" class="form-control" value="{{ $followup->presentation_and_position }}" placeholder="e.g., Vertex, LOA">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label" for="edit_fetal_heart_{{ $followup->id }}">Fetal Heart</label>
                                                        <input type="text" id="edit_fetal_heart_{{ $followup->id }}" name="fetal_heart" class="form-control" value="{{ $followup->fetal_heart }}" placeholder="e.g., 140 bpm, regular">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label" for="edit_urine_{{ $followup->id }}">Urine</label>
                                                        <select id="edit_urine_{{ $followup->id }}" name="urine" class="form-select">
                                                            <option value="">Select...</option>
                                                            <option value="Normal" {{ $followup->urine === 'Normal' ? 'selected' : '' }}>Normal</option>
                                                            <option value="Protein +" {{ $followup->urine === 'Protein +' ? 'selected' : '' }}>Protein +</option>
                                                            <option value="Protein ++" {{ $followup->urine === 'Protein ++' ? 'selected' : '' }}>Protein ++</option>
                                                            <option value="Protein +++" {{ $followup->urine === 'Protein +++' ? 'selected' : '' }}>Protein +++</option>
                                                            <option value="Sugar +" {{ $followup->urine === 'Sugar +' ? 'selected' : '' }}>Sugar +</option>
                                                            <option value="Sugar ++" {{ $followup->urine === 'Sugar ++' ? 'selected' : '' }}>Sugar ++</option>
                                                            <option value="Sugar +++" {{ $followup->urine === 'Sugar +++' ? 'selected' : '' }}>Sugar +++</option>
                                                            <option value="Blood +" {{ $followup->urine === 'Blood +' ? 'selected' : '' }}>Blood +</option>
                                                            <option value="Blood ++" {{ $followup->urine === 'Blood ++' ? 'selected' : '' }}>Blood ++</option>
                                                            <option value="Blood +++" {{ $followup->urine === 'Blood +++' ? 'selected' : '' }}>Blood +++</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label" for="edit_blood_pressure_{{ $followup->id }}">Blood Pressure</label>
                                                        <input type="text" id="edit_blood_pressure_{{ $followup->id }}" name="blood_pressure" class="form-control" value="{{ $followup->blood_pressure }}" placeholder="e.g., 120/80 mmHg">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label" for="edit_weight_{{ $followup->id }}">Weight (kg)</label>
                                                        <input type="number" id="edit_weight_{{ $followup->id }}" name="weight" class="form-control" step="0.1" min="0" max="999.99" value="{{ $followup->weight }}" placeholder="e.g., 65.5">
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="form-label" for="edit_edema_{{ $followup->id }}">Edema</label>
                                                        <select id="edit_edema_{{ $followup->id }}" name="edema" class="form-select">
                                                            <option value="">Select...</option>
                                                            <option value="None" {{ $followup->edema === 'None' ? 'selected' : '' }}>None</option>
                                                            <option value="Mild" {{ $followup->edema === 'Mild' ? 'selected' : '' }}>Mild</option>
                                                            <option value="Moderate" {{ $followup->edema === 'Moderate' ? 'selected' : '' }}>Moderate</option>
                                                            <option value="Severe" {{ $followup->edema === 'Severe' ? 'selected' : '' }}>Severe</option>
                                                            <option value="Pitting" {{ $followup->edema === 'Pitting' ? 'selected' : '' }}>Pitting</option>
                                                            <option value="Non-pitting" {{ $followup->edema === 'Non-pitting' ? 'selected' : '' }}>Non-pitting</option>
                                                        </select>
                                                    </div>

                                                    <!-- Clinical Notes Section -->
                                                    <div class="col-12">
                                                        <h6 class="text-primary mt-3 mb-3">Clinical Notes</h6>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="form-label" for="edit_followup_complaint_{{ $followup->id }}">Complaint</label>
                                                        <textarea id="edit_followup_complaint_{{ $followup->id }}" name="followup_complaint" class="form-control" rows="3" placeholder="Patient's complaints or symptoms...">{{ $followup->followup_complaint }}</textarea>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="form-label" for="edit_followup_treatment_{{ $followup->id }}">Treatment Plan</label>
                                                        <textarea id="edit_followup_treatment_{{ $followup->id }}" name="followup_treatment" class="form-control" rows="3" placeholder="Treatment plan and recommendations...">{{ $followup->followup_treatment }}</textarea>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="form-label" for="edit_followup_notes_{{ $followup->id }}">Notes</label>
                                                        <textarea id="edit_followup_notes_{{ $followup->id }}" name="followup_notes" class="form-control" rows="3" placeholder="Additional notes and observations...">{{ $followup->followup_notes }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update Follow-up Record</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No follow-up records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($followups->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Showing {{ $followups->firstItem() }} to {{ $followups->lastItem() }} of {{ $followups->total() }} entries
            </div>
            <div>
                {{ $followups->links() }}
            </div>
        </div>
    @endif
</div>
