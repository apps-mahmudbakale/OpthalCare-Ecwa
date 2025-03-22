<div class="container">
  <div class="text-center mb-4">
    <h3 class="mb-2">Record Refraction for {{ $patient->user->firstname }} {{ $patient->user->lastname }}</h3>
  </div>

  <!-- Case History -->
  <h4 class="mt-4">Case History</h4>
  <table class="table table-striped table-bordered">
    <thead class="table-dark">
    <tr>
      <th scope="col" style="width: 70%;"></th>
      <th scope="col">RE</th>
      <th scope="col">LE</th>
    </tr>
    </thead>
    <tbody>
    @php
    $symptoms = [
    'itching' => 'ITCHING',
    'photophobia' => 'PHOTOPHOBIA',
    'pain' => 'PAIN',
    'blur_vision_far' => 'BLUR VISION AT FAR',
    'near' => 'BLUR VISION AT NEAR',
    'diplopia' => 'DIPLOPIA',
    'burning_sensation' => 'BURNING SENSATION',
    'tearing' => 'TEARING',
    'discharge' => 'DISCHARGE'
    ];
    @endphp
    @foreach($symptoms as $key => $label)
    <tr>
      <td>{{ $label }}</td>
      <td>{{ $refraction->{$key . '_right'} ?? 'N/A' }}</td>
      <td>{{ $refraction->{$key . '_left'} ?? 'N/A' }}</td>
    </tr>
    @endforeach
    </tbody>
  </table>



  <!-- External Examination -->
  <h4 class="mt-4">External Examination</h4>
  <table class="table table-striped table-bordered">
    <thead class="table-dark">
    <tr>
      <th scope="col" style="width: 70%;"></th>
      <th scope="col">RIGHT</th>
      <th scope="col">LEFT</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>ADNEXA</td>
      <td>{{ $refraction->adnexa_right ?? 'N/A' }}</td>
      <td>{{ $refraction->adnexa_left ?? 'N/A' }}</td>
    </tr>
    <tr>
      <td>CONJUNCTIVA</td>
      <td>{{ $refraction->conjuctiva_right ?? 'N/A' }}</td>
      <td>{{ $refraction->conjuctiva_left ?? 'N/A' }}</td>
    </tr>
    @foreach(['sclera', 'pupil', 'palpebra', 'cornea'] as $part)
    <tr>
      <td>{{ strtoupper($part) }}</td>
      <td>{{ $refraction->{$part . '_right'} ?? 'N/A' }}</td>
      <td>{{ $refraction->{$part . '_left'} ?? 'N/A' }}</td>
    </tr>
    @endforeach
    </tbody>
  </table>

  <!-- Vision Acuity Test -->
  <h4 class="mt-4">Vision Acuity Test</h4>
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
          <td>{{ $refraction->distance_right ?? 'N/A' }}</td>
          <td>{{ $refraction->ph_right ?? 'N/A' }}</td>
        </tr>
        <tr>
          <td>LEFT</td>
          <td>{{ $refraction->distance_left ?? 'N/A' }}</td>
          <td>{{ $refraction->ph_left ?? 'N/A' }}</td>
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
          <td>{{ $refraction->{"near_{$side}"} ?? 'N/A' }}</td>
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
      <td>{{ $refraction->{"{$field}_{$side}"} ?? 'N/A' }}</td>
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
      <td>{{ $refraction->{"auto_refraction_{$side}"} ?? 'N/A' }}</td>
      <td>{{ $refraction->{"va_auto_{$side}"} ?? 'N/A' }}</td>
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
      <td>{{ $refraction->{"sph_retino_{$side}"} ?? 'N/A' }}</td>
      <td>{{ $refraction->{"cyl_retino_{$side}"} ?? 'N/A' }}</td>
      <td>{{ $refraction->{"axis_retino_{$side}"} ?? 'N/A' }}</td>
      <td>{{ $refraction->{"va_retino_{$side}"} ?? 'N/A' }}</td>
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
      <td>{{ $refraction->{"{$field}_{$side}"} ?? 'N/A' }}</td>
      @endforeach
    </tr>
    @endforeach
    </tbody>
  </table>

  <!-- Diagnosis and Additional Information -->
  <div class="row mt-4">
    <div class="col-12 mb-3">
      <label for="diagnosis" class="form-label">Diagnosis</label>
      <div>{{ $refraction->diagnosis ?? 'N/A' }}</div>
    </div>
    <div class="col-12">
      <label for="additional_info" class="form-label">Additional Information</label>
      <div>{{ $refraction->additional_info ?? 'N/A' }}</div>
    </div>
  </div>
</div>
