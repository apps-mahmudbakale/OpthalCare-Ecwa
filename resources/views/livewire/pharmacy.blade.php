<div>
    <!-- .card-header -->
    <div class="card-header">
        <input type="text" placeholder="search" class="form-control">
    </div><!-- /.card-header -->
    <!-- .table-responsive -->
    <div class="table-responsive">
        <!-- .table -->
        <table class="table">
            <!-- thead -->
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Drug/Generic</th>
                    <th>Requester</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                    <tr>
                        <td class="align-middle text-nowrap">{{ $request->created_at->diffForHumans() }}</td>
                        <td class="align-middle">{{ $request->patient->user->firstname }}</td>
                        <td class="align-middle">
                            <span class="badge badge-lg bg-primary mb-1">
                                {{ $request->drug->name }}
                            </span>
                        </td>
                        <td class="align-middle">{{ $request->user->firstname }}</td>
                        <td class="align-middle text-right">
                            <div class="d-inline-block"><a href="javascript:;" class="dropdown hide-arrow"
                                    data-bs-toggle="dropdown"><i class="text-primary ti ti-dots-vertical"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end m-0">
                                    <li> <button class="dropdown-item"
                                            data-request-url="{{ route('app.pharmacy.show', $request->id) }}"
                                            data-toggle="modal" data-target="#global-modal" type="button">
                                            Details
                                        </button></li>
                                  <?php
                                  $serviceHandler = new App\Services\ServiceRequestHandler();
                                  $service = "Pharmacy:" . \App\Models\Drug::where('id', $request->drug->id)->first()->name;
                                  $isPaid = $serviceHandler->isBilled($request->drug->id, $service); // Returns 1 or 0
                                  ?>
                                  @if($isPaid)
                                    @if($request->status != 'Filled')
                                    <li> <button class="dropdown-item" data-toggle="modal"
                                            data-request-url="{{ route('app.pharmacy.edit', $request->id) }}"
                                            data-target="#global-modal-lg" type="button">
                                            Fill
                                        </button>
                                    </li>
                                  @endif
                                  @endif
                                    <div class="dropdown-divider"></div>
                                    <li>
                                        <button class="dropdown-item" data-toggle="question"
                                            data-question="Cancel All Prescription Lines in this Request?"
                                            data-remote="/pharmacy/request/996/cancel" type="button">
                                            Cancel
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <script>
                                document.querySelector('#dele{{ $request->id }}').addEventListener('click', function(e) {
                                    // alert(this.getAttribute('data-value'));
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: "You won't be able to revert this!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, delete it!',
                                        customClass: {
                                            confirmButton: 'btn btn-primary me-3',
                                            cancelButton: 'btn btn-label-secondary'
                                        },
                                        buttonsStyling: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            document.getElementById('dele#' + this.getAttribute('data-value')).submit();
                                        }
                                    })
                                })
                            </script>
                            <form id="dele#{{ $request->id }}" action="" method="POST"
                                style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody><!-- /tbody -->
        </table><!-- /.table -->
        <hr class="my-2">


        <div class="d-flex justify-content-around">


        </div>


    </div><!-- /.table-responsive -->
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
