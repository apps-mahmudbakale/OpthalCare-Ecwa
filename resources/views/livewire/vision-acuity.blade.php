<style>
  .dropdown-item2 {
    display: block;
    width: 100%;
    padding:
      .5rem 1rem;
    clear: both;
    font-weight: 400;
    color: #191927;
    text-align: inherit;
    white-space:
      nowrap;
    background-color: transparent;
    border:
      0;
  }
  .dropdown-item2 {
    line-height: 1.375;
    width: calc(100% - 1rem);
    margin:
      0.25rem 0.5rem;
    border-radius:
      0.375rem;
  }
</style>
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
              <li><button class="dropdown-item"
                          data-request-url="/app/vision-acuity/{{$va->id}}/{{$va->patient_id}}"
                          data-toggle="modal"
                          data-target="#global-modal">Edit </button></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <button class="dropdown-item2 delete text-bg-danger"  data-request-url="{{route('app.delete.va', $va->id)}}">Delete</button>
              </li>
            </ul>
          </div>
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>

