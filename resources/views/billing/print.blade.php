<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Receipt example</title>
  <style>
    * {
      font-size: 12px;
      font-family: 'Times New Roman';
    }

    td,
    th,
    tr,
    table {
      border-top: 1px solid black;
      border-collapse: collapse;
    }

    td.description,
    th.description {
      width: 150px;
      max-width: 500px;
    }
    td.price,
    th.price {
      width: 200px;
      max-width: 500px;
      word-break: break-all;
    }

    .centered {
      text-align: center;
      align-content: center;
    }

    .ticket {
      width: 155px;
      max-width: 155px;
    }

    img {
      max-width: inherit;
      width: inherit;
    }

    @media print {
      .hidden-print,
      .hidden-print * {
        display: none !important;
      }
    }
  </style>
</head>
<body>
<div class="ticket">
  <img src="{{ !empty(app(App\Settings\SystemSettings::class)->logo) ? asset('storage/system/' . app(App\Settings\SystemSettings::class)->logo) : asset('assets/img/logo.png') }}"
       style="width: 130%; height:120%;">
  <p class="centered">Payment Receipt
    <br>
    {{ !empty(app(App\Settings\SystemSettings::class)->address) ? app(App\Settings\SystemSettings::class)->address : 'Address' }}
    </p>
  <table>
    <thead>
    <tr>
      <th class="description">Description</th>
      <th class="price">N</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td class="description">{{\App\Models\Billing::where('id', $payment->billing_id)->first()->service}}</td>
      <td class="price">N {{$payment->paying_amount}}</td>
    </tr>
    <tr>
      <td class="description">TOTAL</td>
      <td class="price">{{$payment->paying_amount}}</td>
    </tr>
    </tbody>
  </table>
  <p class="centered">Payment Receved From
    <br>{{\App\Models\Patient::where('id',\App\Models\Billing::where('id', $payment->billing_id)->first()->user_id)->first()->user->firstname}}</p>
  <p class="centered">Thanks for your purchase!
    <br>parzibyte.me/blog</p>
</div>
<button id="btnPrint" class="hidden-print">Print</button>
<script src="script.js"></script>
</body>
</html>
