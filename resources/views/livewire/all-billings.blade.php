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
        <th>Service</th>
        <th class="text-right">Outstanding Amount</th>
        <th class="text-right">*</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($billings as $billRef => $group)
      @php
      $first = $group->first();
      $patient = $first->patient;
      $user = $patient->user ?? null;
      $service = $first->service;
      $fullName = collect([$user->firstname ?? '', $user->middlename ?? '', $user->lastname ?? ''])
      ->filter()
      ->implode(' ');
      $hospitalNo = sprintf('%06d', $patient->hospital_no ?? 0);
      $insurancePlan = $first->hmoPlan ? ($first->hmoPlan->hmo->name . ' - ' . $first->hmoPlan->name) : 'Patient Self Pay';
      $formattedAmount = number_format($group->sum('amount'));
      @endphp
      <tr>
        <td class="align-middle">
          <a href="#">
            {{ $fullName }} [HRN{{ $hospitalNo }}]
          </a>
        </td>
        <td>{{ $insurancePlan }}</td>
        <td>{{ $service }}</td>
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
                        data-request-url="{{ route('app.billing.show', $first->bill_ref) }}">
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

<script>
  $(document).ready(function () {
    $(document).on('click', '.new-bill-btn, .billing-show-btn, .dropdown-item', function (e) {
      let requestUrl = $(this).data('request-url');
      if (!requestUrl) return;

      e.preventDefault();

      $.get(requestUrl)
        .done(response => {
          $('#global-modal .modal-body').html(response);
          $('#global-modal').modal('show');
        })
        .fail(xhr => console.error(xhr.responseText));
    });
  });
</script>
