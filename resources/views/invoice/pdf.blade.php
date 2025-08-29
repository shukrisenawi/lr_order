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
            line-height: 1.6;
        }

        .header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 30px;
            margin: -20px -20px 30px -20px;
            border-radius: 0 0 10px 10px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .company-info h1 {
            margin: 0 0 5px 0;
            font-size: 28px;
            font-weight: bold;
        }

        .company-info p {
            margin: 0;
            opacity: 0.9;
            font-size: 14px;
        }

        .invoice-info {
            text-align: right;
        }

        .invoice-number {
            font-size: 32px;
            font-weight: bold;
            margin: 0;
        }

        .invoice-label {
            font-size: 12px;
            opacity: 0.9;
            margin: 5px 0 0 0;
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
        }

        .items-table th {
            background-color: #f9fafb;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            color: #374151;
            border: 1px solid #e5e7eb;
        }

        .items-table td {
            padding: 12px;
            border: 1px solid #e5e7eb;
            font-size: 13px;
        }

        .items-table tr:nth-child(even) {
            background-color: #f9fafb;
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
            background-color: #f3f4f6 !important;
            font-weight: bold;
        }

        .total-amount {
            font-size: 16px;
            color: #2563eb;
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
    <div class="header">
        <div class="header-content">
            <div class="company-info">
                <h1>{{ $invoice->bisnes->nama_bisnes }}</h1>
                <p>Business Invoice</p>
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
        <p>Generated on {{ now()->format('d/m/Y H:i:s') }} | {{ $invoice->bisnes->nama_bisnes }}</p>
    </div>
</body>

</html>
