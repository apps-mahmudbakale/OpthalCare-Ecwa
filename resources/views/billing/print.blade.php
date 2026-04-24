<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <style type="text/css">
    * {
      font-size: 13px;
      font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    td, th, tr, table, .bordered {
      border-top: 1px solid black;
      border-collapse: collapse;
      width: 100%;
    }

    td.description, th.description {
      text-align: left;
    }

    td.quantity, th.quantity {
      word-break: break-all;
    }

    td.price, th.price {
      text-align: right;
    }

    .centered {
      text-align: center;
      align-content: center;
    }

    .small {
      font-size: x-small;
    }

    .ticket {
      width: 70mm;
      max-width: 70mm;
    }

    img {
      max-width: inherit;
      width: inherit;
    }

    @media print {
      .hidden-print, .hidden-print * {
        display: none !important;
      }
    }
  </style>
  <title>Payment Receipt</title>
</head>
<body>
<div class="ticket">
  <p class="centered">
    <img src="{{ !empty(app(App\Settings\SystemSettings::class)->logo)
        ? asset('storage/system/' . app(App\Settings\SystemSettings::class)->logo)
        : asset('assets/img/logo.png') }}"
         style="width:50%; margin:0 auto"
         alt="Logo">
  </p>

  <div class="centered">
    <div>
      {{ app(App\Settings\SystemSettings::class)->clinic_name ?? 'Gamji Premier Clinic' }}<br>
      {{ app(App\Settings\SystemSettings::class)->address ?? 'Address' }}
    </div>
  </div>

  <br>
  <strong class="centered">PAYMENT RECEIPT</strong>
  <br>

  @php
  $bills = \App\Models\Billing::where('bill_ref', $bill_ref)->get();
  $total = $bills->sum('amount');
  $firstBill = $bills->first();
  $patient = optional(optional($firstBill)->user)->patient;
  @endphp

  <table>
    <thead>
    <tr>
      <th class="description">Description</th>
      <th class="price">₦</th>
    </tr>
    </thead>
    <tbody>
    @foreach($bills as $bill)
    <tr>
      <td class="description">{{ $bill->service }}</td>
      <td class="price">{{ number_format($bill->amount) }}</td>
    </tr>
    @endforeach
    <tr>
      <td class="description"><strong>Total</strong></td>
      <td class="price"><strong>{{ number_format($total) }}</strong></td>
    </tr>
    <tr>
      <td class="price" colspan="2">
        <em>{{ ucfirst(\Rmunate\Utilities\SpellNumber::value($total)->locale('en')->currency('Naira')->toMoney()) }}</em>
      </td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    </tbody>
  </table>

  <div class="centered">
    Received From:<br>
    {{\App\Models\Patient::where('id',\App\Models\Billing::where('id', $payment->billing_id)->first()->user_id)->first()->user->firstname}}, {{\App\Models\Patient::where('id',\App\Models\Billing::where('id', $payment->billing_id)->first()->user_id)->first()->user->lastname}} [{{ app(App\Settings\SystemSettings::class)->number_prefix ?: 'HRN' }}{{\App\Models\Patient::where('id',\App\Models\Billing::where('id', $payment->billing_id)->first()->user_id)->first()->hospital_no}}]
  </div>

  @if(isset($clearance_code) && $clearance_code)
  <div style="border: 2px dashed black; padding: 10px; margin-top: 15px; text-align: center;">
      <strong style="font-size: 16px;">CLEARANCE CODE</strong><br>
      <span style="font-size: 24px; font-weight: bold;">{{ $clearance_code }}</span><br>
      <small style="font-size: 11px;">Provide this code at reception to check-in.</small>
  </div>
  @endif

  <br>
  <div class="centered">
    Date:<br> {{ $payment->created_at->format('d M Y h:i A') }}
  </div>

  <br>Thank You<br>
  <p class="centered small">
    Cashier: {{ $payment->user->firstname . ' ' . $payment->user->lastname }}
  </p>
  <p class="centered small">&copy; 2020 - {{ date('Y') }} - Gamji Premier Clinic</p>
</div>

<button id="btnPrint" class="hidden-print">Print</button>

<script src="{{ asset('jquery.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function () {
    window.print();
  });

  document.querySelector("#btnPrint").addEventListener("click", function () {
    window.print();
  });
</script>
</body>
</html>
