<div>
    <table class="table">
        <!-- thead -->
        <thead class="thead-light">
            <tr>
                <th></th>
                <th>Request Date</th>
                <th>Procedure</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <!-- tr -->
            @if ($requests->isEmpty())
                <tr>
                    <td colspan="6">
                        <div class="alert alert-warning">No Records to display at this moment</div>
                    </td>
                </tr>
            @else
                @foreach ($requests as $request)
                    <tr>
                        <td></td>
                        <td>{{ $request->created_at->diffForHumans() }}</td>
                        <td>{{ $request->procedure->name }}</td>
                        <td>{{ $request->status }}</td>

                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                                    data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                                    aria-haspopup="true">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu" style="">
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
            @endif

        </tbody><!-- /tbody -->

    </table>
</div>
