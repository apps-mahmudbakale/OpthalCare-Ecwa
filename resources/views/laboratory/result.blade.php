<div class="text-center mb-4">
    <h6 class="mb-2">
        {{ \App\Models\Laboratory::find($request->test_id)->name }} Result for
        {{ \App\Models\Patient::find($request->patient_id)->user->firstname }}
        {{ \App\Models\Patient::find($request->patient_id)->user->lastname }}
    </h6>
</div>

<form method="post" action="{{ route('app.lab.add.result') }}" class="row g-3" id="lab-result-form">
    @csrf

    <div class="col-12 col-md-12">
        <div class="alert alert-primary d-flex align-items-center">
            <span class="alert-icon text-primary me-2">
                <i class="ti ti-info-circle ti-xs"></i>
            </span>
            <p class="mt-3 ml-5">{{ $request->request_note }}</p>
        </div>

        <label class="form-label">Result</label>
        <input type="hidden" name="patient_id" value="{{ $request->patient_id }}">
        <input type="hidden" name="lab_id" value="{{ $request->id }}">
        <input type="hidden" name="lab_test_id" value="{{ $labTest->id }}">
        <input type="hidden" name="lab_template_id" value="{{ $template->id }}">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Parameter</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($parameters as $item)
                    <tr>
                        <td>{{ $item->parameter->name }}</td>
                        <td>
                            <input type="text" name="items[{{ $item->id }}]" class="form-control"
                                placeholder="{{ $item->parameter->name }}" required>
                            <small><span class="form-text text-muted">{{ $item->reference }}</span></small>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center text-danger">
                            No parameters configured for this lab test template. Please contact admin to configure "{{ $labTest->template ? $labTest->template->name : 'Template' }}" items.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="form-group">
            <label>Pathologist Comment</label>
            <textarea name="pathologist_comments" class="form-control"></textarea>
        </div>
    </div>

    <div class="col-12 col-md-12">
        <label class="form-label">Upload Image (Optional)</label>
        <input type="hidden" id="image" name="image">
        <input type="file" id="image-upload" class="form-control" accept="image/*">
        <small class="text-muted">Accepted formats: PNG, JPG, JPEG (Max 5MB)</small>
        <div id="image-preview" class="mt-2" style="display: none;">
            <img id="preview-img" src="" alt="Uploaded image" style="max-width: 100%; max-height: 300px;">
        </div>
    </div>

    <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
    </div>
</form>

<!-- Scripts -->
<script>
    jQuery(document).ready(function($) {
        // Handle image upload
        $('#image-upload').on('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const validTypes = ['image/png', 'image/jpeg', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid File',
                        text: 'Please upload a PNG, JPG, or JPEG image.',
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
                        timer: 2000
                    });
                    $(this).val('');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const base64Data = e.target.result;
                    $('#image').val(base64Data);
                    $('#preview-img').attr('src', base64Data);
                    $('#image-preview').show();
                };
                reader.readAsDataURL(file);
            }
        });

        // Handle form submission
        $('#lab-result-form').submit(function(event) {
            event.preventDefault();

            // Clone and populate result-html with values
            var resultHTML = $('#result-html').clone();
            resultHTML.find('input, textarea, select').each(function() {
                const $el = $(this);
                const value = $el.val();

                if ($el.is('textarea')) {
                    $el.text(value); // ✅ set content inside <textarea></textarea>
                } else if ($el.is(':checkbox') || $el.is(':radio')) {
                    if ($el.prop('checked')) {
                        $el.attr('checked', 'checked');
                    } else {
                        $el.removeAttr('checked');
                    }
                } else {
                    $el.attr('value', value);
                }
            });

            // Store the HTML in hidden input
            $('#result_html').val(resultHTML.html());

            // Serialize form and send via AJAX
            const formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Lab result submitted successfully!',
                        timer: 1500
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Submission failed: ' + xhr.statusText
                    });
                }
            });
        });

    });
</script>
