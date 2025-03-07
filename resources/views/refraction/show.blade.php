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
    'blur_vision_near' => 'BLUR VISION AT NEAR',
    'diplopia' => 'DIPLOPIA',
    'burning_sensation' => 'BURNING SENSATION',
    'tearing' => 'TEARING',
    'discharge' => 'DISCHARGE'
    ];
    @endphp
    @foreach($symptoms as $key => $label)
    <tr>
      <td>{{ $label }}</td>
      <td>{{ $data[0]->{$key . '_right'} ?? 'N/A' }}</td>
      <td>{{ $data[0]->{$key . '_left'} ?? 'N/A' }}</td>
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
      <td>{{ $data[5]->adnexa_right ?? 'N/A' }}</td>
      <td>{{ $data[5]->adnexa_left ?? 'N/A' }}</td>
    </tr>
    <tr>
      <td>CONJUNCTIVA</td>
      <td>{{ $data[2]->conjunctiva_right ?? 'N/A' }}</td>
      <td>{{ $data[2]->conjunctiva_left ?? 'N/A' }}</td>
    </tr>
    @foreach(['sclera', 'pupil', 'palpebra', 'cornea'] as $part)
    <tr>
      <td>{{ strtoupper($part) }}</td>
      <td>{{ $data[2]->{$part . '_right'} ?? 'N/A' }}</td>
      <td>{{ $data[2]->{$part . '_left'} ?? 'N/A' }}</td>
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
          <th scope="col" style="width: 70%;"></th>
          <th scope="col">DISTANCE</th>
          <th scope="col">PH</th>
        </tr>
        </thead>
        <tbody>
        @foreach(['right', 'left'] as $side)
        <tr>
          <td>{{ strtoupper($side) }}</td>
          <td>{{ $data[3]->{"distance_{$side}"} ?? 'N/A' }}</td>
          <td>{{ $data[3]->{"ph_{$side}"} ?? 'N/A' }}</td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <div class="col-md-6">
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
        <tr>
          <th scope="col" style="width: 80%;"></th>
          <th scope="col">NEAR</th>
        </tr>
        </thead>
        <tbody>
        @foreach(['right', 'left'] as $side)
        <tr>
          <td>{{ strtoupper($side) }}</td>
          <td>{{ $data[3]->{"near_{$side}"} ?? 'N/A' }}</td>
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
      @foreach(['sph', 'cyl', 'axis', 'prism', 'base', 'va', 'add', 'va2'] as $field)
      <td>{{ $data[4]->{"{$field}_{$side}"} ?? 'N/A' }}</td>
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
      <th scope="col" style="width: 50%;"></th>
      <th scope="col">AUTO REFRACTION</th>
      <th scope="col">VA</th>
    </tr>
    </thead>
    <tbody>
    @foreach(['right', 'left'] as $side)
    <tr>
      <td>{{ strtoupper($side) }}</td>
      <td>{{ $data[5]->{"auto_refraction_{$side}"} ?? 'N/A' }}</td>
      <td>{{ $data[5]->{"va_{$side}"} ?? 'N/A' }}</td>
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
      <td>{{ $data[6]->{"sph_{$side}"} ?? 'N/A' }}</td>
      <td>{{ $data[6]->{"cyl_{$side}"} ?? 'N/A' }}</td>
      <td>{{ $data[6]->{"axis_{$side}"} ?? 'N/A' }}</td>
      <td>{{ $data[6]->{"rva_{$side}"} ?? 'N/A' }}</td>
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
      @foreach(['sph', 'cyl', 'axis', 'prism', 'base', 'va', 'add', 'va2'] as $field)
      <td>{{ $data[7]->{"{$field}_{$side}"} ?? 'N/A' }}</td>
      @endforeach
    </tr>
    @endforeach
    </tbody>
  </table>

  <!-- Diagnosis and Additional Information -->
  <div class="row mt-4">
    <div class="col-12 mb-3">
      <label for="diagnosis" class="form-label">Diagnosis</label>
      <div>{{ $data[8]->diagnosis ?? 'N/A' }}</div>
    </div>
    <div class="col-12">
      <label for="additional_info" class="form-label">Additional Information</label>
      <div>{{ $data[8]->additional_info ?? 'N/A' }}</div>
    </div>
  </div>
</div>
