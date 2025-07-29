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
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="step4-tab" data-bs-toggle="pill" data-bs-target="#step4"
                            type="button">Case Description</button>
                    </li>
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
                            <h2>Examination</h2>
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
                            <div class="col-12 col-md-12">
                                <label class="form-label" for="">General Examination</label>
                                <textarea name="general_examination" id="" cols="5" rows="3" class="form-control"></textarea>
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
                        <div class="tab-pane fade" id="step4">
                            <div class="col-12">
                                <label class="form-label">Case Description</label>
                                <select id="select-icd" name="icd_id" class="form-control">
                                    @foreach (\App\Models\ICD10::all() as $icd)
                                        <option value="{{ $icd->id }}">({{ $icd->number }}) {{ $icd->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

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
                                    <iframe id="drawing" class="col-md-12" style="height: 500px;"
                                        src="{{ route('app.patient.draw', request()->route()->patient->id) }}">Your
                                        browser isn't compatible</iframe>
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

<!-- Styles (Bootstrap CSS) -->
<!-- Scripts -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
</script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    jQuery(document).ready(function($) {
        // Initialize EasyEditor for the comments textarea
        try {
            new EasyEditor('#editor');
        } catch (e) {
            console.error('EasyEditor initialization failed:', e);
        }

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
