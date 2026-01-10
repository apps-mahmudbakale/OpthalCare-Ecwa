<h2 class="text-center">New Optical Request</h2>
<form action="{{route('app.opticals.store')}}" method="post">
  @csrf
  <!-- Search Input for Patients -->
  <div class="form-group">
    <div class="form-label-group">
      <input type="text" id="patient-search" class="form-control" placeholder="Search for patients...">
      <label for="patient-search">Search for Patients</label>
    </div>
  </div>

  <!-- Results Container for Patients -->
  <div id="patient-results" class="results-container" style="border: 1px solid #ccc; max-height: 200px; overflow-y: auto; display: none;">
    <!-- Patient results will be populated here -->
  </div>

  <!-- Hidden Input for Selected Patient ID -->
  <input type="hidden" name="patient_id" id="patient-id">
  <div id="result"></div>


  <div id="services-container">
    <div class="service-row mb-3 border p-3 rounded">
      <div class="d-flex justify-content-between align-items-center mb-2">
         <h6 class="m-0 text-muted">Service Item</h6>
         <button type="button" class="btn btn-danger btn-sm remove-row" style="display: none;">&times; Remove</button>
      </div>
      <div class="form-group">
        <div class="form-label-group">
          <select name="service_id[]" class="custom-select service-select" required="required">
            <option value="">Choose a service...</option> <!-- Default option -->
            @foreach($opticals as $optical)
            <option value="{{$optical->id}}">{{$optical->name}}</option>
            @endforeach
          </select>
          <label>Service</label>
        </div>
      </div>
      <div class="form-group">
        <div class="form-label-group">
          <textarea rows="2" name="comments[]" class="form-control" placeholder="Comments"></textarea>
          <label>Comment</label>
        </div>
      </div>
    </div>
  </div>

  <div class="mb-3 text-end">
    <button type="button" id="add-row" class="btn btn-success btn-sm">+ Add Another Service</button>
  </div>

  <!-- Submit and Reset buttons -->
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
  </div>
</form>

<!-- jQuery Script -->
<script>
  $(document).ready(function() {
    // Function to handle showing/hiding remove buttons
    function updateRemoveButtons() {
      const rows = $('.service-row');
      if (rows.length > 1) {
        $('.remove-row').show();
      } else {
        $('.remove-row').hide();
      }
    }

    // Add new row
    $('#add-row').click(function() {
      const newRow = $('.service-row:first').clone();
      newRow.find('input, select, textarea').val(''); // Clear values
      newRow.find('.remove-row').show(); // Ensure remove button is visible
      $('#services-container').append(newRow);
      updateRemoveButtons();
    });

    // Remove row
    $(document).on('click', '.remove-row', function() {
      if ($('.service-row').length > 1) {
        $(this).closest('.service-row').remove();
        updateRemoveButtons();
      }
    });

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

    // We removed the generic '#service-category' change event as it seemed unused or for a different context not present in the simplified view. 
    // If dynamic loading of services based on category is needed, it should be adapted to the repeater structure.
    // For now, focusing on the repeater logic for the existing static list of opticals.

  });
</script>
