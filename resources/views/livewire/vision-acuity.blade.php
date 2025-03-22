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
                @foreach ($vas as $va)
                    <tr>
                        <td></td>
                        <td>{{ $va->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                                    data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                                    aria-haspopup="true">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu" style="">
                                    <li><button class="dropdown-item"
                                            data-request-url="{{ route('app.show.va', $va->id) }}" data-toggle="modal"
                                            data-target="#global-modal">Details </button></li>
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
