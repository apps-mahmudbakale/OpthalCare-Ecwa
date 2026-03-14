<!-- .card-header -->
<div class="card-header">
    <input type="text" class="form-control" placeholder="search">
</div><!-- /.card-header -->

<!-- .table-responsive -->
<div class="table-responsive">
    <!-- .table -->
    <table class="table table-striped">
        <!-- thead -->
        <thead>
            <tr>
                <th>Date</th>
                <th>Patient</th>
                <th>Investigation</th>
                <th>Requester</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($radiologyRequests as $radiologyRequest)
                <?php
                $serviceHandler = new App\Services\ServiceRequestHandler();
                $service = 'Radiology:' . \App\Models\Radiology::where('id', $radiologyRequest->imaging_id)->first()->name;
                $isPaid = $serviceHandler->isBilled($radiologyRequest->imaging_id, $service, $radiologyRequest->request_ref); // Explicitly cast to int
                ?>
                <tr>
                    <td class="align-middle">
                        {{ $radiologyRequest->created_at->diffForHumans() }}
                    </td>
                    <td class="align-middle">
                        <a target="_blank" href="{{ url('/app/patients/' . $radiologyRequest->patient->id) }}">
                            {{ $radiologyRequest->patient->user->firstname }}
                            {{ $radiologyRequest->patient->user->lastname }}
                            [HRN {{ $radiologyRequest->patient->hospital_no }}]
                        </a>
                    </td>
                    <td class="align-middle">
                        {{ $radiologyRequest->test->name }}
                    </td>
                    <td class="align-middle">
                        {{ $radiologyRequest->user->firstname }} {{ $radiologyRequest->user->lastname }}
                    </td>
                    <td>{{ $radiologyRequest->status }}</td>
                    <td class="align-middle text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                                data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                                aria-haspopup="true">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                @if ($radiologyRequest->status == 'Result Ready')
                                    <li><a class="dropdown-item" target="_blank"
                                            href="{{ route('app.radiology.print.result', $radiologyRequest->id) }}">Print</a>
                                    </li>
                                    @hasanyrole('admin|doctor')
                                    <li>
                                        <button class="dropdown-item add-notes-btn"
                                            data-request-url="{{ route('app.radiology.edit.result', $radiologyRequest->id) }}"
                                            data-paid="{{ $isPaid }}">
                                            Edit Result
                                        </button>
                                    </li>
                                    @endhasanyrole
                                @else
                                @hasanyrole('admin|doctor')
                                    <li>
                                        <button class="dropdown-item add-notes-btn"
                                            data-request-url="{{ route('app.radiology.edit', $radiologyRequest->id) }}"
                                            data-paid="{{ $isPaid }}">
                                            Add Findings/Notes
                                        </button>
                                    </li>
                                @endhasanyrole
                                @endif
                                <li>
                                    <a class="dropdown-item cancel-request text-bg-danger"
                                        wire:click="cancelRequest({{ $radiologyRequest->id }})" data-toggle="question"
                                        data-question="Cancel Request?">
                                        Cancel Request
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody><!-- /tbody -->
    </table><!-- /.table -->
    <hr class="my-2">
    <div class="d-flex justify-content-around">
        {{ $radiologyRequests->links('shared.custom-pagination') }}
        <input type="hidden" class="sr-only filter" name="page" value="1">
    </div>
</div><!-- /.table-responsive -->

<!-- Include the global modal partial -->
@include('_partials._modals.global-modal')

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Scripts -->
<script>
    $(document).ready(function() {
        $(document).on('click', '.add-notes-btn', function(e) {
            e.preventDefault();
            var requestUrl = $(this).data('request-url');
            var isPaid = $(this).data('paid');

            if (isPaid != 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Service Not Paid',
                    text: 'This radiology service has not been paid for yet.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $.get(requestUrl)
                .done(response => {
                    $('#global-modal .modal-body').html(response);
                    $('#global-modal').modal('show');
                })
                .fail(xhr => {
                    console.error('Error:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong while loading the form.',
                    });
                });
        });

        // Handle other dropdown items (like Cancel) that don't need payment check
        $(document).on('click', '.dropdown-item:not(.add-notes-btn)', function(e) {
            var requestUrl = $(this).data('request-url');
            if (requestUrl) {
                e.preventDefault();
                $.get(requestUrl)
                    .done(response => {
                        $('#global-modal .modal-body').html(response);
                        $('#global-modal').modal('show');
                    })
                    .fail(xhr => console.error('Error:', xhr.responseText));
            }
        });
    });
</script>
