<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Lab Results - Bulk Print</title>
	<style>
        @import "https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100..900;1,100..900&display=swap";
		.invoice-box {
			margin: auto;
            border: 1px solid #999;
			font-size: 10px;
			font-family: "Albert Sans", -apple-system, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			color: #111;
            min-height: calc(100vh - 60px);
		}
        .hospital-address {
            margin: 0;
            line-height: 1.3;
        }

        hr {
            border-width: 1px 0 0 0;
            margin: 3px 0;
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
            line-height: 1.4;
		}

		.invoice-box table tr.heading td {
			background: #eee;
			border-bottom: 1px solid #999;
			font-weight: bold;
            padding: 3px 5px;
		}

		.invoice-box table tr.details td {
			padding-bottom: 10px;
		}

		.invoice-box table tr.item td {
			border-bottom: 1px solid #999;
            padding: 1px 8px;
            line-height: 1.2;
		}

		.invoice-box table tr.item.last td {
			border-bottom: none;
		}

		.invoice-box table tr.total td:last-child {
			border-top: 1px solid #999;
			font-weight: bold;
		}

        /* Lab result section styling */
        .lab-result-section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .lab-result-header {
            background: #f8f9fa;
            padding: 5px 8px;
            border: 1px solid #ddd;
            font-weight: bold;
            font-size: 11px;
        }

        .patient-info {
            background: #fff;
            padding: 3px 8px;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            font-size: 9px;
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
            }
            
            /* Prevent page breaks inside lab result sections */
            .lab-result-section {
                page-break-inside: avoid;
                page-break-after: auto;
                margin-bottom: 10px;
            }
            
            /* Prevent page breaks inside table rows */
            .invoice-box table tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            
            /* Compact spacing for print */
            .invoice-box table tr.item td {
                padding: 1px 6px;
                line-height: 1.1;
            }
            
            .invoice-box table tr.heading td {
                padding: 2px 5px;
            }
            
            .letterhead img {
                max-width: 10% !important;
            }
            
            h2 {
                margin: 1px 0 !important;
                font-size: 14px !important;
            }
            
            .lab-result-header {
                font-size: 10px;
                padding: 3px 6px;
            }
            
            .patient-info {
                font-size: 8px;
                padding: 2px 6px;
            }
            
            body > footer {
                text-align: center;
                font-family: "Albert Sans", -apple-system, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                font-size: 8px;
                background-color: rgb(101, 101, 101);
                color: #fff;
                padding: 2px;
                border: none !important;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
            }
		}
        .letterhead {
            ;
            visibility: inherit;
        }
        @page {
            size: A4;
            margin: 8mm 12mm;
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
							<img src="{{ asset('logo.png') }}" style="max-width:15%;" alt="Hospital Logo">
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
        <tr>
            <td colspan="4" style="text-align: center; padding: 5px 0;">
                <h2 style="margin: 2px 0; font-size: 14px;">Laboratory Results - Bulk Print ({{ $labRequests->count() }} Results)</h2>
                <em>Printed on: {{ now()->format('D, j/n/Y g:iA') }}</em>
            </td>
        </tr>
        <tr><td colspan="4"><hr /></td></tr>
	</table>

    @foreach($labRequests as $index => $labRequest)
        <div class="lab-result-section">
            <!-- Lab Result Header -->
            <div class="lab-result-header">
                {{ $labRequest->test->name ?? 'N/A' }} &middot; {{ $labRequest->request_ref }}
                <span style="float: right;">Result #{{ $index + 1 }}</span>
            </div>
            
            <!-- Patient Information -->
            <div class="patient-info">
                <strong>{{ $labRequest->patient->user->firstname }} {{ $labRequest->patient->user->lastname }} 
                [{{ app(App\Settings\SystemSettings::class)->number_prefix ?: 'HRN' }}{{ $labRequest->patient->hospital_no }}]</strong>
                &middot; Age: {{ $labRequest->patient->getAge() }} 
                &middot; Gender: {{ $labRequest->patient->gender }}
                &middot; {{ $labRequest->patient->hmo->name ?? 'PRIVATE - Self Pay' }}
                <br>
                Order Date: {{ $labRequest->created_at->format('D, j/n/Y g:iA') }}
                @if($labRequest->findings)
                    &middot; Result Date: {{ $labRequest->findings->created_at->format('D, j/n/Y g:iA') }}
                @endif
            </div>

            <!-- Results Table -->
            <table style="border: 1px solid #ddd;">
                <tr class="heading">
                    <td style="width: auto">Parameter</td>
                    <td>Value</td>
                    <td>Reference</td>
                    <td style="text-align: right">Remark</td>
                </tr>
            
                @if($labRequest->findings && $labRequest->findings->items->count() > 0)
                    @foreach($labRequest->findings->items as $item)
                    <tr class="item">
                        <td style="width: auto">{{ $item->templateItem?->parameter?->name ?? 'N/A' }}</td>
                        <td>{{ $item->value }}</td>
                        <td>{{ $item->templateItem->reference ?? 'N/A' }}</td>
                        <td style="text-align: right;white-space: nowrap">{{ $item->remark }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr><td colspan="4" style="text-align: center; padding: 10px; font-style: italic;">No result recorded.</td></tr>
                @endif
            </table>
        </div>
    @endforeach
</div>

<footer>
    Bulk Print Generated on: <strong>{{ now()->format('D, j/n/Y g:iA') }}</strong>
    &middot; Total Results: <strong>{{ $labRequests->count() }}</strong>
    <br/>
    {{ app(App\Settings\SystemSettings::class)->website ?? 'www.gamjipremierclinics.com' }} - {{ app(App\Settings\SystemSettings::class)->email ?? 'info@gamjipremierclinics.com' }} - {{ app(App\Settings\SystemSettings::class)->phone ?? '070' }}
</footer>

<script>
// Auto-print when page loads
window.onload = function() {
    window.print();
};
</script>
</body>
</html>