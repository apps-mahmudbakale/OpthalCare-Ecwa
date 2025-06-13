<div>
  <!-- DataTable with Buttons -->
  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
      <input type="text" class="form-control w-auto" placeholder="Search Patients" wire:model.debounce.300ms="search">

      <select class="form-select w-auto" wire:model="filterGender">
        <option value="">All Genders</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>

      <select class="form-select w-auto" wire:model="filterTag">
        <option value="">All Tags</option>
        @foreach ($tags as $tag)
        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
        @endforeach
      </select>

      <select class="form-select w-auto" wire:model="filterAge">
        <option value="">All Ages</option>
        @for ($i = 1; $i <= 100; $i++)
        <option value="{{ $i }}">{{ $i }} years</option>
        @endfor
      </select>
      <button id="new-patient" class="btn btn-label-primary waves-effect">New Patient</button>
    </div>

    <div class="card-datatable table-responsive pt-0">
      <div class="row g-4">
        @foreach ($patients as $patient)
        <div class="col-xl-3 col-lg-4 col-sm-6 p-4">
          <div class="card card-figure is-hoverable">
            <figure class="figure">
              <div class="figure-img d-flex justify-content-between" style="overflow: unset">
                <a href="{{ route('app.patients.show', $patient->id) }}" class="user-avatar user-avatar-xl">
                  <img
                    src="{{ asset($patient->gender == 'Male' ? 'assets/img/user-male-circle.png' : 'assets/img/user-female-circle.png') }}"
                    alt="" class="{{ $patient->isCheckedInToday() ? 'checked-in' : '' }}">
                </a>

                <div class="dropdown">
                  <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                          aria-expanded="false">
                    <i class="ti ti-dots-vertical"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end custom-dropdown">
                    <a class="dropdown-item" href="{{ route('app.patients.show', $patient->id) }}">Open Profile</a>
                    <button class="dropdown-item" data-request-url="{{route('app.patients.tag', $patient->id)}}"
                            data-toggle="modal" data-target="#global-modal">Add Tag
                    </button>
                    <a class="dropdown-item" href="{{ route('app.patients.edit', $patient->id) }}">Edit Profile</a>

                    <a class="dropdown-item" href="{{route('app.patient.checkIn', $patient->id)}}">
                      Check In
                    </a>

                    <a class="dropdown-item" data-bs-toggle="modal"
                       data-bs-target="#schedule-appointment{{ $patient->id }}">
                      Schedule Appointment
                    </a>
                    <a class="dropdown-item text-danger" href="javascript:void(0);">Delete Profile</a>
                  </div>
                </div>
              </div>

              <figcaption class="figure-caption">
                <h6 class="figure-title">
                  <a href="{{ route('app.patients.show', $patient->id) }}">
                    {{ $patient->user->firstname }} {{ $patient->middlename }} {{ $patient->user->lastname }}
                    [{{ app(App\Settings\SystemSettings::class)->number_prefix ?: 'HRN' }}{{ $patient->hospital_no }}]
                  </a>
                </h6>
                <p class="text-muted mb-0">{{ $patient->gender }}, {{ $patient->getAge() }}</p>
                <p class="text-muted mb-0">{{ $patient->phone }}</p>
                <p class="text-muted mb-0">
                  <span class="badge bg-dark">WALK-IN PATIENT - Self Pay</span>
                  @if(\App\Models\PatientTags::where('patient_id', $patient->id)->count() > 0)
                  @foreach(\App\Models\PatientTags::where('patient_id', $patient->id)->get() as $tags)
                  <span class="badge bg-{{$tags->tag->color}} bg-glow">{{$tags->tag->name}}</span>
                  @endforeach
                  @endif
                </p>
              </figcaption>
            </figure>
          </div>
        </div>
        @endforeach
      </div>

      <div class="row">
        <div class="col-sm-12 col-md-6">
          <p class="dataTables_info">
            Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} entries
          </p>
        </div>
        <div class="col-sm-12 col-md-6 text-end">
          {{ $patients->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@include('_partials._modals.global-modal')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('click', function(event) {
      if (event.target.classList.contains('check-in-btn')) {
        event.preventDefault();
        const patientId = event.target.getAttribute('data-id');

        Swal.fire({
          title: 'Provide Access Code',
          input: 'text',
          confirmButtonText: 'Get Access',
          showLoaderOnConfirm: true,
          preConfirm: async (accessCode) => {
            try {
              const response = await fetch(`/api/billservices/${patientId}/follow-up/${accessCode}`);
              if (!response.ok) throw new Error('Request failed');

              const result = await response.json();
              if (!result.success) throw new Error(result.message);

              return result.data;
            } catch (error) {
              Swal.showValidationMessage(`Error: ${error.message}`);
            }
          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
          if (result.isConfirmed) {
            const encryptedData = btoa(JSON.stringify(result.value));
            window.location.href = `/app/patient/check-in/${patientId}`;
          }
        });
      }
    });
  });
</script>
<script>
  var patient = document.getElementById('new-patient');
  patient.addEventListener('click', function() {
    Swal.fire({
      title: 'Provide Access Code',
      input: 'text',
      inputAttributes: {
        autocapitalize: 'off'
      },
      confirmButtonText: 'Get Access',
      showLoaderOnConfirm: true,
      preConfirm: async (accessCode) => {
        try {
          const apiUrl = `/api/billservices/0/create-account/${accessCode}`;
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
  $(document).ready(function() {
    $(document).on('click', '.dropdown-item[data-request-url]', function(e) {
      e.preventDefault(); // Prevent default if needed

      var requestUrl = $(this).data('request-url');

      if (requestUrl) {
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
      }
    });
  });
</script>

<style>
  .custom-dropdown {
    max-height: 200px; /* Limit dropdown height */
    overflow-y: auto; /* Enable scroll */
  }
</style>
