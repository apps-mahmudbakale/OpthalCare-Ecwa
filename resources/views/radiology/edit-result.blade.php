@trixassets
<div class="text-center mb-4">
  <h6 class="mb-2">
    Edit {{ \App\Models\Radiology::find($request->imaging_id)->name }} Result for
    {{ \App\Models\Patient::find($request->patient_id)->user->firstname }}
    {{ \App\Models\Patient::find($request->patient_id)->user->lastname }}
  </h6>
</div>

<form method="post" action="{{ route('app.radiology.update.result') }}" class="row g-3" id="radiology-result-form">
  @csrf

  <div class="col-12 col-md-12">
    <div class="alert alert-primary d-flex align-items-center">
      <span class="alert-icon text-primary me-2">
        <i class="ti ti-user ti-xs"></i>
      </span>
      <p class="mt-3 ml-5">{{ $request->request_note }}</p>
    </div>

    <input type="hidden" name="patient_id" value="{{ $request->patient_id }}">
    <input type="hidden" name="imaging_id" value="{{ $request->id }}">
    @trix($request->findings ?? \App\Models\RadiologyResult::class, 'result')
  </div>

  <!-- 🖼 Image Upload Section -->
  <div class="col-12 col-md-12">
    <label class="form-label">Update Image (Optional)</label>
    <input type="hidden" id="image" name="image">
    <input type="file" id="image-upload" class="form-control" accept="image/*">
    <small class="text-muted">Accepted formats: PNG, JPG, JPEG (Max 5MB)</small>
    <div id="image-preview" class="mt-2" style="{{ isset($request->findings) && $request->findings->image ? '' : 'display: none;' }}">
      <img id="preview-img" src="{{ isset($request->findings) ? $request->findings->image : '' }}" alt="Uploaded image" style="max-width: 100%; max-height: 300px;">
    </div>
  </div>

  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Update Result</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
  </div>
</form>
<script>
  // Handle Trix editor pre-population if empty
  document.addEventListener("trix-initialize", function(event) {
      var existingResult = {!! json_encode($request->findings->result ?? '') !!};
      if (existingResult && event.target.editor) {
          var editor = event.target.editor;
          // Only load if the editor is currently empty to avoid overwriting user input
          if (editor.getDocument().toString().trim() === "") {
              editor.loadHTML(existingResult);
          }
      }
  });

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
  });
</script>
