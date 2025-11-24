<style>
  .dropdown-item3 {
    display: block;
    width: 100%;
    padding: 0.5rem 1rem;
    clear: both;
    font-weight: 400;
    color: #191927;
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
    line-height: 1.375;
    width: calc(100% - 1rem);
    margin: 0.25rem 0.5rem;
    border-radius: 0.375rem;
  }
</style>

<div>
  <div class="col-md-12">
    <div class="card card-fluid">
      <div class="card-header d-flex py-2">
        <div class="ml-auto d-flex">
          <div class="ml-2">
            <a href="" data-bs-toggle="modal" data-bs-target="#new-va-modal"
                                                class="btn btn-primary mb-2 float-end">New Entry</a>
{{--            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#global-modal"--}}
{{--                    data-remote="/lab/requests/new?patient_id=9772">--}}
{{--              New Request--}}
{{--            </button>--}}
          </div>
        </div>

      </div>
      <div class="card-body">
        <table class="table">
          <thead class="thead-light">
          <tr>
            <th></th>
            <th>Date</th>
            <th>Recorded By</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          @foreach ($vas as $va)
            <tr>
              <td></td>
              <td>{{ $va->created_at->format('d M Y h:i A') }}</td>
              <td>{{ $va->user->firstname }} {{ $va->user->lastname }}</td>
              <td class="align-middle text-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                          data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                          aria-haspopup="true">
                    <i class="fa fa-ellipsis-v"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" style="">
                    <li><button class="dropdown-item" data-request-url="{{route('app.vision-acuity.show', $va->id)}}" data-toggle="modal"
                                data-target="#global-modal"
                        >View </button></li>
                    <li>
                    <li><button class="dropdown-item" data-request-url="/app/vision-acuity/{{$va->id}}/{{$va->patient_id}}" data-toggle="modal"
                                data-target="#global-modal"
                      >Edit </button></li>
                    <li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <l><button class="dropdown-item3 text-bg-danger" id="delete" data-delete-url="">Delete</button></l>
                  </ul>
                </div>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>

</script>
