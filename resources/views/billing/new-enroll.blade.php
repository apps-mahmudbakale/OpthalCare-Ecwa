@extends('layouts/layoutMaster')

@section('title', 'Billings')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/fullcalendar/fullcalendar.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-calendar.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/fullcalendar/fullcalendar.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('assets/js/app-calendar-events.js') }}"></script>
<script src="{{ asset('assets/js/app-calendar.js') }}"></script>
@endsection

@section('content')
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="card">
  <div class="px-3 py-4">
    <h2 class="text-center">New Billing</h2>
    <form action="{{route('app.cashpoints.bill-patient')}}" method="post">
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
          <input type="text" id="patient-search" readonly disabled value="{{ucfirst($tempPatient->first_name)}} {{ucfirst($tempPatient->last_name)}}" class="form-control" placeholder="Search for patients...">
        </div>
      </div>
      <!-- Hidden Input for Selected Patient ID -->
      <input type="hidden" name="patient_id" value="{{$tempPatient->id}}" id="patient-id">

      <!-- Submit and Reset buttons -->
      <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </form>

    <!-- jQuery Script -->
    <script>
      $(document).ready(function() {
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
      });
    </script>
  </div>
</div>
@endsection
