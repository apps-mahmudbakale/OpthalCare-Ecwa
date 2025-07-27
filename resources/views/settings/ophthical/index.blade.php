@extends('layouts/layoutMaster')

@section('title', 'Vital Care Settings')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/cards-advance.js') }}"></script>
    {{-- <script src="{{asset('assets/js/modal-edit-user.js')}}"></script> --}}
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"Ophthicals Settings</span>
    </h4>

    <div class="row">
        <!-- Active Projects -->
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Ophthicals List</h5>
                    </div>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#new-antenatal-modal">New</a>
                        <a class="btn btn-label-dark waves-effect" href="{{ route('app.antenatal.export') }}">Download List</a>
                        <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" id="antenatal-import"
                           data-request-url="{{ route('app.antenatal.import') }}"
                           data-toggle="modal" data-target="#global-modal">Import Ophthicals</a>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:antenatals />
                </div>
            </div>
        </div>
    </div>
    <script>
  $(document).ready(function() {
    $('#antenatal-import').on('click', function() {
      var requestUrl = $(this).data('request-url');

      $.ajax({
        url: requestUrl,
        type: 'GET',
        success: function(response) {
          // Assuming the response contains the HTML for the modal content
          $('#global-modal .modal-body').html(response);
          $('#global-modal').modal('show');
        },
        error: function(xhr, status, error) {
          // Handle errors
          console.error(error);
        }
      });
    });
  });
</script>

@endsection
