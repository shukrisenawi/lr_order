<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Invoice</title>
    <style>
        :root {
            --accent: #1e66b6;
            --muted: #6b7280;
            --line: #e5e7eb;
            --heading: #111827;
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            font: 14px/1.5 system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, "Noto Sans", sans-serif;
            color: #1f2937;
            background: #fff;
        }

        .page {
            max-width: 816px;
            margin: 24px auto;
            padding: 28px;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .05);
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            padding: 8px 0 24px;
            border-bottom: 1px solid var(--line);
        }

        .title {
            font-size: 28px;
            font-weight: 700;
            color: #374151;
        }

        .brand {
            text-align: right;
            line-height: 1.1;
        }

        .brand .name {
            font-weight: 800;
        }

        .brand .tag {
            font-size: 11px;
            color: #ef4444;
        }

        .logo {
            width: 90px;
            height: 90px;
            object-fit: contain;
            display: block;
            margin-left: auto;
            margin-bottom: 6px;
        }

        .parties {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
            padding: 22px 0;
            border-bottom: 1px solid var(--line);
        }

        .party h4 {
            margin: 0 0 4px;
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase
        }

        .party .company {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 4px;
            color: var(--heading);
        }

        .meta {
            display: grid;
            grid-template-columns: repeat(4, minmax(110px, 1fr));
            gap: 16px;
            padding: 4px 0 14px;
        }

        .meta .box {
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 10px 12px;
            background: #fafafa;
        }

        .meta .label {
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
        }

        .meta .value {
            font-weight: 700;
            color: #111827
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 10px;
        }

        thead th {
            background: var(--accent);
            color: #fff;
            font-weight: 700;
            padding: 10px 12px;
            text-align: left;
            font-size: 13px;
        }

        tbody td {
            border-bottom: 1px solid var(--line);
            padding: 12px;
            vertical-align: top;
        }

        tbody tr:last-child td {
            border-bottom: none
        }

        .desc {
            width: 58%
        }

        .price,
        .qty,
        .amount {
            width: 14%;
            text-align: right
        }

        .notes {
            border-top: 1px solid var(--line);
            margin-top: 24px;
            padding-top: 12px;
            color: #4b5563;
            font-size: 13px;
        }

        .totals {
            width: 100%;
            margin-top: 18px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 12px;
            align-items: end;
        }

        .total-table {
            width: 320px;
            margin-left: auto;
            border-collapse: separate;
            border-spacing: 0;
        }

        .total-table td {
            padding: 8px 0;
            font-size: 14px;
        }

        .total-table td:nth-child(1) {
            color: #374151
        }

        .total-table td:nth-child(2) {
            text-align: right;
            font-weight: 600
        }

        .balance-row td {
            padding-top: 14px;
            border-top: 2px solid var(--line);
            font-size: 18px;
            font-weight: 800;
            color: #111827;
        }

        .toolbar {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            margin-top: 16px;
        }

        .btn {
            border: none;
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            background: var(--accent);
            color: #fff;
            box-shadow: 0 2px 8px rgba(30, 102, 182, .25);
        }

        .btn.secondary {
            background: #f3f4f6;
            color: #111827;
            box-shadow: none;
            border: 1px solid var(--line)
        }

        @media print {
            .page {
                box-shadow: none;
                border: none;
                margin: 0;
                border-radius: 0
            }

            .toolbar {
                display: none
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <header>
            <div class="title">Invoice</div>
            <div class="brand">
                @if (file_exists(public_path('img/logo-01.png')))
                    <img class="logo" src="{{ asset('img/logo-01.png') }}" alt="Logo">
                @else
                    <img class="logo" src="https://dummyimage.com/300x300/ffffff/cccccc&text=LOGO" alt="Logo">
                @endif
                <div class="name">{{ strtoupper($invoice->bisnes->nama_bisnes ?? 'YOUR COMPANY NAME') }}</div>
                <div class="tag">COMPANY TAGLINE</div>
            </div>
        </header>

        <section class="parties">
            <div class="party">
                <h4>From</h4>
                <div class="company">{{ $invoice->bisnes->nama_bisnes ?? 'Business name' }}</div>
                <div>contact@{{ strtolower(str_replace(' ', '', $invoice->bisnes->nama_bisnes ?? 'business')) }}.com</div>
                <div>Your address</div>
                <div>P: (123) 456 7890</div>
            </div>
            <div class="party">
                <h4>For</h4>
                <div class="company">{{ $invoice->nama_penerima ?? 'Client name' }}</div>
                <div>client@email.com</div>
                <div>{{ $invoice->alamat ?? 'Client address' }}</div>
                <div>P: {{ $invoice->no_tel ?? '099 876 54321' }}</div>
            </div>
        </section>

        <section class="meta">
            <div class="box">
                <div class="label">Number</div>
                <div class="value">{{ $invoice->invoice_no ?? 'INV0001' }}</div>
            </div>
            <div class="box">
                <div class="label">Date</div>
                <div class="value">{{ $invoice->created_at ? $invoice->created_at->format('d M Y') : '04 May 2018' }}
                </div>
            </div>
            <div class="box">
                <div class="label">Terms</div>
                <div class="value">{{ $invoice->kurier ?? 'Next Day' }}</div>
            </div>
            <div class="box">
                <div class="label">Due</div>
                <div class="value">
                    {{ $invoice->created_at ? $invoice->created_at->addDays(1)->format('d M Y') : '05 May 2018' }}</div>
            </div>
        </section>

        <section class="items">
            <table>
                <thead>
                    <tr>
                        <th class="desc">Description</th>
                        <th class="price">Price</th>
                        <th class="qty">Qty</th>
                        <th class="amount">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoice->items ?? [] as $item)
                        <tr>
                            <td class="desc">{{ $item->product_name ?? 'Line item' }}<br><span
                                    style="color:var(--muted); font-size:12px;">{{ $item->produk_custom ?? 'additional details' }}</span>
                            </td>
                            <td class="price">RM{{ number_format($item->harga ?? 99.0, 2) }}</td>
                            <td class="qty">{{ $item->kuantiti ?? 1 }}</td>
                            <td class="amount">
                                RM{{ number_format(($item->harga ?? 99.0) * ($item->kuantiti ?? 1), 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="desc">Line item<br><span style="color:var(--muted); font-size:12px;">additional
                                    details</span></td>
                            <td class="price">RM99.00</td>
                            <td class="qty">1</td>
                            <td class="amount">RM99.00</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <section class="totals">
            <div></div>
            <table class="total-table">
                @php
                    $subtotal = $invoice->items
                        ? $invoice->items->sum(function ($item) {
                            return $item->harga * $item->kuantiti;
                        })
                        : 99.0;
                    $tax = $subtotal * 0.07; // 7% tax
                    $total = $subtotal + $tax;
                @endphp
                <tr>
                    <td>Subtotal</td>
                    <td>RM{{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax (7%)</td>
                    <td>RM{{ number_format($tax, 2) }}</td>
                </tr>
                <tr>
                    <td style="font-weight:800;">Total</td>
                    <td>RM{{ number_format($total, 2) }}</td>
                </tr>
                <tr class="balance-row">
                    <td>Balance Due</td>
                    <td>RM{{ number_format($invoice->jumlah ?? $total, 2) }}</td>
                </tr>
            </table>
        </section>

        <section class="notes">
            <strong>Notes:</strong> {{ $invoice->catatan ?? 'any relevant info, terms, payment instructions, etc.' }}
        </section>

        <div class="toolbar">
            @if(isset($invoice) && $invoice)
                <a href="{{ route('invoice.show', $invoice) }}" class="btn secondary" style="text-decoration: none;">Back to Invoice</a>
                <a href="{{ route('invoice.download-pdf', $invoice) }}" class="btn" style="text-decoration: none; background: #059669; box-shadow: 0 2px 8px rgba(5, 150, 105, .25);">Download PDF</a>
            @else
                <button class="btn secondary" onclick="window.location.reload()">Reset</button>
            @endif
            <button class="btn" onclick="window.print()">Print</button>
        </div>
    </div>
</body>

</html>
