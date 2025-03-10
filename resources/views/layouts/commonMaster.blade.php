<!DOCTYPE html>

<html lang="{{ session()->get('locale') ?? app()->getLocale() }}"
      class="{{ $configData['style'] }}-style {{ $navbarFixed ?? '' }} {{ $menuFixed ?? '' }} {{ $menuCollapsed ?? '' }} {{ $footerFixed ?? '' }} {{ $customizerHidden ?? '' }}"
      dir="{{ $configData['textDirection'] }}" data-theme="{{ $configData['theme'] }}"
      data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{ url('/') }}" data-framework="laravel"
      data-template="{{ $configData['layout'] . '-menu-' . $configData['theme'] . '-' . $configData['style'] }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<!--  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">-->

  <title>@yield('title') |
    {{ app(App\Settings\SystemSettings::class)->clinic_name ?: 'Clinic' }}
  </title>
  <meta name="description"
        content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
  <meta name="keywords"
        content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
  <!-- laravel CRUD token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Canonical SEO -->
  <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
  <style>
    .checked-in{
      border: 2px solid darkgreen;
    }
  </style>
  @livewireStyles

  <!-- Include Styles -->
  @include('layouts/sections/styles')

  <!-- Include Scripts for customizer, helper, analytics, config -->
  @include('layouts/sections/scriptsIncludes')
</head>

<body>


<!-- Layout Content -->
@yield('layoutContent')
<!--/ Layout Content -->


@livewireScripts
<!-- Include Scripts -->
@include('layouts/sections/scripts')
<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
  {{ csrf_field() }}
</form>
<script>
  var patient = document.getElementById('new-patient');
  patient.addEventListener('click', function () {
    Swal.fire({
      title: "Provide Access Code",
      input: "text",
      inputAttributes: {
        autocapitalize: "off"
      },
      confirmButtonText: "Get Access",
      showLoaderOnConfirm: true,
      preConfirm: async (accessCode) => {
        try {
          const apiUrl = `/api/billservices/0/enrollment/${accessCode}`;
          const response = await fetch(apiUrl);

          if (!response.ok) {
            return Swal.showValidationMessage(`
              Request failed: ${response.statusText}
            `);
          }

          const result = await response.json();

          // Check if the access code verification was successful
          if (result.success) {
            return result;  // If successful, return the result
          } else {
            return Swal.showValidationMessage(`Error: ${result.message}`);
          }

        } catch (error) {
          Swal.showValidationMessage(`
            Request failed: ${error}
          `);
        }
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.isConfirmed) {
        // Encrypt the response (for demonstration, using base64 encoding)
        console.log(result.value.data);
        const encryptedData = btoa(JSON.stringify(result.value.data));

        // Redirect to the patient.create route with encrypted data
        window.location.href = `/app/patients/create?data=${encodeURIComponent(encryptedData)}`;
      }
    });
  });
</script>

<script>
  @if (session()->has('success'))
  Swal.fire({
    title: 'Success!',
    text: '{{ session()->get('success') }} !',
    icon: 'success',
    customClass: {
      confirmButton: 'btn btn-primary'
    },
    buttonsStyling: false
  });
  @elseif (session()->has('error'))
  Swal.fire({
    title: 'Error!',
    text: '{{ session()->get('error') }} !',
    icon: 'error',
    customClass: {
      confirmButton: 'btn btn-primary'
    },
    buttonsStyling: false
  });
  @endif
  @if (session()->has('check-in'))
  Swal.fire({
    text: '{{ session()->get('check-in') }} !',
    icon: 'info',
    customClass: {
      confirmButton: 'btn btn-primary'
    },
    buttonsStyling: false
  });
  @endif
</script>
</body>

</html>
