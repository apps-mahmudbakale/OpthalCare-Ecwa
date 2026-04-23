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
    
    <script>
      // Wait for Swal to be available
      function waitForSwal(callback) {
        if (typeof Swal !== 'undefined') {
          callback();
        } else {
          setTimeout(function() {
            waitForSwal(callback);
          }, 100);
        }
      }
      
      waitForSwal(function() {
        console.log('Swal is now loaded!');
        
        $(document).ready(function () {
          console.log('Document ready');
          const modal = $('#global-modal');

          // Handle "New Bill" and "Receive Payment" buttons
          $(document).on('click', '.new-bill-btn, .billing-show-btn', function (e) {
            e.preventDefault();
            let requestUrl = $(this).data('request-url');

            $.get(requestUrl)
              .done(response => {
                modal.find('.modal-body').html(response);
                modal.modal('show');
              })
              .fail(xhr => console.error(xhr.responseText));
          });

          // Handle "Cancel System Charge" button
          $(document).on('click', '.cancel-charge-btn', function (e) {
            e.preventDefault();
            e.stopPropagation();
            
            const billingId = $(this).data('billing-id');
            const serviceName = $(this).data('service');
            
            console.log('Cancel button clicked!', {billingId, serviceName});
            
            Swal.fire({
              title: 'Cancel This Charge?',
              html: '<strong>Service:</strong> ' + serviceName + '<br><br>' +
                    'This will:<br>' +
                    '• Delete this billing record<br>' +
                    '• Delete the associated service request<br>' +
                    '• Remove antenatal package usage if applicable<br><br>' +
                    '<strong>This action cannot be undone!</strong>',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Yes, cancel it!',
              cancelButtonText: 'No, keep it'
            }).then((result) => {
              if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                  title: 'Processing...',
                  text: 'Cancelling charge and deleting request',
                  allowOutsideClick: false,
                  didOpen: () => {
                    Swal.showLoading();
                  }
                });

                // Send delete request
                $.ajax({
                  url: '/app/billing/' + billingId + '/cancel-line',
                  type: 'DELETE',
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(response) {
                    Swal.fire({
                      title: 'Cancelled!',
                      text: response.message,
                      icon: 'success',
                      confirmButtonText: 'OK'
                    }).then(() => {
                      location.reload();
                    });
                  },
                  error: function(xhr) {
                    Swal.fire({
                      title: 'Error!',
                      text: xhr.responseJSON?.message || 'Failed to cancel charge.',
                      icon: 'error',
                      confirmButtonText: 'OK'
                    });
                  }
                });
              }
            });
          });
          
          console.log('Event handlers attached');
        });
      });
    </script>
@endsection

@section('content')
    <div class="card">
        <livewire:all-billings />
    </div>
@endsection
