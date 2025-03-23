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
      width: 100%
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
  <p style="text-align: center">
    <img
      src="
			{{ !empty(app(App\Settings\SystemSettings::class)->logo) ? asset('storage/system/' . app(App\Settings\SystemSettings::class)->logo) : asset('assets/img/logo.png') }}"
      style="width:80%;margin:0 auto"
      alt="Logo">
  </p>
  <div class="centered">
    <div>
      {{ !empty(app(App\Settings\SystemSettings::class)->clinic_name) ? app(App\Settings\SystemSettings::class)->clinic_name : 'OphthalCare' }}
      <br>
      {{ !empty(app(App\Settings\SystemSettings::class)->address) ? app(App\Settings\SystemSettings::class)->address : 'Address' }}
    </div>
  </div>
  <br>
  <strong class="centered">PAYMENT RECEIPT</strong>
  <br>
  <table>
    <thead>
    <tr>
      <th class="description">Description</th>
      <th class="price">₦</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td class="description">
        {{\App\Models\Billing::where('id', $payment->billing_id)->first()->service}}
      </td>
      <td class="price">
        {{number_format($payment->paying_amount)}}
      </td>
    </tr>
    <tr>
      <td class="price" colspan="2"><em>{{ucfirst(\Rmunate\Utilities\SpellNumber::value($payment->paying_amount)->locale('en')->currency('Naira')->toMoney())}}</em></td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    </tbody>
  </table>
  <div class="centered- bordered-">Received From:<br>{{\App\Models\Patient::where('id',\App\Models\Billing::where('id', $payment->billing_id)->first()->user_id)->first()->user->firstname}}, {{\App\Models\Patient::where('id',\App\Models\Billing::where('id', $payment->billing_id)->first()->user_id)->first()->user->lastname}} [{{ app(App\Settings\SystemSettings::class)->number_prefix ?: 'HRN' }}{{\App\Models\Patient::where('id',\App\Models\Billing::where('id', $payment->billing_id)->first()->user_id)->first()->hospital_no}}]</div>
  <br>
  <div class="centered-">Date:<br> {{$payment->created_at->format('d M Y h:i A')}}</div>
  <br>
  Thank You
  <br>
  <p class="centered small">Cashier: {{$payment->user->firstname." ".$payment->user->lastname}}</p>
  <p class="centered small">&copy; 2020-{{date('Y')}} - OpthalCare</p>
</div>
<button id="btnPrint" class="hidden-print">Print</button>
<script src="{{asset('jquery.min.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function () {
    window.print();
  });
  const $btnPrint = document.querySelector("#btnPrint");
  $btnPrint.addEventListener("click", () => {
    window.print();
  });
</script>
</body>
</html>
