@extends('layouts/layoutMaster')

@section('title', 'Vital Care Settings')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/quill.snow.css') }}" />
    {{-- <link href="{{ asset('assets/vendor/libs/summernote/summernote.min.css') }}" rel="stylesheet"> --}}
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script> --}}
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/cards-advance.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script src="{{ asset('assets/js/forms-editors.js') }}"></script>
    {{-- <script src="{{asset('assets/js/modal-edit-user.js')}}"></script> --}}
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Laboratory Settings</span>
    </h4>

    <div class="row">
        <!-- Monthly Campaign State -->
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Lab Test List</h5>
                    </div>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#new-lab-test-modal">New</a>
                        <a class="btn btn-label-dark waves-effect" href="{{ route('app.lab.export') }}">Downlaod List</a>
                        <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#import-lab-test-modal">Import Tests</a>
                    </div>
                </div>
                <div class="card-body">
                    @include('settings.laboratory._tests-table')
                </div>
            </div>
        </div>
        <!--/ Monthly Campaign State -->
        <!-- Active Projects -->
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Lab Category</h5>
                        {{-- <small class="text-muted">Average 72% Completed</small> --}}
                    </div>
                    <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" data-bs-toggle="modal"
                        data-bs-target="#new-lab-category">New</a>
                </div>
                <div class="card-body">
                    @include('settings.laboratory._categories-table')
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Lab Parameters</h5>
                        {{-- <small class="text-muted">Average 72% Completed</small> --}}
                    </div>
                    <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" data-bs-toggle="modal"
                        data-bs-target="#new-lab-parameter">New</a>
                </div>
                <div class="card-body">
                    @include('settings.laboratory._parameters-table')
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Lab Templates</h5>
                        {{-- <small class="text-muted">Average 72% Completed</small> --}}
                    </div>
                    <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" data-bs-toggle="modal"
                        data-bs-target="#new-lab-template">New</a>
                </div>
                <div class="card-body">
                    @include('settings.laboratory._templates-table')
                </div>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    @include('_partials._modals.modal-new-lab-test')
    @include('_partials._modals.modal-import-lab-test')
    @include('_partials._modals.modal-new-lab-category')
    @include('_partials._modals.modal-new-lab-parameter')
    @include('_partials._modals.modal-new-lab-template')
    @include('_partials._modals.global-modal')

    {{-- JavaScript for Edit Buttons - Inline to ensure it loads --}}
    <script>
      (function() {
        console.log('Laboratory settings JavaScript initializing...');
        console.log('jQuery loaded:', typeof jQuery !== 'undefined');
        console.log('$ loaded:', typeof $ !== 'undefined');

        function initializeEditHandlers() {
          console.log('Initializing edit handlers');

          // Handle Lab Test Edit
          $(document).off('click', '.edit-lab-btn').on('click', '.edit-lab-btn', function(e) {
            e.preventDefault();
            console.log('Lab test edit clicked');
            var requestUrl = $(this).data('request-url');
            console.log('Request URL:', requestUrl);
            
            $.ajax({
              url: requestUrl,
              type: 'GET',
              success: function(response) {
                console.log('Lab test edit form loaded');
                $('#global-modal .modal-body').html(response);
                $('#global-modal').modal('show');
              },
              error: function(xhr, status, error) {
                console.error('Error loading lab test edit form:', error, xhr);
                alert('Failed to load edit form. Error: ' + error);
              }
            });
          });

          // Handle Lab Category Edit
          $(document).off('click', '.edit-category-btn').on('click', '.edit-category-btn', function(e) {
            e.preventDefault();
            console.log('Category edit clicked');
            var requestUrl = $(this).data('request-url');
            console.log('Request URL:', requestUrl);
            
            $.get(requestUrl).done(function(response) {
              console.log('Category edit form loaded');
              $('#global-modal .modal-body').html(response);
              $('#global-modal').modal('show');
            }).fail(function(xhr, status, error) {
              console.error('Error loading category edit form:', error, xhr);
              alert('Failed to load edit form. Error: ' + error);
            });
          });

          // Handle Lab Parameter Edit
          $(document).off('click', '.edit-parameter-btn').on('click', '.edit-parameter-btn', function(e) {
            e.preventDefault();
            console.log('Parameter edit clicked');
            var requestUrl = $(this).data('request-url');
            console.log('Request URL:', requestUrl);
            
            $.get(requestUrl).done(function(response) {
              console.log('Parameter edit form loaded');
              $('#global-modal .modal-body').html(response);
              $('#global-modal').modal('show');
            }).fail(function(xhr, status, error) {
              console.error('Error loading parameter edit form:', error, xhr);
              alert('Failed to load edit form. Error: ' + error);
            });
          });

          // Handle Lab Template Edit
          $(document).off('click', '.edit-template-btn').on('click', '.edit-template-btn', function(e) {
            e.preventDefault();
            console.log('Template edit clicked');
            var requestUrl = $(this).data('request-url');
            console.log('Request URL:', requestUrl);
            
            $.get(requestUrl).done(function(response) {
              console.log('Template edit form loaded');
              $('#global-modal .modal-body').html(response);
              $('#global-modal').modal('show');
            }).fail(function(xhr, status, error) {
              console.error('Error loading template edit form:', error, xhr);
              alert('Failed to load edit form. Error: ' + error);
            });
          });

          console.log('Edit handlers initialized');
        }

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
          document.addEventListener('DOMContentLoaded', initializeEditHandlers);
        } else {
          initializeEditHandlers();
        }

        // Also initialize with jQuery ready as backup
        $(document).ready(function() {
          console.log('jQuery ready fired');
          initializeEditHandlers();
        });
      })();

      // Delete confirmation functions
      function submitDeleteForm(id) {
        if (confirm('Are you sure you want to delete this Lab Test?')) {
          const form = document.getElementById('delete-form-' + id);
          if (form) {
            form.submit();
          }
        }
      }

      function submitDeleteCategoryForm(id) {
        if (confirm('Are you sure you want to delete this category?')) {
          document.getElementById('delete-category-form-' + id).submit();
        }
      }

      function submitDeleteParameterForm(id) {
        if (confirm('Are you sure you want to delete this parameter?')) {
          document.getElementById('delete-parameter-form-' + id).submit();
        }
      }

      function submitDeleteTemplateForm(id) {
        if (confirm('Are you sure you want to delete this template?')) {
          document.getElementById('delete-template-form-' + id).submit();
        }
      }
    </script>
@endsection
