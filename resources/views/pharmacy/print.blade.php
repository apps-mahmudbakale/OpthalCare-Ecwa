<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: -apple-system, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
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
            padding-bottom: 20px;
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
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
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
            margin-top: 100px;
        }

        .text-muted {
            color: gray;
        }

        .spacer {
            margin-top: 50px
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
                                <img src="{{ asset('hhh.png') }}" style="max-height:80px;">
                            </td>
                            <td>
                                {{ app(App\Settings\SystemSettings::class)->clinic_name ?: 'Clinic' }}<br>
                                {{ app(App\Settings\SystemSettings::class)->address ?: 'Clinic' }}<br>
                                Sokoto North, Sokoto<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information item">
                <td></td>
                <td colspan="2">
                    <div class="spacer"></div>
                    {{ $request->patient->user->firstname }} {{ $request->patient->user->firstname }}
                    [{{ app(App\Settings\SystemSettings::class)->number_prefix ?: 'HRN' }}{{ $request->patient->hospital_no }}]<br>
                    PRIVATE - Self Pay<br>
                    <br>
                    <div class="spacer"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div style="font-weight: bold; font-size: larger">Prescription Notice</div>
                </td>
                <td>Request Date: {{ $request->created_at->diffForHumans() }}</td>
            </tr>
            <tr class="heading">
                <td>Drug</td>
                <td>Dose</td>
                <td>Comment</td>
            </tr>

            <tr class="item">
                <td>

                    {{ $request->drug->name }}

                </td>
                <td>75 bd for 5 Day(s)</td>
                <td class="text-muted"></td>
            </tr>
        </table>
        <div class="spacer"></div>
    </div>
</body>

</html>
