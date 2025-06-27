<div>
  <div class="card-header">
<!--    <div class="filterForm d-flex justify-content-between">-->
<!--      <div class="form-group flex-fill">-->
<!--        <label for="patient_id">Filter By Patient</label>-->
<!--        <select wire:model="patient_id" class="form-control">-->
<!--          <option value="">- All -</option>-->
<!--          @foreach($patients as $patient)-->
<!--          <option value="{{ $patient->id }}">{{ $patient->user->firstname }}</option>-->
<!--          @endforeach-->
<!--        </select>-->
<!--      </div>-->
<!---->
<!--      <div class="form-group flex-fill ml-2">-->
<!--        <label for="category">Filter By Category</label>-->
<!--        <select wire:model="category_id" class="form-control">-->
<!--          <option value="">- All -</option>-->
<!--          @foreach(\App\Models\ProcedureCategory::all() as $category)-->
<!--          <option value="$category->id">{{$category->name}}</option>-->
<!--          @endforeach-->
<!--        </select>-->
<!--      </div>-->
<!---->
<!--      <div class="form-group flex-fill ml-2">-->
<!--        <label>Filter By Request Date</label>-->
<!--        <div class="d-flex">-->
<!--          <input type="date" wire:model="start" class="form-control mr-2">-->
<!--          <input type="date" wire:model="stop" class="form-control">-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
    <button class="btn btn-primary" data-toggle="modal"
       data-request-url="{{ route('app.opticals.create') }}"
       data-target="#global-modal-lg" id="new-request">New Request</button>
  </div>

  <div class="table-responsive mt-3">
    <table class="table">
      <thead>
      <tr>
        <th>Request Date</th>
        <th>Patient</th>
<!--        <th>Procedure</th>-->
<!--        <th>Category</th>-->
        <th>Status</th>
        <th></th>
      </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
    <div class="d-flex justify-content-around mt-2">

    </div>
  </div>
</div>
@include('_partials._modals.global-modal')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('#new-request').on('click', function() {
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
