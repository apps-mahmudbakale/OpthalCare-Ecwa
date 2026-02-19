<!-- Edit Diagnosis Modal -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">Update Diagnosis for {{ $diagnosis->patient->user->firstname }} {{ $diagnosis->patient->user->lastname }}</h3>
        </div>

        <!-- Specialty Toggle -->
        <div class="col-12 mb-4 d-flex justify-content-center">
            <div class="btn-group" role="group" aria-label="Specialty Toggle">
                <input type="radio" class="btn-check" name="specialty" id="specialty-ophth" value="Ophthalmology" {{ $diagnosis->specialty == 'Ophthalmology' ? 'checked' : '' }}>
                <label class="btn btn-outline-primary" for="specialty-ophth">Ophthalmology</label>

                <input type="radio" class="btn-check" name="specialty" id="specialty-gynae" value="Gynaecology" {{ $diagnosis->specialty == 'Gynaecology' ? 'checked' : '' }}>
                <label class="btn btn-outline-primary" for="specialty-gynae">Gynaecology</label>
            </div>
        </div>

        <!-- Tab Headings -->
        <ul class="nav nav-pills mb-3 justify-content-center" id="step-tabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="step1-tab" data-bs-toggle="pill" data-bs-target="#step1" type="button" role="tab" aria-controls="step1" aria-selected="true">History</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="step2-tab" data-bs-toggle="pill" data-bs-target="#step2" type="button" role="tab" aria-controls="step2" aria-selected="false">Examination</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="step3-tab" data-bs-toggle="pill" data-bs-target="#step3" type="button" role="tab" aria-controls="step3" aria-selected="false">Disability</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="step4-tab" data-bs-toggle="pill" data-bs-target="#step4" type="button" role="tab" aria-controls="step4" aria-selected="false">Case Description</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="step5-tab" data-bs-toggle="pill" data-bs-target="#step5" type="button" role="tab" aria-controls="step5" aria-selected="false">Treatment</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="step6-tab" data-bs-toggle="pill" data-bs-target="#step6" type="button" role="tab" aria-controls="step6" aria-selected="false">Sketch/Draw</button>
          </li>
        </ul>

        <!-- Multi-step Form -->
        <form id="diagnosis-form" action="{{ route('app.diagnosis.update', $diagnosis->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="tab-content">
            <!-- Step 1: History -->
            <div class="tab-pane fade show active" id="step1" role="tabpanel" aria-labelledby="step1-tab">
              <div class="col-12 col-md-12">
                <label class="form-label" for="history">History</label>
                <textarea name="history" id="history" rows="10" required class="form-control">{!! $diagnosis->history !!}</textarea>
              </div>
            </div>

            <!-- Step 2: Examination -->
            <div class="tab-pane fade" id="step2" role="tabpanel" aria-labelledby="step2-tab">
              <div id="eye-examination" style="{{ $diagnosis->specialty == 'Gynaecology' ? 'display: none;' : '' }}">
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
                    <td><input type="text" value="{{ old('uncorrected_right', $diagnosis->uncorrected_right) }}" name="uncorrected_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('uncorrected_left', $diagnosis->uncorrected_left) }}" name="uncorrected_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">PIN HOLE</td>
                    <td><input type="text" value="{{ old('pinhole_right', $diagnosis->pinhole_right) }}" name="pinhole_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('pinhole_left', $diagnosis->pinhole_left) }}" name="pinhole_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">VA WITH GLASSES</td>
                    <td><input type="text" value="{{ old('va_glass_right', $diagnosis->va_glass_right) }}" name="va_glass_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('va_glass_left', $diagnosis->va_glass_left) }}" name="va_glass_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">NEAR VISION</td>
                    <td><input type="text" value="{{ old('near_vision_right', $diagnosis->near_vision_right) }}" name="near_vision_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('near_vision_left', $diagnosis->near_vision_left) }}" name="near_vision_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">LID</td>
                    <td><input type="text" value="{{ old('lid_right', $diagnosis->lid_right) }}" name="lid_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('lid_left', $diagnosis->lid_left) }}" name="lid_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">GLOBE</td>
                    <td><input type="text" value="{{ old('globe_right', $diagnosis->globe_right) }}" name="globe_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('globe_left', $diagnosis->globe_left) }}" name="globe_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">EOMM</td>
                    <td><input type="text" value="{{ old('eomm_right', $diagnosis->eomm_right) }}" name="eomm_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('eomm_left', $diagnosis->eomm_left) }}" name="eomm_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">CONJUNCTIVA</td>
                    <td><input type="text" value="{{ old('conjuctiva_right', $diagnosis->conjuctiva_right) }}" name="conjuctiva_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('conjuctiva_left', $diagnosis->conjuctiva_left) }}" name="conjuctiva_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">CORNEA</td>
                    <td><input type="text" value="{{ old('cornea_right', $diagnosis->cornea_right) }}" name="cornea_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('cornea_left', $diagnosis->cornea_left) }}" name="cornea_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">ANTERIOR CHA</td>
                    <td><input type="text" value="{{ old('anterior_cha_right', $diagnosis->anterior_cha_right) }}" name="anterior_cha_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('anterior_cha_left', $diagnosis->anterior_cha_left) }}" name="anterior_cha_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">IRIS</td>
                    <td><input type="text" value="{{ old('iris_right', $diagnosis->iris_right) }}" name="iris_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('iris_left', $diagnosis->iris_left) }}" name="iris_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">PUPIL</td>
                    <td><input type="text" value="{{ old('pupil_right', $diagnosis->pupil_right) }}" name="pupil_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('pupil_left', $diagnosis->pupil_left) }}" name="pupil_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">LENS</td>
                    <td><input type="text" value="{{ old('lens_right', $diagnosis->lens_right) }}" name="lens_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('lens_left', $diagnosis->lens_left) }}" name="lens_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">IOP</td>
                    <td><input type="text" value="{{ old('iop_right', $diagnosis->iop_right) }}" name="iop_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('iop_left', $diagnosis->iop_left) }}" name="iop_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">VITREOUS</td>
                    <td><input type="text" value="{{ old('vitreous_right', $diagnosis->vitreous_right) }}" name="vitreous_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('vitreous_left', $diagnosis->vitreous_left) }}" name="vitreous_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">DISC</td>
                    <td><input type="text" value="{{ old('disc_right', $diagnosis->disc_right) }}" name="disc_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('disc_left', $diagnosis->disc_left) }}" name="disc_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">VCDR</td>
                    <td><input type="text" value="{{ old('vcdr_right', $diagnosis->vcdr_right) }}" name="vcdr_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('vcdr_left', $diagnosis->vcdr_left) }}" name="vcdr_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">MACULA</td>
                    <td><input type="text" value="{{ old('macula_right', $diagnosis->macula_right) }}" name="macula_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('macula_left', $diagnosis->macula_left) }}" name="macula_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">RETINA</td>
                    <td><input type="text" value="{{ old('retina_right', $diagnosis->retina_right) }}" name="retina_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('retina_left', $diagnosis->retina_left) }}" name="retina_left" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="70%">VESSELS</td>
                    <td><input type="text" value="{{ old('vessels_right', $diagnosis->vessels_right) }}" name="vessels_right" class="form-control"></td>
                    <td><input type="text" value="{{ old('vessels_left', $diagnosis->vessels_left) }}" name="vessels_left" class="form-control"></td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <div id="gynae-examination" style="{{ $diagnosis->specialty == 'Gynaecology' ? '' : 'display: none;' }}">
                <div class="mb-4">
                  <h4 class="fw-bold border-bottom pb-2"><i class="fas fa-baby-carriage me-2"></i>Gynaecology Examination</h4>
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
                        <input type="date" name="lmp" id="lmp-date" value="{{ old('lmp', $diagnosis->lmp) }}" class="form-control border-primary">
                      </div>
                      <div class="col-md-4 mb-3">
                        <label class="form-label">EDD (Estimated Due Date)</label>
                        <input type="date" name="edd" id="edd-date" value="{{ old('edd', $diagnosis->edd) }}" class="form-control bg-light" readonly>
                      </div>
                      <div class="col-md-4 mb-3">
                        <label class="form-label">Gestational Age (GA)</label>
                        <input type="text" name="ga" id="ga-value" value="{{ old('ga', $diagnosis->ga) }}" class="form-control bg-light" readonly>
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
                        <label class="form-label">Gravidity</label>
                        <input type="number" name="gravidity" value="{{ old('gravidity', $diagnosis->gravidity) }}" class="form-control" placeholder="0">
                      </div>
                      <div class="col-md-3 mb-3">
                        <label class="form-label">Parity</label>
                        <input type="number" name="parity" value="{{ old('parity', $diagnosis->parity) }}" class="form-control" placeholder="0">
                      </div>
                      <div class="col-md-6 mb-3">
                        <label class="form-label">Last Delivery Date</label>
                        <input type="date" name="last_delivery_date" value="{{ old('last_delivery_date', $diagnosis->last_delivery_date) }}" class="form-control">
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
                        <textarea name="menstrual_history" class="form-control" rows="2" placeholder="Describe menstrual cycle, flow, etc...">{{ old('menstrual_history', $diagnosis->menstrual_history) }}</textarea>
                      </div>
                      <div class="col-12 mb-3">
                        <label class="form-label">Pelvic Examination</label>
                        <textarea name="pelvic_examination" class="form-control" rows="2" placeholder="Detailed pelvic examination findings...">{{ old('pelvic_examination', $diagnosis->pelvic_examination) }}</textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Step 3: Disability -->
            <div class="tab-pane fade" id="step3" role="tabpanel" aria-labelledby="step3-tab">
              <div class="col-12 col-md-12">
                <label class="form-label" for="patient_id">Patient</label>
                <input type="text" class="form-control" id="patient_id"
                       value="{{ $diagnosis->patient->user->firstname }} {{ $diagnosis->patient->middlename }} {{ $diagnosis->patient->user->lastname }}"
                       readonly disabled>
                <input type="hidden" name="patient_id" value="{{ $diagnosis->patient->id }}">
              </div>
              <div class="col-12">
                <label class="form-label" for="disability">Type of Disability</label>
                <select name="disability" id="disability" class="form-control">
                  <option value="Visual" {{ $diagnosis->disability === 'Visual' ? 'selected' : '' }}>Visual</option>
                  <option value="Hearing" {{ $diagnosis->disability === 'Hearing' ? 'selected' : '' }}>Hearing</option>
                  <option value="Physical" {{ $diagnosis->disability === 'Physical' ? 'selected' : '' }}>Physical</option>
                  <option value="Intellectual" {{ $diagnosis->disability === 'Intellectual' ? 'selected' : '' }}>Intellectual</option>
                  <option value="Mental" {{ $diagnosis->disability === 'Mental' ? 'selected' : '' }}>Mental</option>
                  <option value="Multiple" {{ $diagnosis->disability === 'Multiple' ? 'selected' : '' }}>Multiple</option>
                  <option value="None" {{ $diagnosis->disability === 'None' ? 'selected' : '' }}>None</option>
                </select>
              </div>
            </div>

            <!-- Step 4: Case Description -->
            <div class="tab-pane fade" id="step4" role="tabpanel" aria-labelledby="step4-tab">
              <div class="col-12">
                <label class="form-label" for="select-icd">Case Description (ICD-10)</label>
                <select id="select-icd" name="icd_id" class="form-control">
                  @foreach (\App\Models\ICD10::all() as $icd)
                  <option value="{{ $icd->id }}" {{ $diagnosis->icd_id === $icd->id ? 'selected' : '' }}>
                    ({{ $icd->number }}) {{ $icd->name }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>

            <!-- Step 5: Treatment -->
            <div class="tab-pane fade" id="step5" role="tabpanel" aria-labelledby="step5-tab">
              <div class="col-12 col-md-12">
                <label class="form-label" for="assessment">Assessment</label>
                <textarea name="assessment" id="assessment" cols="5" rows="3" class="form-control">{{ old('assessment', $diagnosis->assessment) }}</textarea>
              </div>
              <div class="col-12 col-md-12">
                <label class="form-label" for="treatment">Treatment Plan</label>
                <textarea name="treatment" id="treatment" cols="5" rows="3" class="form-control">{{ old('treatment', $diagnosis->treatment) }}</textarea>
              </div>
              <div class="col-12 col-md-12">
                <label class="form-label" for="editor">Additional Information</label>
                <textarea name="comments" id="editor" class="form-control" rows="5" placeholder="Type Comments here...">{{ old('comments', $diagnosis->comments) }}</textarea>
              </div>
            </div>

            <!-- Step 6: Sketch/Draw -->
            <div class="tab-pane fade" id="step6" role="tabpanel" aria-labelledby="step6-tab">
              <input type="hidden" id="sketch" name="sketch" value="{{ old('sketch', $diagnosis->sketch) }}">
              <div class="col-12 col-md-12">
                <h4>Sketch or Upload</h4>
                <div class="mb-3">
                  <label class="form-label" for="drawing">Draw a sketch:</label>
                  <iframe id="drawing" class="col-md-12" style="height: 500px;"
                          src="{{ route('app.patient.draw', $diagnosis->patient->id) }}">Your browser isn't compatible</iframe>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="sketch-upload">Or upload an image:</label>
                  <input type="file" id="sketch-upload" class="form-control" accept="image/*">
                  <small class="text-muted">Accepted formats: PNG, JPG, JPEG (Max 5MB)</small>
                </div>
                <div id="sketch-preview" class="mt-2" style="{{ $diagnosis->sketch ? '' : 'display: none;' }}">
                  <img id="preview-img" src="{{ $diagnosis->sketch ?? '' }}" alt="Uploaded sketch" style="max-width: 100%; max-height: 300px;">
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Footer with Submit Button -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update Diagnosis</button>
          </div>
        </form>


<!--/ Edit Diagnosis Modal -->

<!-- Modal-Specific Scripts -->
<script>
  jQuery(document).ready(function($) {
    // Initialize Select2 for ICD-10 codes
    $('#select-icd').select2({
      dropdownParent: $('#global-modal'),
      placeholder: 'Select an ICD-10 code',
      allowClear: true
    });

    // Specialty Toggler
    $('input[name="specialty"]').on('change', function() {
        if ($(this).val() === 'Gynaecology') {
            $('#eye-examination').hide();
            $('#gynae-examination').show();
        } else {
            $('#eye-examination').show();
            $('#gynae-examination').hide();
        }
    });

    // Initialize EasyEditor for the comments textarea
    try {
        if ($('#editor').length) {
            new EasyEditor('#editor');
        }
    } catch (e) {
        console.error('EasyEditor initialization failed:', e);
    }

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
        if (file.size > 5 * 1024 * 1024) {
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
      };
      reader.onerror = function() {
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
      event.preventDefault();

      if (!$('#sketch').val()) {
        try {
          var base64 = $('#drawing').contents().find('#sketch').val();
          $('#sketch').val(base64 || '');
        } catch (e) {
          console.warn('Error retrieving sketch data:', e);
          $('#sketch').val('');
        }
      }

      var formData = $(this).serialize();
      $.ajax({
        url: $(this).attr('action'),
        type: 'POST', // Laravel handles PUT via _method
        data: formData,
        success: function(response) {
          try {
            $('#new-diagnosis-modal').modal('hide');
          } catch (e) {
            console.warn('Bootstrap modal hide failed:', e);
            var modal = document.getElementById('new-diagnosis-modal');
            if (modal) {
              modal.classList.remove('show');
              modal.style.display = 'none';
              document.body.classList.remove('modal-open');
              var backdrop = document.querySelector('.modal-backdrop');
              if (backdrop) backdrop.remove();
            }
          }

          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Diagnosis updated successfully!',
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            location.reload();
          });
        },
        error: function(xhr) {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'An error occurred: ' + (xhr.responseJSON?.message || xhr.statusText || 'Unknown error'),
            showConfirmButton: false,
            timer: 2000
          });
        }
      });
    });
  });
</script>
