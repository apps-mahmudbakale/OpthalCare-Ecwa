<div class="card">
    <div class="card-header border-bottom d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
        <div class="d-flex align-items-center mb-3 mb-md-0">
            <label class="me-2 mb-0">Show</label>
            <select class="form-select form-select-sm w-auto" wire:model="perPage">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <label class="ms-2 mb-0">entries</label>
        </div>
        <div class="d-flex align-items-center justify-content-md-end justify-content-center">
            <label class="me-2 mb-0">Search:</label>
            <input type="search" class="form-control form-control-sm w-auto" placeholder="Patient name or test..." wire:model.debounce.300ms="search">
        </div>
    </div>

    <!-- .table-responsive -->
    <div class="table-responsive">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Lab Test</th>
                    <th>Requester</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($labRequests as $labRequest)
                    <tr>
                        <td class="align-middle small text-nowrap">
                            {{ \Carbon\Carbon::parse($labRequest->created_at)->format('d M Y, g:i A') }}
                        </td>
                        <td class="align-middle">
                            <a href="{{ route('app.patients.show', $labRequest->patient->id) }}" class="fw-bold" target="_blank">
                                {{ $labRequest->patient->user->firstname }} {{ $labRequest->patient->user->lastname }}
                            </a>
                            <div class="small text-muted">#{{ $labRequest->patient->hospital_no }}</div>
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-label-info">{{ $labRequest->test ? $labRequest->test->name : 'Test not found' }}</span>
                        </td>
                        <td class="align-middle small">
                            {{ $labRequest->user->firstname . ' ' . $labRequest->user->lastname }}
                        </td>
                        <td class="align-middle text-nowrap">
                            @php
                                $statusClass = match($labRequest->status) {
                                    'Result Ready' => 'bg-label-success',
                                    'Specimen Collected' => 'bg-label-warning',
                                    'Pending' => 'bg-label-primary',
                                    'Cancelled' => 'bg-label-danger',
                                    default => 'bg-label-secondary'
                                };
                            @endphp
                            <span class="badge rounded-pill {{ $statusClass }} px-3">{{ $labRequest->status }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    @if ($labRequest->status == 'Specimen Collected')
                                        <li><button class="dropdown-item py-2" data-request-url="{{ route('app.lab.show', $labRequest->id) }}"><i class="ti ti-plus me-2"></i>Add Result</button></li>
                                    @elseif ($labRequest->status == 'Result Ready')
                                        <li><a class="dropdown-item py-2" target="_blank" href="{{ route('app.lab.print.result', $labRequest->id) }}"><i class="ti ti-printer me-2"></i>Print Result</a></li>
                                    @else
                                        <li><a href="{{ route('app.lab.specimen', $labRequest->id) }}" class="dropdown-item py-2"><i class="ti ti-flask me-2"></i>Receive Specimens</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    @if($labRequest->status === 'Pending')
                                    <li>
                                        <form action="{{ route('app.lab.destroy', $labRequest->id) }}" method="POST"
                                              onsubmit="return confirm('Cancel this lab request and remove its bill?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger py-2">
                                                <i class="ti ti-trash me-2"></i>Cancel Request
                                            </button>
                                        </form>
                                    </li>
                                    @endif                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="ti ti-info-circle ti-lg mb-2"></i>
                            <p class="mb-0">No lab requests found matching your criteria.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer border-top py-2">
        <div class="row align-items-center">
            <div class="col-sm-12 col-md-6 mb-2 mb-md-0">
                <div class="dataTables_info text-muted small" role="status" aria-live="polite">
                    Showing {{ $labRequests->firstItem() ?? 0 }} to {{ $labRequests->lastItem() ?? 0 }} of {{ $labRequests->total() }} entries
                </div>
            </div>
            <div class="col-sm-12 col-md-6 text-end">
                <div class="dataTables_paginate paging_simple_numbers">
                    {{ $labRequests->links('vendor.livewire.livewire-vuexy') }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('_partials._modals.global-modal')

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

      if (requestUrl) {  // Only trigger AJAX if there's a request URL
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
