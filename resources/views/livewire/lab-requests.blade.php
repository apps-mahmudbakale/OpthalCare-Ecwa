<div>
    <table class="table">

        <thead class="thead-light">
            <tr>
                <th>
                    <div class="thead-dd dropdown">
                        <div class="custom-control custom-control-inline custom-control-nolabel custom-checkbox"
                            style="top:unset!important;margin-top: 0.2em!important;">
                            <input title="" type="checkbox" id="lab-select-all" class="custom-control-input">
                            <label class="custom-control-label" for="lab-select-all"></label>
                        </div>
                        <div class="thead-btn" role="button" data-toggle="dropdown" data-boundary="document"
                            aria-haspopup="true" aria-expanded="false">
                            <span class="fa fa-caret-down"></span>
                        </div>
                        <div class="dropdown-menu">
                            <div class="dropdown-arrow"></div>
                            <a class="dropdown-item" href="javascript:" id="item-select-all">Select
                                all</a>
                            <a class="dropdown-item" href="javascript:" id="item-unselect-all">Unselect all</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:" id="grouped-lab-result-print-btn">Grouped Print
                                Result</a>
                        </div>
                    </div>

                </th>
                <th>Date of Request</th>
                <th>Service</th>
                <th>User</th>
                <th>Status</th>
                <th>---</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td>
                        <div class="custom-control custom-control-inline custom-control-nolabel custom-checkbox"
                            style="top:unset!important;margin-top: 0.2em!important;">
                            <input title="" type="checkbox" id="lab-select-all" class="custom-control-input">
                            <label class="custom-control-label" for="lab-select-all"></label>
                        </div>
                    </td>
                    <td>{{ $request->created_at->diffForHumans() }}</td>
                    <td>{{ $request->test->name }}</td>
                    <td>{{ $request->user->firstname . ' ' . $request->user->lastname }}</td>
                    <td>{{ $request->status }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
