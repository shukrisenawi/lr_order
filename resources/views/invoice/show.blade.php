@extends('layouts.app')

@section('title', 'Invoice Details')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Invoice {{ $invoice->invoice_no }}</h1>
                    <p class="text-gray-600 mt-1">Created on {{ $invoice->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="flex space-x-3">
                    @if(request('from') === 'ai')
                        <a href="{{ route('ai') }}"
                            class="inline-flex items-center px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to AI Approval
                        </a>
                    @else
                        <a href="{{ route('invoice.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Invoices
                        </a>
                    @endif
                    <a href="{{ route('invoice.edit', $invoice) }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Invoice
                    </a>
                    <a href="{{ route('invoice.pdf', $invoice) }}"
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Download PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $invoice->bisnes->nama_bisnes }}</h2>
                        <p class="text-blue-100 mt-1">Business Invoice</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold">{{ $invoice->invoice_no }}</div>
                        <div class="text-blue-100">Invoice Number</div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Invoice Info and Customer Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Invoice Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice Information</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Invoice Date:</span>
                                <span class="font-medium">{{ $invoice->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full
                                @if ($invoice->status === 'paid') bg-green-100 text-green-800
                                @elseif($invoice->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </div>
                            @if ($invoice->kurier)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Courier:</span>
                                    <span class="font-medium">{{ $invoice->kurier }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h3>
                        <div class="space-y-2">
                            <div>
                                <span class="text-gray-600">Name:</span>
                                <div class="font-medium">{{ $invoice->nama_penerima }}</div>
                            </div>
                            <div>
                                <span class="text-gray-600">Phone:</span>
                                <div class="font-medium">{{ $invoice->no_tel }}</div>
                            </div>
                            <div>
                                <span class="text-gray-600">Address:</span>
                                <div class="font-medium">{{ $invoice->alamat }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Items -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice Items</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full border border-gray-200 rounded-lg">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Item</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">Quantity</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">Unit Price</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($invoice->items as $item)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-gray-900">
                                                {{ $item->product_name }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center">{{ $item->kuantiti }}</td>
                                        <td class="px-4 py-3 text-right">RM {{ number_format($item->harga, 2) }}</td>
                                        <td class="px-4 py-3 text-right font-medium">RM
                                            {{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right font-semibold text-gray-900">Total
                                        Amount:</td>
                                    <td class="px-4 py-3 text-right font-bold text-lg text-blue-600">
                                        RM {{ number_format($invoice->jumlah, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Notes -->
                @if ($invoice->catatan)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Notes</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700">{{ $invoice->catatan }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
