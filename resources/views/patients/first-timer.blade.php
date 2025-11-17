<h2 class="text-center">Patient First Time</h2>
<form id="patientForm" method="POST" class="row">
    @csrf
    <div class="col-md-12">
        <label for="">First Name</label>
        <input type="text" name="first_name" class="form-control">
    </div>
    <div class="col-md-12">
        <label for="">Last Name</label>
        <input type="text" name="last_name" class="form-control">
    </div>
    <div class="col-md-12">
        <label class="form-label" for="middlename">Middle Name</label>
        <input type="text" name="middle_name" id="middlename" class="form-control" placeholder="Middle Name">
    </div>
    <div class="col-12 text-center">
        <br>
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
    </div>
</form>

<!-- jQuery for form submission -->
<script>
    $(document).ready(function() {
        $('#patientForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Gather form data
            var formData = $(this).serialize();

            // AJAX request to submit the form
            $.ajax({
                type: 'POST',
                url: 'patient-first-timer', // Replace with your actual route
                data: formData,
                success: function(response) {
                    // Assuming the response contains patient_id and patient_name
                    var patientId = response.id;
                    var patientName = response.patient_name;

                    // Base64 encode the patientId and patientName
                    var encryptedPatientId = btoa(patientId);
                    var encryptedPatientName = btoa(patientName);

                    // Redirect to the Laravel route 'cashpoints.new-patient'
                    var route = "cashpoints/new-patient/"; // Your Laravel route

                    // Construct the full URL with encrypted query parameters
                    window.location.href = route + encryptedPatientId;
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    alert('An error occurred: ' + error);
                }
            });
        });
    });
</script>
