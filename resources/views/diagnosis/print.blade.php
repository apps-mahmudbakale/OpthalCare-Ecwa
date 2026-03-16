<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Gynaecology Diagnosis Report</title>
  <style>
    body {
      font-family: -apple-system, 'Helvetica Neue', Helvetica, Arial, sans-serif;
      margin: 0;
      padding: 0;
      color: #333;
      background: #fff;
    }
    .invoice-box {
      max-width: 900px;
      margin: 20px auto;
      padding: 30px;
      border: 1px solid #eee;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
      font-size: 15px;
      line-height: 24px;
      background: #fff;
    }
    .invoice-box table {
      width: 100%;
      line-height: inherit;
      text-align: left;
      border-collapse: collapse;
    }
    .invoice-box table td {
      padding: 5px;
      vertical-align: top;
    }
    .invoice-box table tr.top td.title {
      text-align: center;
      font-size: 45px;
      line-height: 45px;
      color: #333;
    }
    .invoice-box h1, .invoice-box h2, .invoice-box h6 {
      color: #333;
      margin: 20px 0 10px 0;
    }
    .invoice-box h6 {
      margin-top: 25px;
      font-size: 16px;
      border-bottom: 2px solid #007bff;
      padding-bottom: 5px;
      color: #007bff;
    }
    .examination-table {
      width: 100%;
      border-collapse: collapse;
      margin: 15px 0;
    }
    .examination-table th, .examination-table td {
      border: 1px solid #999;
      padding: 8px;
      text-align: center;
    }
    .examination-table th {
      background-color: #343a40;
      color: white;
    }
    .examination-table td:first-child {
      text-align: left;
      font-weight: 500;
      background-color: #f8f9fa;
    }
    .sketch-img {
      max-width: 100%;
      height: auto;
      margin: 20px 0;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
    .footer {
      text-align: center;
      margin-top: 80px;
      font-size: 13px;
      color: #666;
    }
    @media print {
      body { margin: 0; }
      .invoice-box { border: none; box-shadow: none; }
      @page {
        size: A4;
        margin: 15mm;
        @bottom-right {
          content: "Page " counter(page) " of " counter(pages);
          font-size: 10px;
        }
      }
    }
  </style>
</head>
<body>

<div class="invoice-box">

  <!-- Header -->
  <table cellpadding="0" cellspacing="0">
    <tr class="top">
      <td colspan="2">
        <table>
          <tr>
            <td class="title">
              <img src="{{ asset('logo.png') }}" style="max-height:80px;">
            </td>
          </tr>
          <tr>
            <td style="text-align:center; padding-top:10px;">
              <strong>Reflex Vision & Diagnostics</strong><br>
              {{ app(App\Settings\SystemSettings::class)->address ?: 'Clinic Address' }}<br>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- Patient Info -->
    <tr class="information">
      <td colspan="2">
        <table>
          <tr>
            <td>
              <strong>Patient:</strong> {{ $diagnosis->patient->user->FullName() }} [{{ app(App\Settings\SystemSettings::class)->number_prefix ?: 'HRN' }}{{ $diagnosis->patient->hospital_no }}]<br>
              <strong>Payment Type:</strong> PRIVATE - Self Pay<br>
              <strong>Date of Visit:</strong> {{ $diagnosis->created_at->format('d/m/Y') }}<br><br>
            </td>
            <td style="text-align:left; white-space: nowrap;">
              Report Date: <strong>{{ now()->format('d M Y') }}</strong><br>
              Consultant: <strong>{{ $diagnosis->user->FullName() }}</strong>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <h2 style="text-align: center;">GYNAECOLOGY CONSULTATION REPORT</h2>
              <p style="text-align: center;"><strong>ICD-10 Code:</strong> {{ $diagnosis->ICD->number ?? 'Not specified' }}</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <!-- Diagnosis Details -->
  <h6>History</h6>
  <p>{!! $diagnosis->history ?? 'No history provided' !!}</p>

  <h6>Examination</h6>

  @if ($diagnosis->lmp || $diagnosis->edd || $diagnosis->ga)
      <div style="background: #f0f0f0; padding: 5px; margin-top: 10px; border-left: 4px solid #007bff; font-weight: bold; text-transform: uppercase; font-size: 13px;">Pregnancy Overview</div>
      <table class="examination-table">
          <tbody>
              @if ($diagnosis->lmp)
              <tr>
                  <td width="50%">LMP (Last Menstrual Period)</td>
                  <td style="text-align: left;">{{ $diagnosis->lmp }}</td>
              </tr>
              @endif
              @if ($diagnosis->edd)
              <tr>
                  <td>EDD (Estimated Due Date)</td>
                  <td style="text-align: left;">{{ $diagnosis->edd }}</td>
              </tr>
              @endif
              @if ($diagnosis->ga)
              <tr>
                  <td>GA (Gestational Age)</td>
                  <td style="text-align: left;">{{ $diagnosis->ga }}</td>
              </tr>
              @endif
          </tbody>
      </table>
  @endif

  @if ($diagnosis->gravidity || $diagnosis->parity || $diagnosis->last_delivery_date)
      <div style="background: #f0f0f0; padding: 5px; margin-top: 10px; border-left: 4px solid #17a2b8; font-weight: bold; text-transform: uppercase; font-size: 13px;">Obstetric History</div>
      <table class="examination-table">
          <tbody>
              @if ($diagnosis->gravidity)
              <tr>
                  <td width="50%">Gravidity</td>
                  <td style="text-align: left;">{{ $diagnosis->gravidity }}</td>
              </tr>
              @endif
              @if ($diagnosis->parity)
              <tr>
                  <td>Parity</td>
                  <td style="text-align: left;">{{ $diagnosis->parity }}</td>
              </tr>
              @endif
              @if ($diagnosis->last_delivery_date)
              <tr>
                  <td>Last Delivery Date</td>
                  <td style="text-align: left;">{{ $diagnosis->last_delivery_date }}</td>
              </tr>
              @endif
          </tbody>
      </table>
  @endif

  @if ($diagnosis->menstrual_history || $diagnosis->pelvic_examination)
      <div style="background: #f0f0f0; padding: 5px; margin-top: 10px; border-left: 4px solid #6c757d; font-weight: bold; text-transform: uppercase; font-size: 13px;">Specialist Findings</div>
      <table class="examination-table">
          <tbody>
              @if ($diagnosis->menstrual_history)
              <tr>
                  <td width="50%">Menstrual History</td>
                  <td style="text-align: left;">{{ $diagnosis->menstrual_history }}</td>
              </tr>
              @endif
              @if ($diagnosis->pelvic_examination)
              <tr>
                  <td>Pelvic Examination</td>
                  <td style="text-align: left;">{{ $diagnosis->pelvic_examination }}</td>
              </tr>
              @endif
          </tbody>
      </table>
  @endif

  <h6>General Examination</h6>
  <p>{{ $diagnosis->general_examination ?? 'No general examination provided' }}</p>

  <h6>Disability</h6>
  <p>{{ $diagnosis->disability ?? 'No disability noted' }}</p>

  <h6>Assessment / Diagnosis</h6>
  <p>{{ $diagnosis->assessment ?? 'No assessment provided' }}</p>

  <h6>Treatment Plan</h6>
  <p>{{ $diagnosis->treatment ?? 'No treatment plan specified' }}</p>

  <h6>Additional Notes</h6>
  <p>{{ $diagnosis->comments ?? 'No additional notes' }}</p>

  <!-- Sketch / Drawing -->
  @if($diagnosis->sketch)
    <h6>Clinical Sketch / Diagram</h6>
    <img src="{{ $diagnosis->sketch }}" alt="Diagnosis Sketch" class="sketch-img">
  @endif

  <div class="footer">
    <p><strong>Approval Time:</strong> {{ $diagnosis->updated_at->format('D, d/m/Y g:iA') }} |
      <strong>Consultant:</strong> {{ $diagnosis->user->FullName() }}</p>
    <hr>
    <p>{{ app(App\Settings\SystemSettings::class)->clinic_name }} | {{ app(App\Settings\SystemSettings::class)->address }}</p>
  </div>

</div>

</body>
</html>
