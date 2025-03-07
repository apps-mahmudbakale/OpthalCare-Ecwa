<div>
  <div class="card-header d-flex justify-content-between align-items-center">
    <button class="btn btn-success mb-2 new-bill-btn"
            data-request-url="{{ route('app.new.bill') }}"
            data-toggle="modal" data-target="#global-modal">
      New Bill
    </button>
    <input type="text" placeholder="Search" class="form-control w-25">
  </div>

  <div class="table-responsive">
    <table class="table">
      <thead>
      <tr>
        <th>Patient</th>
        <th>Primary Insurance Plan</th>
        <th class="text-right">Outstanding Amount</th>
        <th class="text-right">*</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($billings as $billing)
      @php
      $patient = $billing->patient;
      $user = $patient->user ?? null;
      $fullName = collect([$user->firstname ?? '', $user->middlename ?? '', $user->lastname ?? ''])
      ->filter()
      ->implode(' ');

      $hospitalNo = sprintf('%06d', $patient->hospital_no ?? 0);
      $insurancePlan = $patient->hmo->name ?? 'Patient Self Pay';
      $formattedAmount = number_format($billing->total_amount);
      $id = $billing->id;
      @endphp

      <tr>
        <td class="align-middle">
          <a href="#">
            {{ $fullName }} [HRN{{ $hospitalNo }}]
          </a>
        </td>
        <td>{{ $insurancePlan }}</td>
        <td class="text-right">{{ $formattedAmount }}</td>
        <td class="align-middle text-right">
          <div class="btn-group">
            <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                    data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu">
              <li>
                <button class="dropdown-item billing-show-btn"
                        data-request-url="{{ route('app.billing.show', $billing->id) }}">
                  Receive Payment
                </button>
              </li>
            </ul>
          </div>
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>

    <hr class="my-2">
    <div class="d-flex justify-content-around">
      {{ $billings->links() }}
    </div>
  </div>
</div>

@include('_partials._modals.global-modal')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function () {
    const modal = $('#global-modal');

    $('.new-bill-btn, .billing-show-btn').on('click', function (e) {
      e.preventDefault();
      let requestUrl = $(this).data('request-url');

      $.get(requestUrl)
        .done(response => {
          modal.find('.modal-body').html(response);
          modal.modal('show');
        })
        .fail(xhr => console.error(xhr.responseText));
    });
  });
</script>
<script>
  $(document).ready(function() {
    $('.dropdown-item').on('click', function() {
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
