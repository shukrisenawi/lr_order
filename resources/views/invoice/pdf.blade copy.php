<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_no }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #fff;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border: 1px solid #ddd;
        }

        /* Header with blue bar */
        .header-bar {
            background-color: #2E5BBA;
            height: 8px;
            width: 100%;
        }

        .header-content {
            padding: 30px 40px;
            display: table;
            width: 100%;
            box-sizing: border-box;
        }

        .header-left {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }

        .header-right {
            display: table-cell;
            vertical-align: top;
            width: 50%;
            text-align: right;
        }

        .invoice-title {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin: 0 0 20px 0;
        }

        .company-logo {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }

        .logo-placeholder {
            width: 80px;
            height: 80px;
            background-color: #fff;
            border: 3px solid #E53E3E;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .logo-hexagon {
            width: 60px;
            height: 60px;
            background-color: #E53E3E;
            position: relative;
            margin: 0 auto;
        }

        .logo-hexagon:before,
        .logo-hexagon:after {
            content: "";
            position: absolute;
            width: 0;
            border-left: 30px solid transparent;
            border-right: 30px solid transparent;
        }

        .logo-hexagon:before {
            bottom: 100%;
            border-bottom: 15px solid #E53E3E;
        }

        .logo-hexagon:after {
            top: 100%;
            border-top: 15px solid #E53E3E;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 0 0 5px 0;
        }

        .company-tagline {
            font-size: 12px;
            color: #E53E3E;
            margin: 0;
            text-transform: uppercase;
        }

        /* Invoice details section */
        .invoice-details {
            padding: 0 40px 30px 40px;
            display: table;
            width: 100%;
            box-sizing: border-box;
        }

        .details-left {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }

        .details-right {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin: 0 0 10px 0;
        }

        .detail-row {
            margin-bottom: 8px;
            font-size: 12px;
        }

        .detail-label {
            color: #666;
            display: inline-block;
            width: 80px;
        }

        .detail-value {
            color: #333;
        }

        /* Invoice metadata */
        .invoice-meta {
            padding: 0 40px 20px 40px;
            border-bottom: 1px solid #eee;
        }

        .meta-row {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }

        .meta-label {
            display: table-cell;
            width: 100px;
            font-size: 12px;
            color: #666;
        }

        .meta-value {
            display: table-cell;
            font-size: 12px;
            color: #333;
        }

        /* Items table */
        .items-section {
            margin: 20px 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .items-table thead {
            background-color: #2E5BBA;
            color: white;
        }

        .items-table th {
            padding: 12px 15px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .items-table th.text-center {
            text-align: center;
        }

        .items-table th.text-right {
            text-align: right;
        }

        .items-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            font-size: 12px;
            color: #333;
        }

        .items-table td.text-center {
            text-align: center;
        }

        .items-table td.text-right {
            text-align: right;
        }

        /* Totals section */
        .totals-section {
            padding: 20px 40px;
            text-align: right;
        }

        .total-row {
            margin-bottom: 8px;
            font-size: 12px;
        }

        .total-label {
            display: inline-block;
            width: 100px;
            text-align: right;
            margin-right: 20px;
            color: #666;
        }

        .total-value {
            display: inline-block;
            width: 100px;
            text-align: right;
            color: #333;
        }

        .balance-due {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 2px solid #333;
            font-size: 16px;
            font-weight: bold;
        }

        .balance-due .total-label {
            color: #333;
        }

        /* Notes section */
        .notes-section {
            padding: 20px 40px;
            border-top: 1px solid #eee;
        }

        .notes-title {
            font-size: 12px;
            color: #666;
            margin: 0 0 10px 0;
        }

        .notes-content {
            font-size: 11px;
            color: #666;
            line-height: 1.4;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Blue header bar -->
        <div class="header-bar"></div>

        <!-- Header content -->
        <div class="header-content">
            <div class="header-left">
                <h1 class="invoice-title">Invoice</h1>
            </div>
            <div class="header-right">
                <!-- Company logo -->
                <div class="logo-placeholder">
                    @if (file_exists(public_path('img/logo-01.png')))
                        <img src="{{ asset('img/logo-01.png') }}" alt="Logo" class="company-logo">
                    @else
                        <div class="logo-hexagon"></div>
                    @endif
                </div>
                <div class="company-name">{{ strtoupper($invoice->bisnes->nama_bisnes) }}</div>
                <div class="company-tagline">Company Tagline</div>
            </div>
        </div>

        <!-- Invoice details -->
        <div class="invoice-details">
            <div class="details-left">
                <div class="section-title">From</div>
                <div class="detail-row">
                    <span class="detail-value">{{ $invoice->bisnes->nama_bisnes }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-value">contact@{{ strtolower(str_replace(' ', '', $invoice - > bisnes - > nama_bisnes)) }}.com</span>
                </div>
                <div class="detail-row">
                    <span class="detail-value">Your address</span>
                </div>
                <div class="detail-row">
                    <span class="detail-value">P: (123) 456 7890</span>
                </div>
            </div>
            <div class="details-right">
                <div class="section-title">For</div>
                <div class="detail-row">
                    <span class="detail-value">{{ $invoice->nama_penerima }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-value">client@email.com</span>
                </div>
                <div class="detail-row">
                    <span class="detail-value">{{ $invoice->alamat }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-value">P: {{ $invoice->no_tel }}</span>
                </div>
            </div>
        </div>

        <!-- Invoice metadata -->
        <div class="invoice-meta">
            <div class="meta-row">
                <div class="meta-label">Number</div>
                <div class="meta-value">{{ $invoice->invoice_no }}</div>
            </div>
            <div class="meta-row">
                <div class="meta-label">Date</div>
                <div class="meta-value">{{ $invoice->created_at->format('d M Y') }}</div>
            </div>
            <div class="meta-row">
                <div class="meta-label">Terms</div>
                <div class="meta-value">Net Day</div>
            </div>
            <div class="meta-row">
                <div class="meta-label">Due</div>
                <div class="meta-value">{{ $invoice->created_at->format('d M Y') }}</div>
            </div>
        </div>

        <!-- Items table -->
        <div class="items-section">
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="text-right">Price</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td>
                                <div>{{ $item->product_name }}</div>
                                <div style="font-size: 10px; color: #999;">additional details</div>
                            </td>
                            <td class="text-right">RM{{ number_format($item->harga, 2) }}</td>
                            <td class="text-center">{{ $item->kuantiti }}</td>
                            <td class="text-right">RM{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals section -->
        <div class="totals-section">
            @php
                $subtotal = $invoice->items->sum('total');
                $tax = $subtotal * 0.06; // 6% tax
                $total = $subtotal + $tax;
            @endphp

            <div class="total-row">
                <span class="total-label">Subtotal</span>
                <span class="total-value">RM{{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="total-row">
                <span class="total-label">Tax (6%)</span>
                <span class="total-value">RM{{ number_format($tax, 2) }}</span>
            </div>
            <div class="total-row">
                <span class="total-label">Total</span>
                <span class="total-value">RM{{ number_format($total, 2) }}</span>
            </div>

            <div class="balance-due">
                <span class="total-label">Balance Due</span>
                <span class="total-value">RM{{ number_format($invoice->jumlah, 2) }}</span>
            </div>
        </div>

        <!-- Notes section -->
        @if ($invoice->catatan)
            <div class="notes-section">
                <div class="notes-title">Notes: any relevant info, terms, payment instructions, e.t.c</div>
                <div class="notes-content">{{ $invoice->catatan }}</div>
            </div>
        @else
            <div class="notes-section">
                <div class="notes-title">Notes: any relevant info, terms, payment instructions, e.t.c</div>
            </div>
        @endif
    </div>
</body>

</html>
