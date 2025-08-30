<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_no }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            color: #2d3748;
            line-height: 1.6;
            background: #f8fafc;
        }

        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
                        radial-gradient(circle at 40% 40%, rgba(255,255,255,0.05) 0%, transparent 50%);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .company-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
        }

        .company-details h1 {
            margin: 0 0 5px 0;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .company-details p {
            margin: 0;
            opacity: 0.9;
            font-size: 16px;
            font-weight: 300;
        }

        .invoice-info {
            text-align: right;
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .invoice-number {
            font-size: 36px;
            font-weight: 800;
            margin: 0;
            letter-spacing: -1px;
        }

        .invoice-label {
            font-size: 14px;
            opacity: 0.9;
            margin: 5px 0 0 0;
            font-weight: 300;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .info-box {
            width: 48%;
        }

        .info-box h3 {
            color: #2563eb;
            font-size: 16px;
            margin: 0 0 15px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #e5e7eb;
        }

        .info-item {
            margin-bottom: 8px;
        }

        .info-label {
            color: #6b7280;
            font-size: 12px;
            display: block;
        }

        .info-value {
            font-weight: 600;
            font-size: 14px;
        }

        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status.pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status.paid {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status.cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .items-section {
            margin-bottom: 30px;
        }

        .items-section h3 {
            color: #2563eb;
            font-size: 16px;
            margin: 0 0 15px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #e5e7eb;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .items-table th {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 16px 12px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            color: #475569;
            border: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table td {
            padding: 16px 12px;
            border: none;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #334155;
        }

        .items-table tr:nth-child(even) {
            background-color: #fafbfc;
        }

        .items-table tr:hover {
            background-color: #f8fafc;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-medium {
            font-weight: 600;
        }

        .total-row {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .total-row td {
            border: none !important;
            color: white !important;
        }

        .total-amount {
            font-size: 18px;
            font-weight: 800;
            color: #fbbf24;
        }

        .notes-section {
            margin-top: 30px;
        }

        .notes-section h3 {
            color: #2563eb;
            font-size: 16px;
            margin: 0 0 15px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #e5e7eb;
        }

        .notes-content {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #2563eb;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="container">
        <div class="header">
            <div class="header-content">
                <div class="company-info">
                    <div class="logo">
                        <img src="{{ public_path('img/logo-01.png') }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain; border-radius: 8px;">
                    </div>
                    <div class="company-details">
                        <h1>{{ $invoice->bisnes->nama_bisnes }}</h1>
                        <p>Professional Business Invoice</p>
                    </div>
                </div>
                <div class="invoice-info">
                    <div class="invoice-number">{{ $invoice->invoice_no }}</div>
                    <p class="invoice-label">Invoice Number</p>
                </div>
            </div>
        </div>

    <!-- Invoice and Customer Information -->
    <div class="info-section">
        <!-- Invoice Information -->
        <div class="info-box">
            <h3>Invoice Information</h3>
            <div class="info-item">
                <span class="info-label">Invoice Date:</span>
                <div class="info-value">{{ $invoice->created_at->format('d/m/Y') }}</div>
            </div>
            <div class="info-item">
                <span class="info-label">Status:</span>
                <div class="info-value">
                    <span class="status {{ $invoice->status }}">{{ ucfirst($invoice->status) }}</span>
                </div>
            </div>
            @if ($invoice->kurier)
                <div class="info-item">
                    <span class="info-label">Courier:</span>
                    <div class="info-value">{{ $invoice->kurier }}</div>
                </div>
            @endif
        </div>

        <!-- Customer Information -->
        <div class="info-box">
            <h3>Customer Information</h3>
            <div class="info-item">
                <span class="info-label">Name:</span>
                <div class="info-value">{{ $invoice->nama_penerima }}</div>
            </div>
            <div class="info-item">
                <span class="info-label">Phone:</span>
                <div class="info-value">{{ $invoice->no_tel }}</div>
            </div>
            <div class="info-item">
                <span class="info-label">Address:</span>
                <div class="info-value">{{ $invoice->alamat }}</div>
            </div>
        </div>
    </div>

    <!-- Invoice Items -->
    <div class="items-section">
        <h3>Invoice Items</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Item</th>
                    <th style="width: 15%;" class="text-center">Quantity</th>
                    <th style="width: 17.5%;" class="text-right">Unit Price</th>
                    <th style="width: 17.5%;" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td class="font-medium">{{ $item->product_name }}</td>
                        <td class="text-center">{{ $item->kuantiti }}</td>
                        <td class="text-right">RM {{ number_format($item->harga, 2) }}</td>
                        <td class="text-right font-medium">RM {{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="text-right font-medium">Total Amount:</td>
                    <td class="text-right total-amount">RM {{ number_format($invoice->jumlah, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Notes -->
    @if ($invoice->catatan)
        <div class="notes-section">
            <h3>Notes</h3>
            <div class="notes-content">
                {{ $invoice->catatan }}
            </div>
        </div>
    @endif

        <!-- Footer -->
        <div class="footer">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 0;">
                <div>
                    <p style="margin: 0; font-size: 12px; color: #64748b;">
                        Generated on {{ now()->format('d/m/Y H:i:s') }}
                    </p>
                    <p style="margin: 5px 0 0 0; font-size: 11px; color: #94a3b8;">
                        Thank you for your business!
                    </p>
                </div>
                <div style="text-align: right;">
                    <p style="margin: 0; font-size: 12px; color: #64748b; font-weight: 600;">
                        {{ $invoice->bisnes->nama_bisnes }}
                    </p>
                    <p style="margin: 5px 0 0 0; font-size: 11px; color: #94a3b8;">
                        Professional Invoice Service
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
