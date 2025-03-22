<div>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>

                </th>
                <th>Date</th>
                <th>Service</th>
                <th class="text-right">Quantity</th>
                <th class="text-right">Amount</th>
                <th>Payer</th>
                <th>Status</th>
                <th>*</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($billings as $billing)
                <tr>
                    <td></td>
                    <td class="align-middle">{{ $billing->created_at->diffForHumans() }}</td>
                    <td>{{ $billing->service }}</td>
                    <td>{{ $billing->quantity }}</td>
                    <td class="text-right">{{ number_format($billing->amount) }}</td>
                    <td>{{ $billing->patient->hmo ? $billing->patient->hmo->name : 'Patient Self Pay' }} </td>
                    <td class="text-right">{{ $billing->status }}</td>
                    <td class="align-middle text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                                data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                                aria-haspopup="true">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu" style="">
                                <li><button class="dropdown-item"
                                        data-request-url="{{ route('app.billing.show', $billing->id) }}"
                                        data-toggle="modal" data-target="#global-modal">Receive
                                        Payment</button></li>
                                {{-- <li>
                              <hr class="dropdown-divider">
                          </li>
                          <l><a class="dropdown-item text-bg-danger" href="javascript:void(0);">Cancel</a></l> --}}
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('_partials._modals.global-modal')
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
