<!-- Edit User Modal -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<div wire:ignore.self class="modal fade" id="new-diagnosis-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">New Diagnosis for
                        {{ \App\Models\Patient::find(request()->route()->patient->id)->user->firstname }}
                        {{ \App\Models\Patient::find(request()->route()->patient->id)->user->lastname }}
                    </h3>
                </div>

                <!-- Specialty Toggle -->
                <div class="col-12 mb-4 d-flex justify-content-center">
                    <div class="col-md-12">
                        <label for="specialty-select" class="form-label text-center d-block">Select Specialty</label>
                        <select class="form-select" id="specialty-select" name="specialty">
                            <option value="Ophthalmology" selected>Ophthalmology</option>
                            <option value="Gynaecology">Gynaecology</option>
                            <option value="Obstetrics">Obstetrics</option>
                            <option value="Antenatal">Antenatal</option>
                            <option value="Family Planning">Family Planning</option>
                            <option value="General Out-Patient">General Out-Patient</option>
                        </select>
                    </div>
                </div>

                <!-- Tab Headings -->
                <ul class="nav nav-pills mb-3 justify-content-center" id="step-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="step1-tab" data-bs-toggle="pill" data-bs-target="#step1"
                            type="button">History</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="step2-tab" data-bs-toggle="pill" data-bs-target="#step2"
                            type="button">Examination</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="step3-tab" data-bs-toggle="pill" data-bs-target="#step3"
                            type="button">Disability</button>
                    </li>
{{--                    <li class="nav-item" role="presentation">--}}
{{--                        <button class="nav-link" id="step4-tab" data-bs-toggle="pill" data-bs-target="#step4"--}}
{{--                            type="button">Case Description</button>--}}
{{--                    </li>--}}
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="step5-tab" data-bs-toggle="pill" data-bs-target="#step5"
                            type="button">Treatment</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="step6-tab" data-bs-toggle="pill" data-bs-target="#step6"
                            type="button">Sketch/Draw</button>
                    </li>
                </ul>

                <!-- Multi-step Form -->
                <form id="diagnosis-form" action="{{ route('app.diagnosis.store') }}" method="POST">
                    @csrf

                    <div class="tab-content">
                        <!-- Step 1 -->
                        <div class="tab-pane fade show active" id="step1">
                            <div class="col-12 col-md-12">
                                <label class="form-label">History</label>
                                <textarea name="history" rows="10" required class="form-control"></textarea>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="tab-pane fade" id="step2">
                            <div id="eye-examination">
                                <h2>Eye Examination</h2>
                                <table class="table table-striped table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th></th>
                                            <th>(RE)</th>
                                            <th>(LE)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="70%">UNCORRECTED</td>
                                            <td><input type="text" name="uncorrected_right" class="form-control"></td>
                                            <td><input type="text" name="uncorrected_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">PIN HOLE</td>
                                            <td><input type="text" name="pinhole_right" class="form-control"></td>
                                            <td><input type="text" name="pinhole_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">VA WITH GLASSES</td>
                                            <td><input type="text" name="va_glass_right" class="form-control"></td>
                                            <td><input type="text" name="va_glass_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">NEAR VISION</td>
                                            <td><input type="text" name="near_vision_right" class="form-control"></td>
                                            <td><input type="text" name="near_vision_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">LID</td>
                                            <td><input type="text" name="lid_right" class="form-control"></td>
                                            <td><input type="text" name="lid_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">GLOBE</td>
                                            <td><input type="text" name="globe_right" class="form-control"></td>
                                            <td><input type="text" name="globe_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">EOMM</td>
                                            <td><input type="text" name="eomm_right" class="form-control"></td>
                                            <td><input type="text" name="eomm_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">CONJUCTIVA</td>
                                            <td><input type="text" name="conjuctiva_right" class="form-control"></td>
                                            <td><input type="text" name="conjuctiva_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">CORNEA</td>
                                            <td><input type="text" name="cornea_right" class="form-control"></td>
                                            <td><input type="text" name="cornea_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">ANTERIOR CHA</td>
                                            <td><input type="text" name="anterior_cha_right" class="form-control">
                                            </td>
                                            <td><input type="text" name="anterior_cha_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">IRIS</td>
                                            <td><input type="text" name="iris_right" class="form-control"></td>
                                            <td><input type="text" name="iris_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">PUPIL</td>
                                            <td><input type="text" name="pupil_right" class="form-control"></td>
                                            <td><input type="text" name="pupil_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">LENS</td>
                                            <td><input type="text" name="lens_right" class="form-control"></td>
                                            <td><input type="text" name="lens_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">IOP</td>
                                            <td><input type="text" name="iop_right" class="form-control"></td>
                                            <td><input type="text" name="iop_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">VITREOUS</td>
                                            <td><input type="text" name="vitreous_right" class="form-control"></td>
                                            <td><input type="text" name="vitreous_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">DISC</td>
                                            <td><input type="text" name="disc_right" class="form-control"></td>
                                            <td><input type="text" name="disc_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">VCDR</td>
                                            <td><input type="text" name="vcdr_right" class="form-control"></td>
                                            <td><input type="text" name="vcdr_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">MACULA</td>
                                            <td><input type="text" name="macula_right" class="form-control"></td>
                                            <td><input type="text" name="macula_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">RETINA</td>
                                            <td><input type="text" name="retina_right" class="form-control"></td>
                                            <td><input type="text" name="retina_left" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">VESSELS</td>
                                            <td><input type="text" name="vessels_right" class="form-control"></td>
                                            <td><input type="text" name="vessels_left" class="form-control"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="gynae-examination" style="display: none;">
                                <div class="mb-4">
                                    <h4 class="fw-bold border-bottom pb-2" id="specialized-exam-header"><i class="fas fa-baby-carriage me-2"></i>Gynaecology Examination</h4>
                                </div>

                                <!-- Section 1: Pregnancy Status -->
                                <div class="card border border-primary mb-3 shadow-none">
                                    <div class="card-header bg-label-primary py-2">
                                        <h5 class="card-title mb-0 small fw-bold text-uppercase">Pregnancy Overview</h5>
                                    </div>
                                    <div class="card-body pt-3 pb-1">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">LMP (Last Menstrual Period)</label>
                                                <input type="date" name="lmp" id="lmp-date" class="form-control border-primary">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">EDD (Estimated Due Date)</label>
                                                <input type="date" name="edd" id="edd-date" class="form-control bg-light" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Gestational Age (GA)</label>
                                                <input type="text" name="ga" id="ga-value" class="form-control bg-light" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: Obstetric History -->
                                <div class="card border border-info mb-3 shadow-none">
                                    <div class="card-header bg-label-info py-2">
                                        <h5 class="card-title mb-0 small fw-bold text-uppercase">Obstetric History</h5>
                                    </div>
                                    <div class="card-body pt-3 pb-1">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Gravidty</label>
                                                <input type="number" name="gravidity" class="form-control" placeholder="0">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Parity</label>
                                                <input type="number" name="parity" class="form-control" placeholder="0">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Last Delivery Date</label>
                                                <input type="date" name="last_delivery_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 3: Detailed Examination -->
                                <div class="card border border-secondary mb-3 shadow-none">
                                    <div class="card-header bg-label-secondary py-2">
                                        <h5 class="card-title mb-0 small fw-bold text-uppercase">Specialist Findings</h5>
                                    </div>
                                    <div class="card-body pt-3 pb-1">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Menstrual History</label>
                                                <textarea name="menstrual_history" class="form-control" rows="2" placeholder="Describe menstrual cycle, flow, etc..."></textarea>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Pelvic Examination</label>
                                                <textarea name="pelvic_examination" class="form-control" rows="2" placeholder="Detailed pelvic examination findings..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="col-12 col-md-12 mt-3">
                                 <h4 class="fw-bold border-bottom pb-2" id="general-exam-header">General Examination</h4>
                                 <textarea name="general_examination" id="" cols="5" rows="3" class="form-control" placeholder="General examination findings..."></textarea>
                             </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="tab-pane fade" id="step3">
                            <div class="col-12 col-md-12">
                                <label class="form-label">Patient</label>
                                <input type="text" class="form-control"
                                    value="{{ \App\Models\Patient::find(request()->route()->patient->id)->user->firstname . ' ' . \App\Models\Patient::find(request()->route()->patient->id)->middlename . ' ' . \App\Models\Patient::find(request()->route()->patient->id)->user->lastname }}"
                                    readonly disabled>
                                <input type="hidden" name="patient_id" class="form-control"
                                    value="{{ request()->route()->patient->id }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Type of Disability</label>
                                <select name="disability" class="form-control">
                                    <option>Visual</option>
                                    <option>Hearing</option>
                                    <option>Physical</option>
                                    <option>Intellectual</option>
                                    <option>Mental</option>
                                    <option>Multiple</option>
                                    <option>None</option>
                                </select>
                            </div>
                        </div>

                        <!-- Step 4 -->
{{--                        <div class="tab-pane fade" id="step4">--}}
{{--                            <div class="col-12">--}}
{{--                                <label class="form-label">Case Description</label>--}}
{{--                                <select id="select-icd" name="icd_id" class="form-control">--}}
{{--                                    @foreach (\App\Models\ICD10::all() as $icd)--}}
{{--                                        <option value="{{ $icd->id }}">({{ $icd->number }}) {{ $icd->name }}--}}
{{--                                        </option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <!-- Step 5 -->
                        <div class="tab-pane fade" id="step5">
                            <div class="col-12 col-md-12">
                                <label class="form-label" for="">Assessment</label>
                                <textarea name="assessment" id="" cols="5" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="col-12 col-md-12">
                                <label class="form-label" for="">Treatment Plan</label>
                                <textarea name="treatment" id="" cols="5" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="col-12 col-md-12">
                                <label class="form-label">Additional Information</label>
                                <textarea name="comments" id="editor" class="form-control" rows="5" placeholder="Type Comments here..."></textarea>
                            </div>
                        </div>

                        <!-- Step 6 -->
                        <div class="tab-pane fade" id="step6">
                            <input type="hidden" id="sketch" name="sketch">
                            <div class="col-12 col-md-12">
                                <h4>Sketch or Upload</h4>
                                <div class="mb-3">
                                    <label class="form-label">Draw a sketch:</label>
                                    <!-- <iframe id="drawing" class="col-md-12" style="height: 500px;"
                                        src="{{ route('app.patient.draw', request()->route()->patient->id) }}">Your
                                        browser isn't compatible</iframe> -->
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Or upload an image:</label>
                                    <input type="file" id="sketch-upload" class="form-control" accept="image/*">
                                    <small class="text-muted">Accepted formats: PNG - PNG, JPG, JPEG (Max 5MB)</small>
                                </div>
                                <div id="sketch-preview" class="mt-2" style="display: none;">
                                    <img id="preview-img" src="" alt="Uploaded sketch"
                                        style="max-width: 100%; max-height: 300px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer with Submit Button -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Edit User Modal -->

<script>
    jQuery(document).ready(function($) {
        // Initialize EasyEditor for the comments textarea
        try {
            if ($('#editor').length) {
                new EasyEditor('#editor');
            }
        } catch (e) {
            console.error('EasyEditor initialization failed:', e);
        }

        // Specialty Toggler
        $('#specialty-select').on('change', function() {
            const specialty = $(this).val();
            const gynaeRelated = ['Gynaecology', 'Obstetrics', 'Antenatal', 'Family Planning'];
            const header = $('#specialized-exam-header');
            const generalHeader = $('#general-exam-header');

            // Reset headers
            generalHeader.text('General Examination');

            if (gynaeRelated.includes(specialty)) {
                $('#eye-examination').hide();
                $('#gynae-examination').show();

                // Update Header Text and Icon
                let icon = 'fa-baby-carriage';
                if (specialty === 'Obstetrics') icon = 'fa-stethoscope';
                if (specialty === 'Antenatal') icon = 'fa-female';
                if (specialty === 'Family Planning') icon = 'fa-users';

                header.html(`<i class="fas ${icon} me-2"></i>${specialty} Examination`);
            } else if (specialty === 'Ophthalmology') {
                $('#eye-examination').show();
                $('#gynae-examination').hide();
            } else {
                // General Out-Patient or others
                $('#eye-examination').hide();
                $('#gynae-examination').hide();
                generalHeader.text(specialty + ' Examination');
            }
        });

        // EDD and GA Calculator
        $('#lmp-date').on('change', function() {
            const lmpValue = $(this).val();
            if (lmpValue) {
                const lmpDate = new Date(lmpValue);
                if (!isNaN(lmpDate.getTime())) {
                    // Calculate EDD (Naegele's rule: LMP + 9 months + 7 days)
                    const eddDate = new Date(lmpDate);
                    eddDate.setMonth(eddDate.getMonth() + 9);
                    eddDate.setDate(eddDate.getDate() + 7);
                    $('#edd-date').val(eddDate.toISOString().split('T')[0]);

                    // Calculate GA (Today - LMP)
                    const today = new Date();
                    const diffTime = Math.abs(today - lmpDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    const weeks = Math.floor(diffDays / 7);
                    const days = diffDays % 7;
                    $('#ga-value').val(`${weeks} Weeks ${days} Days`);
                }
            }
        });

        // Handle file upload for sketch
        $('#sketch-upload').on('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                // Validate file type and size
                const validTypes = ['image/png', 'image/jpeg', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid File',
                        text: 'Please upload a PNG, JPG, or JPEG image.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    $(this).val('');
                    return;
                }
                if (file.size > 5 * 1024 * 1024) { // 5MB limit
                    Swal.fire({
                        icon: 'error',
                        title: 'File Too Large',
                        text: 'Please upload an image smaller than 5MB.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    $(this).val('');
                    return;
                }

                // Check for existing sketch
                if ($('#sketch').val()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Overwrite Sketch?',
                        text: 'Uploading a file will replace the existing sketch. Continue?',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, upload',
                        cancelButtonText: 'No, keep sketch'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            processFile(file);
                        } else {
                            $(this).val('');
                        }
                    });
                } else {
                    processFile(file);
                }
            }
        });

        function processFile(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const base64Data = e.target.result;
                $('#sketch').val(base64Data);
                $('#preview-img').attr('src', base64Data);
                $('#sketch-preview').show();
                console.log('Uploaded file converted to base64:', base64Data);
            };
            reader.onerror = function() {
                console.error('Error reading file');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to read the uploaded file.',
                    showConfirmButton: false,
                    timer: 2000
                });
            };
            reader.readAsDataURL(file);
        }

        // Handle form submission
        $('#diagnosis-form').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get base64 sketch data from iframe if no file was uploaded
            if (!$('#sketch').val()) {
                try {
                    var base64 = $('#drawing').contents().find('#sketch').val();
                    $('#sketch').val(base64 || '');
                    console.log('Sketch data:', base64);
                } catch (e) {
                    console.error('Error retrieving sketch data:', e);
                    $('#sketch').val('');
                }
            }

            var formData = $(this).serialize(); // Serialize form data
            console.log('Form data:', formData); // Debug

            $.ajax({
                url: $(this).attr('action'), // Laravel route URL
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log('Success:', response);

                    // Try Bootstrap jQuery method first
                    try {
                        $('#new-diagnosis-modal').modal('hide');
                    } catch (e) {
                        console.error('Bootstrap modal hide failed:', e);
                        // Fallback to native JS
                        var modal = document.getElementById('new-diagnosis-modal');
                        if (modal) {
                            modal.classList.remove('show');
                            modal.style.display = 'none';
                            document.body.classList.remove('modal-open');
                            var backdrop = document.querySelector('.modal-backdrop');
                            if (backdrop) backdrop.remove();
                            location.reload();
                        }
                    }

                    // Show SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Diagnosis submitted successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while submitting the form: ' + (xhr
                            .statusText || 'Unknown error'),
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#select-icd').select2({
            dropdownParent: $('#new-diagnosis-modal')
        });
    });
</script>
