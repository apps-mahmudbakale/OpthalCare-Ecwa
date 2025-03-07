<h2>New Billing</h2>
<form action="{{route('app.billing.store')}}" method="post">
  @csrf
  <!-- Select for Service Categories -->
  <div class="form-group">
    <div class="form-label-group">
      <select name="service_category" class="custom-select" id="service-category" required="required">
        <option value="">Choose service category...</option>
        <option value="admissions">Admission</option>
        <option value="antenatal">Antenatal</option>
        <option value="consultations">Consultation</option>
        <option value="laboratory">Laboratory</option>
        <option value="procedure">Medical Procedure</option>
        <option value="pharmacy">Pharmacy</option>
        <option value="radiology">Radiology</option>
      </select>
      <label for="service-category">Service Category</label>
    </div>
  </div>

  <!-- Select for Services -->
  <div class="form-group">
    <div class="form-label-group">
      <select name="service_id" class="custom-select" id="service_id" required="required">
        <option value="">Choose a service...</option> <!-- Default option -->
      </select>
      <label for="service_id">Service</label>
    </div>
  </div>

  <!-- Search Input for Patients -->
  <div class="form-group">
    <div class="form-label-group">
      <input type="text" id="patient-search" class="form-control" placeholder="Search for patients...">
      <label for="patient-search">Search for Patients</label>
    </div>
    <button class="btn btn-success float-end mt-2" id="first-timer"
            data-request-url="{{ route('app.patients.first-timer') }}"
            data-toggle="modal" data-target="#global-modal">New Bill</button>
  </div>

  <!-- Results Container for Patients -->
  <div id="patient-results" class="results-container" style="border: 1px solid #ccc; max-height: 200px; overflow-y: auto; display: none;">
    <!-- Patient results will be populated here -->
  </div>

  <!-- Hidden Input for Selected Patient ID -->
  <input type="hidden" name="patient_id" id="patient-id">
  <div id="result"></div>

  <!-- Submit and Reset buttons -->
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
  </div>
</form>

<!-- jQuery Script -->
<script>
  $(document).ready(function() {
    // Fetch patient data from the API using jQuery
    $.ajax({
      url: '/api/patients',  // Replace with your actual API endpoint
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        const patients = data.map(item => {
          return {
            id: item.id,
            full_name: item.full_name.toLowerCase()  // Store full name in lowercase for case-insensitive search
          };
        });

        // Implement search functionality for patients
        $('#patient-search').on('input', function() {
          const searchTerm = $(this).val().toLowerCase();  // Get search term
          const $resultsContainer = $('#patient-results');
          $resultsContainer.empty();  // Clear current results

          const filteredPatients = patients.filter(item => item.full_name.includes(searchTerm));

          if (filteredPatients.length > 0) {
            filteredPatients.forEach(function(item) {
              const resultItem = $('<div></div>')
                .addClass('result-item')
                .text(item.full_name)
                .data('id', item.id)  // Store the patient ID in the div
                .css({
                  padding: '10px',
                  cursor: 'pointer',
                  borderBottom: '1px solid #ccc'
                })
                .hover(
                  function() {
                    $(this).css('background-color', '#f0f0f0');  // Highlight on hover
                  },
                  function() {
                    $(this).css('background-color', 'transparent');  // Remove highlight
                  }
                )
                .click(function() {
                  $('#patient-search').val($(this).text());  // Set the input value
                  $('#patient-id').val($(this).data('id'));  // Set the hidden input value to the patient ID
                  $resultsContainer.hide();  // Hide results
                });

              $resultsContainer.append(resultItem);  // Append result to the results container
            });
            $resultsContainer.show();  // Show the results container
          } else {
            $resultsContainer.hide();  // Hide if no results
          }
        });
      },
      error: function(xhr, status, error) {
        console.error('Error fetching patients:', error);
      }
    });

    // Change event for service category
    $('#service-category').change(function() {
      const selectedCategory = $(this).val(); // Get the selected value

      // Send the selected category to the API endpoint
      $.ajax({
        url: '/api/billservice', // Replace with your actual API endpoint
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ category: selectedCategory }), // Send the category in the request body
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
        },
        success: function(data) {
          console.log('API Response:', data); // Log the response to the console

          // Clear existing options in the service_id select
          $('#service_id').empty().append('<option value="">Choose a service...</option>'); // Reset select options

          if (data.error) {
            $('#service_id').append(`<option disabled>Error: ${data.error}</option>`); // Show error in options
          } else {
            // Assuming response is an array of results
            data.forEach(item => {
              // Check if ward exists and append accordingly
              if (item.ward) {
                $('#service_id').append(`<option value="${item.id}">${item.name} - ${item.ward.name}</option>`);
              } else {
                $('#service_id').append(`<option value="${item.id}">${item.name}</option>`);
              }
            });
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error:', textStatus, errorThrown); // Handle any errors
          alert('Error sending category!'); // Optional alert for error
        }
      });
    });
    $('#service_id').change(()=>{
      if($('#service_id option:selected').text() === 'Enrollment Fee'){

      }
    });
    $('#first-timer').on('click', function(e) {
      e.preventDefault(); // Prevent the default action

      var requestUrl = $(this).data('request-url');
      $.ajax({
        url: requestUrl,
        type: 'GET',
        success: function(response) {
          $('#global-modal .modal-body').html(response);
          $('#global-modal').modal('show');
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    });
  });
</script>
