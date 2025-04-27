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
  @foreach ($diagnoses as $diagnosis)
  <details class="accordion">
    <summary class="accordion-btn">{{ $diagnosis->created_at->format('d M Y h:i A') }}</summary>
    <div class="accordion-content p-2">
      <div class="accordion-header mb-3">
        <h3 class="mb-2">Record Refraction for {{ $diagnosis->patient->user->firstname }} {{ $diagnosis->patient->user->lastname }}</h3>
        <div class="btn-group">
          <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                  data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                  aria-haspopup="true">
            <i class="fa fa-ellipsis-v"></i>
          </button>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item"
                 data-request-url="{{ route('app.diagnosis.edit', $diagnosis->id) }}"
                 data-bs-toggle="modal" data-bs-target="#global-modal">Edit</a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <button class="dropdown-item3  text-bg-danger" id="delete" data-delete-url="{{route('app.diagnosis.destroy', $diagnosis->id)}}">Delete</button>
            </li>
          </ul>
        </div>
      </div>
      <p class="text-muted">Recorded By {{ $diagnosis->user->firstname }} {{ $diagnosis->user->lastname }} on {{ $diagnosis->created_at->format('d M Y h:i A') }}</p>
      <div class="diagnosis-header">
        <button type="button" class="btn btn-primary" onclick="printDiagnosis()">Print</button>
      </div>
      <div class="diagnosis-body" id="diagnosisContent">
        <div class="text-center mb-4">
          <h3 class="mb-2">Diagnosis Details for {{ $diagnosis->patient->user->firstname }} {{ $diagnosis->patient->user->lastname }}</h3>
          <p><strong>ICD-10 Code:</strong> {{ $diagnosis->ICD->number ?? 'Not specified' }}</p>
        </div>
        <div class="col-md-12">
          <div class="list-group list-group-bordered">
            <div class="list-group-header justify-content-between">
              <div><i class="fas fa-calendar"></i> {{ $diagnosis->created_at->format('d M Y h:i A') }}</div>
              <div><i class="fas fa-user"></i> {{ $diagnosis->user->firstname }} {{ $diagnosis->user->lastname }}</div>
            </div>
            <div class="list-group-item">
              <div class="list-group-item-figure align-items-baseline">
                  <span class="tile tile-xs tile-circle bg-secondary">
                    <span class="fas fa-file"></span>
                  </span>
              </div>
              <div class="list-group-item-body">
                <h6>History</h6>
                {!! $diagnosis->history !!}
                <h6>Examination</h6>
                <table class="table table-striped table-bordered">
                  <thead class="table-dark">
                  <tr>
                    <th></th>
                    <th>(RE)</th>
                    <th>(LE)</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td width="70%">UNCORRECTED</td>
                    <td>{{ $diagnosis->uncorrected_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->uncorrected_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">PIN HOLE</td>
                    <td>{{ $diagnosis->pinhole_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->pinhole_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">VA WITH GLASSES</td>
                    <td>{{ $diagnosis->va_glass_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->va_glass_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">NEAR VISION</td>
                    <td>{{ $diagnosis->near_vision_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->near_vision_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">LID</td>
                    <td>{{ $diagnosis->lid_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->lid_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">GLOBE</td>
                    <td>{{ $diagnosis->globe_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->globe_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">EOMM</td>
                    <td>{{ $diagnosis->eomm_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->eomm_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">CONJUNCTIVA</td>
                    <td>{{ $diagnosis->conjuctiva_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->conjuctiva_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">CORNEA</td>
                    <td>{{ $diagnosis->cornea_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->cornea_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">ANTERIOR CHA</td>
                    <td>{{ $diagnosis->anterior_cha_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->anterior_cha_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">IRIS</td>
                    <td>{{ $diagnosis->iris_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->iris_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">PUPIL</td>
                    <td>{{ $diagnosis->pupil_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->pupil_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">LENS</td>
                    <td>{{ $diagnosis->lens_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->lens_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">IOP</td>
                    <td>{{ $diagnosis->iop_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->iop_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">VITREOUS</td>
                    <td>{{ $diagnosis->vitreous_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->vitreous_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">DISC</td>
                    <td>{{ $diagnosis->disc_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->disc_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">VCDR</td>
                    <td>{{ $diagnosis->vcdr_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->vcdr_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">MACULA</td>
                    <td>{{ $diagnosis->macula_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->macula_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">RETINA</td>
                    <td>{{ $diagnosis->retnia_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->retina_left ?? '   ' }}</td>
                  </tr>
                  <tr>
                    <td width="70%">VESSELS</td>
                    <td>{{ $diagnosis->vessels_right ?? '   ' }}</td>
                    <td>{{ $diagnosis->vessels_left ?? '   ' }}</td>
                  </tr>
                  </tbody>
                </table>
                <h6>Disability</h6>
                <p>{{ $diagnosis->disability ?? 'No disability noted' }}</p>
                <h6>Assessment</h6>
                <p>{{ $diagnosis->assessment ?? 'No assessment provided' }}</p>
                <h6>Treatment Plan</h6>
                <p>{{ $diagnosis->treatment ?? 'No treatment plan specified' }}</p>
                <h6>Additional Note</h6>
                <p>{{ $diagnosis->comments ?? 'No additional notes' }}</p>
              </div>
            </div>
            <div class="list-group-item">
              <div class="list-group-item-figure align-items-baseline">
                  <span class="tile tile-xs tile-circle bg-secondary">
                    <span class="fa fa-paperclip"></span>
                  </span>
              </div>
              <div class="list-group-item-body">
                <img src="{{ $diagnosis->sketch }}" alt="Diagnosis Sketch">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </details>
  @endforeach
</div>

@include('_partials._modals.modal-new-diagnosis')
@include('_partials._modals.global-modal')

<script>
  $(document).ready(function() {
    $('.dropdown-item').on('click', function() {
      var requestUrl = $(this).data('request-url');
      if (requestUrl) {
        $.ajax({
          url: requestUrl,
          type: 'GET',
          success: function(response) {
            $('#global-modal .modal-body').html(response);
            $('#global-modal').modal('show');
          },
          error: function(xhr, status, error) {
            console.error(error);
          }
        });
      }
    });
  });
</script>
