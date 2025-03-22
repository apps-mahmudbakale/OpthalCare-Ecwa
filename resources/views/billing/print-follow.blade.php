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
      width: 75px;
      max-width: 75px;
    }

    td.quantity,
    th.quantity {
      width: 40px;
      max-width: 40px;
      word-break: break-all;
    }

    td.price,
    th.price {
      width: 40px;
      max-width: 40px;
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
  <p class="centered">New Follow Up Receipt
  </p>
  <table>
    <tr>
      <th>Name:</th>
      <td>{{$patient->user->firstname}} {{$patient->user->middlename ?? ''}} {{$patient->user->lastname}}</td>
    </tr>
    <tr>
      <th>Age:</th>
      <td>{{$patient->date_of_birth}}</td>
    </tr>
    <tr>
      <th>Gender:</th>
      <td>{{$patient->gender}} </td>
    </tr>
    <tr>
      <th>Email:</th>
      <td>{{$patient->user->email}}</td>
    </tr>
    <tr>
      <th>Phone:</th>
      <td>{{$patient->phone}}</td>
    </tr>
  </table>
  <p style="text-align: center"><b>Access Code: <br> {{$access->access_code}} </b></p>
  <p class="centered">Thanks for your purchase!
    <br>parzibyte.me/blog</p>
</div>
<button id="btnPrint" class="hidden-print">Print</button>
<script src="script.js"></script>
</body>
</html>
