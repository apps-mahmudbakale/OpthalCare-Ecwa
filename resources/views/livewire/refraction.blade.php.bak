<div>
  <div class="col-md-12">
    @foreach ($refractions as $refraction)
    <details class="accordion">
      <summary class="accordion-btn">{{ $refraction->created_at->format('d M Y h:i A') }}</summary>
      <div class="accordion-content p-2">
        <div class="accordion-header mb-3">
          <h3 class="mb-2">Record Refraction for {{ \App\Models\Patient::find($refraction->patient_id)->user->firstname }} {{ \App\Models\Patient::find($refraction->patient_id)->user->lastname }}</h3>
          <div class="btn-group">
            <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                    data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                    aria-haspopup="true">
              <i class="fa fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu" style="">
              <li><a href="{{route('app.refraction.edit', $refraction->id)}}" class="dropdown-item"
                         >Edit </a></li>
              <li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <l><button class="dropdown-item3 text-bg-danger" id="delete" data-delete-url="{{route('app.refraction.destroy', $refraction->id)}}">Delete</button></l>
            </ul>
          </div>
        </div>
        <p class="text-muted">Recorded By  {{ $refraction->user->firstname ." ". $refraction->user->lastname }} on {{ $refraction->created_at->format('d M Y h:i A') }}</p>
        <!-- Vision Acuity Test -->
        <h4 class="mt-4">Visual Acuity Test</h4>
        <div class="row">
          <div class="col-md-6">
            <table class="table table-striped table-bordered">
              <thead class="table-dark">
              <tr>
                <th scope="col" style="width: 30%;"></th>
                <th scope="col">DISTANCE</th>
                <th scope="col">PH</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>RIGHT</td>
                <td>{{ $refraction->distance_right ?? ' ' }}</td>
                <td>{{ $refraction->ph_right ?? ' ' }}</td>
              </tr>
              <tr>
                <td>LEFT</td>
                <td>{{ $refraction->distance_left ?? ' ' }}</td>
                <td>{{ $refraction->ph_left ?? ' ' }}</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-striped table-bordered">
              <thead class="table-dark">
              <tr>
                <th scope="col" style="width: 50%;"></th>
                <th scope="col">NEAR</th>
              </tr>
              </thead>
              <tbody>
              @foreach(['right', 'left'] as $side)
              <tr>
                <td>{{ strtoupper($side) }}</td>
                <td>{{ $refraction->{"near_{$side}"} ?? ' ' }}</td>
              </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <!-- Present Glasses -->
        <h4 class="mt-4">Present Glasses</h4>
        <table class="table table-striped table-bordered">
          <thead class="table-dark">
          <tr>
            <th scope="col" style="width: 20%;"></th>
            <th scope="col">SPH</th>
            <th scope="col">CYL</th>
            <th scope="col">AXIS</th>
            <th scope="col">PRISM</th>
            <th scope="col">BASE</th>
            <th scope="col">VA</th>
            <th scope="col">ADD</th>
            <th scope="col">VA</th>
          </tr>
          </thead>
          <tbody>
          @foreach(['right', 'left'] as $side)
          <tr>
            <td>{{ strtoupper($side) }}</td>
            @foreach(['sph_glass', 'cyl_glass', 'axis_glass', 'prism_glass', 'base_glass', 'va_glass', 'add_glass', 'va2_glass'] as $field)
            <td>{{ $refraction->{"{$field}_{$side}"} ?? ' ' }}</td>
            @endforeach
          </tr>
          @endforeach
          </tbody>
        </table>

        <!-- Auto Refraction -->
        <h4 class="mt-4">Auto Refraction</h4>
        <table class="table table-striped table-bordered">
          <thead class="table-dark">
          <tr>
            <th scope="col" style="width: 30%;"></th>
            <th scope="col">AUTO REFRACTION</th>
            <th scope="col">VA</th>
          </tr>
          </thead>
          <tbody>
          @foreach(['right', 'left'] as $side)
          <tr>
            <td>{{ strtoupper($side) }}</td>
            <td>{{ $refraction->{"auto_refraction_{$side}"} ?? ' ' }}</td>
            <td>{{ $refraction->{"va_auto_{$side}"} ?? ' ' }}</td>
          </tr>
          @endforeach
          </tbody>
        </table>

        <!-- Retinoscopy Findings -->
        <h4 class="mt-4">Retinoscopy Findings</h4>
        <table class="table table-striped table-bordered">
          <thead class="table-dark">
          <tr>
            <th scope="col" style="width: 50%;"></th>
            <th scope="col">SPH</th>
            <th scope="col">CYL</th>
            <th scope="col">AXIS</th>
            <th scope="col">VA</th>
          </tr>
          </thead>
          <tbody>
          @foreach(['right', 'left'] as $side)
          <tr>
            <td>{{ strtoupper($side) }}</td>
            <td>{{ $refraction->{"sph_retino_{$side}"} ?? ' ' }}</td>
            <td>{{ $refraction->{"cyl_retino_{$side}"} ?? ' ' }}</td>
            <td>{{ $refraction->{"axis_retino_{$side}"} ?? ' ' }}</td>
            <td>{{ $refraction->{"va_retino_{$side}"} ?? ' ' }}</td>
          </tr>
          @endforeach
          </tbody>
        </table>

        <!-- Subjective Refraction -->
        <h4 class="mt-4">Subjective Refraction</h4>
        <table class="table table-striped table-bordered">
          <thead class="table-dark">
          <tr>
            <th scope="col" style="width: 30%;"></th>
            <th scope="col">SPH</th>
            <th scope="col">CYL</th>
            <th scope="col">AXIS</th>
            <th scope="col">PRISM</th>
            <th scope="col">BASE</th>
            <th scope="col">VA</th>
            <th scope="col">ADD</th>
            <th scope="col">VA</th>
          </tr>
          </thead>
          <tbody>
          @foreach(['right', 'left'] as $side)
          <tr>
            <td>{{ strtoupper($side) }}</td>
            @foreach(['sph_subj', 'cyl_subj', 'axis_subj', 'prism_subj', 'base_subj', 'va_subj', 'add_subj', 'va2_subj'] as $field)
            <td>{{ $refraction->{"{$field}_{$side}"} ?? ' ' }}</td>
            @endforeach
          </tr>
          @endforeach
          </tbody>
        </table>

        <!-- Diagnosis and Additional Information -->
        <div class="row mt-4">
          <div class="col-12 mb-3">
            <label for="diagnosis" class="form-label">Diagnosis</label>
            <div>{{ $refraction->diagnosis ?? ' ' }}</div>
          </div>
          <div class="col-12">
            <label for="additional_info" class="form-label">Additional Information</label>
            <div>{{ $refraction->additional_info ?? ' ' }}</div>
          </div>
        </div>
      </div>
    </details>
    @endforeach
  </div>
</div>

@include('_partials._modals.global-modal')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  $(document).ready(function() {
    $(document).on('click', '.dropdown-item[data-request-url]', function() {
      var requestUrl = $(this).data('request-url');

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
    });
  });
</script>
