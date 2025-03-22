<div>
    <div class="col-md12">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th></th>
                    <th>Date Recorded</th>
                    <th>---</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($iops as $iop)
                    <tr>
                        <td></td>
                        <td>{{ $iop->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                                    data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                                    aria-haspopup="true">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu" style="">
                                    <li><a class="dropdown-item" data-request-url="{{ route('app.show.iop', $iop->id) }}"
                                            data-toggle="modal" data-target="#global-modal">Details </a></li>
                                    <li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Edit </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <l><a class="dropdown-item text-bg-danger" href="javascript:void(0);">Delete</a></l>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
{{-- @include('_partials._modals.global-modal')
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
</script> --}}
