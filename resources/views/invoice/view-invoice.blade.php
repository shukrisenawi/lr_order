<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Invoice</title>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                /* Chrome/Edge */
                print-color-adjust: exact;
                /* Standard */
                color-adjust: exact;
                /* Firefox */
            }
        }

        @media print {
            .colored {
                background-color: red !important;
                -webkit-print-color-adjust: exact;
            }
        }

        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }

            .footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                text-align: center;
                font-size: 12px;
                color: #555;
            }
        }

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
                <img style="max-width: 150px"
                    src="{{ \App\Helpers\ImageHelper::businessImageUrl($invoice->bisnes->gambar) }}" alt="Logo">
            </div>
        </header>

        <section class="parties">
            <div class="party">
                <h4>From</h4>
                <div class="company">{{ $invoice->bisnes->nama_bisnes }}</div>
                <div>{!! str_replace(',', ',<br>', $invoice->bisnes->alamat) !!}</div>

                <div>{{ $invoice->bisnes->no_tel }}</div>
            </div>
            <div class="party">
                <h4>For</h4>
                <div class="company">{{ $invoice->nama_penerima }}</div>
                <div>{!! str_replace(',', ',<br>', $invoice->alamat) !!}</div>
                <div>{{ $invoice->no_tel }}</div>
            </div>
        </section>

        <section class="flex meta gap-5 ">
            <div class="box">
                <div class="label">Number</div>
                <div class="value">{{ $invoice->invoice_no ?? '' }}</div>
            </div>
            <div class="box">
                <div class="label">Date</div>
                <div class="value">{{ $invoice->created_at ? $invoice->created_at->format('d M Y') : '' }}
                </div>
            </div>
            @if ($invoice->kurier)
                <div class="box">
                    <div class="label">Kurier</div>
                    <div class="value">{{ $invoice->kurier }}</div>
                </div>
            @endif
            @if ($invoice->status == 'unpaid')
                <div class="box">
                    <div class="label">Due</div>
                    <div class="value">
                        {{ $invoice->created_at ? $invoice->created_at->addDays(30)->format('d M Y') : '' }}
                    </div>
                </div>
            @elseif($invoice->status == 'paid')
                <div class="box">
                    <div class="label">Payment</div>
                    <div class="value">
                        PAID
                    </div>
                </div>
            @endif
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
                            <td class="desc">{{ $item->product_name }} </td>
                            <td class="price">RM{{ number_format($item->harga ?? '0.00') }}</td>
                            <td class="qty">{{ $item->kuantiti ?? 0 }}</td>
                            <td class="amount">
                                RM{{ number_format(($item->harga ?? '0.00') * ($item->kuantiti ?? 0), 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="desc" colspan="4">Tiada item</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <table class="total-table">
            @php
                $subtotal = $invoice->items
                    ? $invoice->items->sum(function ($item) {
                        return $item->harga * $item->kuantiti;
                    })
                    : '0.00';
                $tax = $subtotal * 0.0; // 7% tax
                $total = $subtotal + $tax;
            @endphp
            <tr>
                <td style="text-right"></td>
                <td style="font-size:15px; font-weight:bold; padding-right:10px">Total :
                    &nbsp;&nbsp;&nbsp;&nbsp;RM{{ number_format($total, 2) }}</td>
            </tr>
        </table>

        <section class="notes footer">
            <strong>Notes:</strong> {{ $invoice->catatan ?? 'any relevant info, terms, payment instructions, etc.' }}
        </section>

        <div class="toolbar">
            @if (isset($invoice) && $invoice)
                <a href="{{ route('invoice.show', $invoice) }}" class="btn secondary"
                    style="text-decoration: none;">Back to Invoice</a>
            @else
                <button class="btn secondary" onclick="window.location.reload()">Reset</button>
            @endif
            <button class="btn" onclick="window.print()">Print</button>
        </div>
    </div>
</body>

</html>
