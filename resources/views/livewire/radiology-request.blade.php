<div>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th></th>
                <th>Date of Request</th>
                <th>Service</th>
                <th>User</th>
                <th>Status</th>
                <th>---</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
            <?php
            $serviceHandler = new App\Services\ServiceRequestHandler();
            $service = "Radiology:" . \App\Models\Radiology::where('id', $request->imaging_id)->first()->name;
            $isPaid = $serviceHandler->isBilled($request->imaging_id, $service); // Returns 1 or 0
            ?>
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
                  <td class="align-middle text-right">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                              data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                              aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end" style="">
                        @if ($request->status == 'Result Ready')
                        <li><a class="dropdown-item" target="_blank" href="{{ route('app.radiology.print.result', $request->id) }}">Print</a></li>
                        @else
                        <li>
                          <button class="dropdown-item add-notes-btn"
                                  data-request-url="{{ route('app.radiology.edit', $request->id) }}"
                                  data-paid="{{ $isPaid }}"> <!-- Set 1 or 0 directly -->
                            Add Findings/Notes
                          </button>
                        </li>
                        @endif
                        <li>
                          <a class="dropdown-item cancel-request text-bg-danger"
                             wire:click="cancelRequest({{ $request->id }})"
                             data-toggle="question"
                             data-question="Cancel Request?">
                            Cancel Request
                          </a>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
