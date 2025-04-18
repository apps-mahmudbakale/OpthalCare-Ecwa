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

  h1 {
    text-align: center;
    color: #fff;
    margin: 40px;
  }

  .accordion {
    margin-bottom: 10px;
  }

  .accordion-btn {
    position: relative;
    background: linear-gradient(72.47deg, #7367f0 22.16%, rgba(115, 103, 240, 0.7) 76.47%);
    border: none;
    padding: 15px 20px;
    text-align: left;
    cursor: pointer;
    font-weight: bold;
    box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.25);
    list-style-image: none;
    border-radius: 7px;
    color: white;
  }

  .accordion-btn::-webkit-details-marker {
    background: none;
    color: transparent;
  }

  .accordion-btn::after {
    content: "›";
    position: absolute;
    top: 50%;
    right: 10px;
    font-size: 35px;
    font-family: monospace;
    width: 35px;
    height: 35px;
    text-align: center;
    border-radius: 50%;
    border: 2px solid #ffffff;
    transform: translate(0%, -50%) rotate(0deg);
    box-sizing: border-box;
    display: flex;
    align-items: center;
    padding-bottom: 4px;
    padding-left: 2px;
    justify-content: center;
    font-weight: normal;
    transition: all .3s ease;
    color: white;
  }

  .accordion-content {
    background-color: #ffffff;
    box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.25);
    padding: 15px;
  }

  .accordion[open] .accordion-btn::after {
    transform: translate(0%, -50%) rotate(90deg);
  }

  .accordion[open] summary ~ * {
    overflow: hidden;
    animation: heightUp 1s ease-in-out;
  }

  @keyframes heightUp {
    0% {
      max-height: 0;
    }

    100% {
      max-height: 2000px;
    }
  }

  .accordion-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .accordion-header h3 {
    margin: 0;
    flex-grow: 1;
  }
</style>

<div>
  <div class="col-md-12">
    @foreach($iops as $iop)
    <details class="accordion">
      <summary class="accordion-btn">{{ $iop->created_at->format('d M Y h:i A') }}</summary>
      <div class="accordion-content p-2">
        <div class="accordion-header mb-3">
          <h3>Intra Ocular Pressure Chart for {{ $iop->patient->user->firstname }}
            {{ $iop->patient->user->lastname }}</h3>
          <div class="btn-group">
            <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                    data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                    aria-haspopup="true">
              <i class="fa fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu" style="">
              <li><button class="dropdown-item"
                          data-request-url="/app/iop/{{$iop->id}}/{{$iop->patient_id}}" data-toggle="modal"
                          data-target="#global-modal">Edit </button></li>
              <li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <l><button class="dropdown-item3 text-bg-danger" id="delete" data-delete-url="">Delete</button></l>
            </ul>
          </div>
        </div>
        <p class="text-muted">Recorded By  {{ $iop->user->firstname ." ". $iop->user->lastname }} on {{ $iop->created_at->format('d M Y h:i A') }}</p>
        <table class="table table-striped">
          <thead class="table-light">
          <th></th>
          <th>RIGHT EYE (RE)</th>
          <th>LEFT EYE (LE)</th>
          </thead>
          <tbody>
          <tr>
            <td width="50%">Non-Contact</td>
            <td>{{ $iop->right }}</td>
            <td>{{ $iop->left }}</td>
          </tr>

          </tbody>
        </table>
      </div>
    </details>
    @endforeach
    </div>
</div>

