<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Refraction Report</title>

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: -apple-system, Helvetica, Arial, sans-serif;
      color: #555;
      font-size: 15px;
      line-height: 22px;
    }

    .invoice-box {
      max-width: 900px;
      margin: auto;
      padding: 30px;
      box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    td,
    th {
      padding: 6px 8px;
      vertical-align: middle;
    }

    .title img {
      max-height: 80px;
    }

    .heading {
      background: #eee;
      font-weight: bold;
      border-bottom: 1px solid #ddd;
    }

    .section-title {
      font-size: 18px;
      font-weight: bold;
      margin: 28px 0 10px;
      text-transform: uppercase;
    }

    .text-right {
      text-align: right;
    }

    .bordered td,
    .bordered th {
      border: 1px solid #ddd;
    }

    .spacer {
      margin-top: 30px;
    }

    /* --- Responsive --- */
    @media (max-width: 600px) {
      .invoice-box table td {
        display: block;
        text-align: center;
      }
      .text-right {
        text-align: center !important;
      }
    }
  </style>
</head>

<body>
<div class="invoice-box">

  <!-- HEADER -->
  <table>
    <tr>
      <td class="title">
        <img src="{{ asset('logo.png') }}" alt="Clinic Logo">
      </td>
      <td class="text-right">
        <strong>{{ app(App\Settings\SystemSettings::class)->clinic_name ?: 'Clinic' }}</strong><br>
        {{ app(App\Settings\SystemSettings::class)->address ?: '' }}<br>
      </td>
    </tr>
  </table>

  <!-- PATIENT -->
  <div class="spacer"></div>
  <table>
    <tr>
      <td>
        <strong>Patient:</strong>
        {{ $patient->user->firstname }} {{ $patient->user->lastname }}<br>
        <strong>Record No:</strong>
        {{ app(App\Settings\SystemSettings::class)->number_prefix ?: 'HRN' }}{{ $patient->hospital_no }}<br>
        <strong>Payment Class:</strong> PRIVATE (Self Pay)
      </td>

      <td class="text-right">
        <strong>Date:</strong>
        {{ $refraction->created_at->toFormattedDateString() }}
      </td>
    </tr>
  </table>

  <!-- REPORT TITLE -->
  <h2 style="margin-top:35px;">Refraction Report</h2>

  <!-- VISUAL ACUITY -->
  <div class="section-title">Visual Acuity</div>
  <table class="bordered">
    <thead class="heading">
    <tr>
      <th></th>
      <th>DISTANCE</th>
      <th>PH</th>
      <th>NEAR</th>
    </tr>
    </thead>
    <tbody>
    @foreach(['right', 'left'] as $side)
      <tr>
        <td>{{ strtoupper($side) }}</td>
        <td>{{ $refraction->{"distance_{$side}"} ?? '' }}</td>
        <td>{{ $refraction->{"ph_{$side}"} ?? '' }}</td>
        <td>{{ $refraction->{"near_{$side}"} ?? '' }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>

  <!-- PRESENT GLASSES -->
  <div class="section-title">Present Glasses</div>
  <table class="bordered">
    <thead class="heading">
    <tr>
      <th></th>
      <th>SPH</th>
      <th>CYL</th>
      <th>AXIS</th>
      <th>PRISM</th>
      <th>BASE</th>
      <th>VA DIST</th>
      <th>ADD</th>
      <th>VA NEAR</th>
    </tr>
    </thead>
    <tbody>
    @foreach(['right', 'left'] as $side)
      <tr>
        <td>{{ strtoupper($side) }}</td>
        @foreach(['sph_glass','cyl_glass','axis_glass','prism_glass','base_glass','va_glass','add_glass','va2_glass'] as $f)
          <td>{{ $refraction->{"{$f}_{$side}"} ?? '' }}</td>
        @endforeach
      </tr>
    @endforeach
    </tbody>
  </table>

  <!-- AUTO REFRACTION -->
  <div class="section-title">Auto Refraction</div>
  <table class="bordered">
    <thead class="heading">
    <tr>
      <th></th>
      <th>Measurement</th>
      <th>VA</th>
    </tr>
    </thead>
    <tbody>
    @foreach(['right','left'] as $side)
      <tr>
        <td>{{ strtoupper($side) }}</td>
        <td>{{ $refraction->{"auto_refraction_{$side}"} ?? '' }}</td>
        <td>{{ $refraction->{"va_auto_{$side}"} ?? '' }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>

  <!-- RETINOSCOPY -->
  <div class="section-title">Retinoscopy Findings</div>
  <table class="bordered">
    <thead class="heading">
    <tr>
      <th></th>
      <th>SPH</th>
      <th>CYL</th>
      <th>AXIS</th>
      <th>VA</th>
    </tr>
    </thead>
    <tbody>
    @foreach(['right','left'] as $side)
      <tr>
        <td>{{ strtoupper($side) }}</td>
        <td>{{ $refraction->{"sph_retino_{$side}"} ?? '' }}</td>
        <td>{{ $refraction->{"cyl_retino_{$side}"} ?? '' }}</td>
        <td>{{ $refraction->{"axis_retino_{$side}"} ?? '' }}</td>
        <td>{{ $refraction->{"va_retino_{$side}"} ?? '' }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>

  <!-- SUBJECTIVE REFRACTION -->
  <div class="section-title">Subjective Refraction</div>
  <table class="bordered">
    <thead class="heading">
    <tr>
      <th></th>
      <th>SPH</th>
      <th>CYL</th>
      <th>AXIS</th>
      <th>PRISM</th>
      <th>BASE</th>
      <th>VA DIST</th>
      <th>ADD</th>
      <th>VA NEAR</th>
    </tr>
    </thead>
    <tbody>
    @foreach(['right','left'] as $side)
      <tr>
        <td>{{ strtoupper($side) }}</td>
        @foreach(['sph_subj','cyl_subj','axis_subj','prism_subj','base_subj','va_subj','add_subj','va2_subj'] as $f)
          <td>{{ $refraction->{"{$f}_{$side}"} ?? '' }}</td>
        @endforeach
      </tr>
    @endforeach
    </tbody>
  </table>

  <!-- DIAGNOSIS -->
  <div class="section-title">Diagnosis</div>
  <p>{{ $refraction->diagnosis ?? 'None' }}</p>

  <!-- ADDITIONAL INFO -->
  <div class="section-title">Additional Information</div>
  <p>{{ $refraction->additional_info ?? 'None' }}</p>

</div>
</body>
<script !src="">
  window.print();
</script>
</html>
