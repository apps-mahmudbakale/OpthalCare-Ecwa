<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title></title>
	<style>
        @import "https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100..900;1,100..900&display=swap";
		.invoice-box {
			margin: auto;
            border: 1px solid #999;
			font-size: 12px;
			font-family: "Albert Sans", -apple-system, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			color: #111;
            min-height: calc(100vh - 60px);
		}
        .hospital-address {
            margin: 0;
        }

        hr {
            border-width: 1px 0 0 0;
        }

		.invoice-box table {
			width: 100%;
			line-height: inherit;
			text-align: left;
            border-spacing: 0;
		}

		.invoice-box table > td {
			padding: 0;
			vertical-align: top;
		}

		.invoice-box table tr.top table td {
		}

		.invoice-box table tr.top table td.title {
			font-size: 14px;
			line-height: 14px;
			color: #111;
		}

		.invoice-box table tr.information table td {
            padding: 0 5px;
		}

		.invoice-box table tr.heading td {
			background: #eee;
			border-bottom: 1px solid #999;
			font-weight: bold;
            padding: 5px;
		}

		.invoice-box table tr.details td {
			padding-bottom: 20px;
		}

		.invoice-box table tr.item td {
			border-bottom: 1px solid #999;
            padding: 3px 10px;
		}

		.invoice-box table tr.item.last td {
			border-bottom: none;
		}

		.invoice-box table tr.total td:last-child {
			border-top: 1px solid #999;
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

		.footnote {
			font-size: smaller;
			text-align: center;
		}
		html,body {
			height: 100%;
			margin: 0;
		}
		body .invoice-box {
			display: block;
			position: relative;
		}

		@media screen {
			body > footer {
				
			}
            .invoice-box {
                max-width: 800px;
            }
        }
		@media print {
            body > footer {
            text-align: center;
            font-family: "Albert Sans", -apple-system, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            font-size: smaller;
            background-color: rgb(101, 101, 101);
            color: #fff;
            padding: 2px;
            border: none !important;
            }
		}
        .letterhead {
            ;
            visibility: inherit;
        }
        @page {
            @bottom-right {
                content: "Page " counter(page) " of " counter(pages);
                text-align: center;
                font-family: "Albert Sans", -apple-system, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                font-size: smaller;
            }
        }
	</style>
</head>

<body>
<div class="invoice-box">
	<table>
		<tr class="top">
			<td colspan="4">
				<table class="letterhead">
					<tr>
						<td class="title" style="text-align: center">
							<img src="{{ asset('logo.png') }}" style="max-width:17%;" alt="Hospital Logo">
						</td>
					</tr>
					<tr>
						<td style="text-align: center">
							<p class="hospital-address">
                                {{ app(App\Settings\SystemSettings::class)->clinic_name ?: 'SAHAD HOSPITALS' }}<br>
								{{ app(App\Settings\SystemSettings::class)->address ?: 'Clinic Address' }}<br>
                            </p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
        <tr><td colspan="4"><hr /></td></tr>
		<tr class="information">
			<td colspan="4">
				<table>
					<tr>
						<td>
							<b>{{ $patient->user->firstname }} {{ $patient->user->lastname }} [{{ app(App\Settings\SystemSettings::class)->number_prefix ?: 'HRN' }}{{ $patient->hospital_no }}]</b><br>
                            Age: {{ $patient->getAge() }} | Gender: {{ $patient->gender }}<br>
							{{ $patient->hmo ? $patient->hmo->name : 'PRIVATE - Self Pay' }}<br>
							
						</td>
					</tr>
                    <tr><td colspan="4"><hr /></td></tr>
					<tr>
						<td>
                            <h2 style="margin: 2px 0">{{ $lab->test->name }} &middot; {{ $lab->request_ref }}</h2>
							<em>Order Date: {{ $lab->created_at->format('D, j/n/Y g:iA') }}  &middot;
                                @if($result)
                                Result Date: {{ $result->created_at->format('D, j/n/Y g:iA') }}
                                @endif
                            </em><div>&nbsp;</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
			<tr class="heading">
				<td style="width: auto">Parameter</td>
				<td>Value</td>
				<td>Reference</td>
				<td style="text-align: right">Remark</td>
			</tr>
        
			@if($result)
				@foreach($result->items as $item)
				<tr class="item">
					<td style="width: auto">{{ $item->templateItem->parameter->name ?? 'N/A' }}</td>
					<td>{{ $item->value }}</td>
					<td>{{ $item->templateItem->reference ?? 'N/A' }}</td>
					<td style="text-align: right;white-space: nowrap">{{ $item->remark }}</td>
				</tr>
				@endforeach
			@else
				<tr><td colspan="4" style="text-align: center; padding: 20px;">No result recorded.</td></tr>
			@endif
	</table>
</div>
<footer>
    @if($result)
        Approval Time:
        <strong>{{ $result->created_at->format('D, j/n/Y g:iA') }}</strong> by
        <strong>{{ $result->user ? $result->user->FullName() : 'N/A' }}</strong>
    @endif
    <br/>
    {{ app(App\Settings\SystemSettings::class)->website ?? 'www.reflexvision.org' }} - {{ app(App\Settings\SystemSettings::class)->email ?? 'info@reflexvision.org' }} - {{ app(App\Settings\SystemSettings::class)->phone ?? '09012325403' }}
</footer>
</body>
</html>
