<div class="text-center mb-4">
  <h6 class="mb-2">{{ \App\Models\Laboratory::find($request->test_id)->name }} Result for {{ \App\Models\Patient::find($request->patient_id)->user->firstname }} {{ \App\Models\Patient::find($request->patient_id)->user->lastname }}</h6>
</div>
<form method="post" action="{{ route('app.lab.add.result') }}" class="row g-3" id="lab-result-form">
  @csrf
  <div class="col-12 col-md-12">
    <div class="alert alert-primary d-flex align-items-center">
        <span class="alert-icon text-primary me-2">
            <i class="ti ti-user ti-xs"></i>
        </span>
      <p class="mt-3 ml-5">{{ $request->request_note }}</p>
    </div>
    <label class="form-label">Result</label>
    <input type="hidden" name="patient_id" value="{{ $request->patient_id }}">
    <input type="hidden" name="lab_id" value="{{ $request->id }}">
    <textarea name="result" class="form-control" id="" cols="30" rows="10"></textarea>
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
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
  </div>
</form>

<!-- Scripts -->

<script>
  jQuery(document).ready(function($) {
    // Handle file upload for image
    $('#image-upload').on('change', function(event) {
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

        // Convert file to base64
        const reader = new FileReader();
        reader.onload = function(e) {
          const base64Data = e.target.result;
          $('#image').val(base64Data);
          $('#preview-img').attr('src', base64Data);
          $('#image-preview').show();
          console.log('Uploaded image converted to base64:', base64Data);
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
    });

    // Handle form submission
    $('#lab-result-form').submit(function(event) {
      event.preventDefault(); // Prevent default form submission

      var formData = $(this).serialize(); // Serialize form data
      console.log('Form data:', formData); // Debug

      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function(response) {
          console.log('Success:', response);
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Lab result submitted successfully!',
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            // Close modal if inside one
            const modalElement = $(this).closest('.modal')[0];
            if (modalElement && typeof bootstrap !== 'undefined') {
              const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
              modal.hide();
            } else {
              // Fallback
              if (modalElement) {
                modalElement.classList.remove('show');
                modalElement.style.display = 'none';
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
              }
              location.reload();
            }
          });
        },
        error: function(xhr, status, error) {
          console.error('Error:', xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'An error occurred while submitting the form: ' + (xhr.statusText || 'Unknown error'),
            showConfirmButton: false,
            timer: 2000
          });
        }
      });
    });
  });
</script>
