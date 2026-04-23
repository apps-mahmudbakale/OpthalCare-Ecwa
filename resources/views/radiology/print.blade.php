<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title></title>

  <style>
    .invoice-box {
      max-width: 800px;
      margin: auto;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, .15);
      font-size: 11pt;
      line-height: 20px;
      font-family: 'Times New Roman', Times, serif;
      color: #555;
    }

    .invoice-box table {
      width: 100%;
      line-height: inherit;
      text-align: left;
    }

    .invoice-box table td {
      vertical-align: top;
    }

    .invoice-box table tr td:last-child {
      text-align: right;
    }

    .invoice-box table tr.top table td {}

    .invoice-box table tr.top table td.title {
      font-size: 45px;
      line-height: 45px;
      color: #333;
    }

    .invoice-box table tr.information table td {}

    .invoice-box table tr.heading td {
      background: #eee;
      border-bottom: 1px solid #ddd;
      font-weight: bold;
    }

    .invoice-box table tr.details td {
      padding-bottom: 10px;
    }

    .invoice-box table tr.item td {
      border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
      border-bottom: none;
    }

    .invoice-box table tr.total td:last-child {
      border-top: 2px solid #eee;
      font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
      .invoice-box table tr.top table td {
        width: 100%;
        display: block;
        text-align: center;
      }

      .invoice-box table tr.information table td {
        width: 100%;
        display: block;
        text-align: center;
      }
    }

    /** RTL **/
    .rtl {
      direction: rtl;
      font-family: 'Times New Roman', Times, serif;
    }

    .rtl table {
      text-align: right;
    }

    .rtl table tr td:last-child {
      text-align: left;
    }

    .footnote {
      font-size: smaller;
      text-align: center;
      margin-top: 50px;
    }

    .text-muted {
      color: gray;
    }

    .spacer {
      margin-top: 30px
    }
    
    @media print {
      /* Force single page */
      html, body {
        height: 100%;
        overflow: hidden;
      }
      
      .invoice-box {
        page-break-inside: avoid;
        page-break-after: avoid;
        max-height: 100vh;
        overflow: hidden;
        padding: 15px;
      }
      
      /* Prevent page breaks inside table rows */
      .invoice-box table tr {
        page-break-inside: avoid;
        page-break-after: auto;
      }
      
      /* Compact spacing for print */
      .spacer {
        margin-top: 20px;
      }
      
      .invoice-box table tr.top table td.title img {
        max-height: 60px !important;
      }
      
      .invoice-box {
        font-size: 10pt;
        line-height: 18px;
      }
    }
    
    @page {
      size: A4;
      margin: 10mm 15mm;
    }
  </style>
  <link rel="stylesheet" href="/assets/vendor/fontawesome/css/all.css">
</head>

<body>
<div class="invoice-box">
  <table cellpadding="0" cellspacing="0">
    <tr class="top">
      <td colspan="3">
        <table>
          <tr>
            <td class="title">
              <img src="{{ asset('logo.png') }}" style="max-height:80px;">
            </td>
            <td>
              {{ app(App\Settings\SystemSettings::class)->clinic_name ?: 'Clinic' }}<br>
              {{ app(App\Settings\SystemSettings::class)->address ?: 'Clinic' }}<br>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <tr class="information item">
      <td colspan="3">
        <div class="spacer"></div>
        {{ $patient->user->firstname }} {{ $patient->user->lastname }}
        [{{ app(App\Settings\SystemSettings::class)->number_prefix ?: 'HRN' }}{{ $patient->hospital_no }}]<br>
        PRIVATE - Self Pay<br>
        <br>
        <div class="spacer"></div>
      </td>
    </tr>
    <tr>
       <div style="font-weight: bold; font-size: larger; text-align: center;">Radiology Investigation Result</div>
      <td colspan="3">
       
      </td>
    </tr>
    <tr class="item">
      <td colspan="3">
       <div style="text-align: justify; line-height: 25px;"> {!! $result ? $result->result : 'No results found.' !!}</div>
      </td>
    </tr>
    <!-- <tr class="item">
      <td colspan="3">
         <b>Reported By:</b> {{ $result->user ? $result->user->FullName() : 'N/A' }}
      </td>
    </tr> -->
  </table>
  <div class="spacer"></div>
</div>
</body>

</html>
