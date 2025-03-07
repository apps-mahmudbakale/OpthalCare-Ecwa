<!-- Edit User Modal -->
<div wire:ignore.self class="modal fade" id="new-diagnosis-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">New Diagnosis for
            {{ \App\Models\Patient::find(request()->route()->patient->id)->user->firstname }}
          </h3>
        </div>

        <!-- Tab Headings -->
        <ul class="nav nav-pills mb-3 justify-content-center" id="step-tabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="step1-tab" data-bs-toggle="pill" data-bs-target="#step1" type="button">History</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="step2-tab" data-bs-toggle="pill" data-bs-target="#step2" type="button">Examination</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="step3-tab" data-bs-toggle="pill" data-bs-target="#step3" type="button">Disability</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="step4-tab" data-bs-toggle="pill" data-bs-target="#step4" type="button">Case Description</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="step5-tab" data-bs-toggle="pill" data-bs-target="#step5" type="button">Treatment</button>
          </li>
        </ul>

        <!-- Multi-step Form -->
        <form id="diagnosis-form" action="{{ route('app.diagnosis.store') }}" method="POST">
          @csrf

          <div class="tab-content">
            <!-- Step 1 -->
            <div class="tab-pane fade show active" id="step1">
              <div class="col-12 col-md-12">
                <label class="form-label">History</label>
                <textarea name="history" required class="form-control"></textarea>
              </div>
              <div class="col-12 text-center mt-3">
                <button type="button" class="btn btn-primary next-step">Next</button>
              </div>
            </div>

            <!-- Step 2 -->
            <div class="tab-pane fade" id="step2">
              <h2>Examination</h2>
              <table class="table table-striped table-bordered">
                <!-- Examination table content -->
              </table>
              <div class="col-12 text-center mt-3">
                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                <button type="button" class="btn btn-primary next-step">Next</button>
              </div>
            </div>

            <!-- Step 3 -->
            <div class="tab-pane fade" id="step3">
              <div class="col-12">
                <label class="form-label">Type of Disability</label>
                <select name="disability" class="form-control">
                  <option>Visual</option>
                  <option>Hearing</option>
                  <option>Physical</option>
                  <option>Intellectual</option>
                  <option>Mental</option>
                  <option>Multiple</option>
                  <option>None</option>
                </select>
              </div>
              <div class="col-12 text-center mt-3">
                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                <button type="button" class="btn btn-primary next-step">Next</button>
              </div>
            </div>

            <!-- Step 4 -->
            <div class="tab-pane fade" id="step4">
              <div class="col-12">
                <label class="form-label">Case Description</label>
                <select name="icd_id" class="form-control">
                  @foreach (\App\Models\ICD10::all() as $icd)
                  <option value="{{ $icd->id }}">({{ $icd->number }}) {{ $icd->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 text-center mt-3">
                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                <button type="button" class="btn btn-primary next-step">Next</button>
              </div>
            </div>

            <!-- Step 5 -->
            <div class="tab-pane fade" id="step5">
              <div class="col-12">
                <label class="form-label">Treatment Plan</label>
                <textarea name="treatment" class="form-control"></textarea>
              </div>
              <div class="col-12 text-center mt-3">
                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="{{ asset('jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  jQuery(document).ready(function ($) {
    // Handle next step
    $(".next-step").click(function () {
      var currentTab = $(this).closest(".tab-pane");
      var nextTab = currentTab.next(".tab-pane");

      if (nextTab.length) {
        var nextTabId = nextTab.attr("id");
        $('.nav-pills .nav-link[href="#' + nextTabId + '"]').tab("show");
      }
    });

    // Handle previous step
    $(".prev-step").click(function () {
      var currentTab = $(this).closest(".tab-pane");
      var prevTab = currentTab.prev(".tab-pane");

      if (prevTab.length) {
        var prevTabId = prevTab.attr("id");
        $('.nav-pills .nav-link[href="#' + prevTabId + '"]').tab("show");
      }
    });

    // Handle form submission
    $("#diagnosis-form").submit(function (event) {
      event.preventDefault(); // Prevent default form submission

      var formData = $(this).serialize(); // Serialize form data

      $.ajax({
        url: $(this).attr("action"),
        type: "POST",
        data: formData,
        success: function (response) {
          console.log(response);
          $("#new-diagnosis-modal").modal("hide");

          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Diagnosis submitted successfully!",
            showConfirmButton: false,
            timer: 1500,
          });
        },
        error: function (xhr) {
          console.error(xhr);
          Swal.fire({
            icon: "error",
            title: "Error!",
            text: "Something went wrong.",
          });
        },
      });
    });
  });
</script>
