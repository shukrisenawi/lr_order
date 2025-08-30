@extends('layouts.app')

@section('title', 'Butiran Invoice')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Butiran Invoice</h1>
                <p class="text-gray-600">Maklumat lengkap untuk {{ $invoice->invoice_no }}</p>
                <div class="flex items-center gap-4 mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-hashtag mr-1"></i>
                        ID: {{ $invoice->id }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($invoice->status === 'paid') bg-green-100 text-green-800
                        @elseif($invoice->status === 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        <i class="fas fa-circle mr-1"></i>
                        {{ ucfirst($invoice->status) }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        <i class="fas fa-calendar mr-1"></i>
                        Dibuat: {{ $invoice->created_at->format('d M Y') }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-money-bill-wave mr-1"></i>
                        RM {{ number_format($invoice->jumlah, 2) }}
                    </span>
                    @if($invoice->create_by_ai)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            <i class="fas fa-robot mr-1"></i>
                            AI Generated
                        </span>
                    @endif
                </div>
            </div>
            <div class="flex gap-4">
                @if(request('from') === 'ai')
                    <a href="{{ route('ai') }}?tab={{ request('tab', 'invoices') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-medium rounded-xl shadow-lg hover:from-purple-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke AI Approval
                    </a>
                @else
                    <a href="{{ route('invoice.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Senarai
                    </a>
                @endif
                <a href="{{ route('invoice.edit', $invoice) }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Invoice
                </a>
                <a href="{{ route('invoice.pdf', $invoice) }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-xl shadow-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <i class="fas fa-file-pdf mr-2"></i>
                    Muat Turun PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Information Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Invoice Information -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-file-invoice mr-3"></i>
                    Maklumat Invoice
                </h2>
            </div>
            <div class="p-6">
                <dl class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Invoice No</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $invoice->invoice_no }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Tarikh Dibuat</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $invoice->created_at->format('d M Y H:i') }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Status</dt>
                        <dd class="text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                @if($invoice->status === 'paid') bg-green-100 text-green-800
                                @elseif($invoice->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                <i class="fas fa-circle mr-1"></i>
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </dd>
                    </div>
                    @if($invoice->kurier)
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Kurier</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $invoice->kurier }}</dd>
                    </div>
                    @endif
                    <div class="flex justify-between items-center py-3">
                        <dt class="text-sm font-semibold text-gray-600">Jumlah Keseluruhan</dt>
                        <dd class="text-lg font-bold text-green-600">RM {{ number_format($invoice->jumlah, 2) }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-user mr-3"></i>
                    Maklumat Customer
                </h2>
            </div>
            <div class="p-6">
                <dl class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Nama Penerima</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $invoice->nama_penerima }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">No Telefon</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $invoice->no_tel }}</dd>
                    </div>
                    <div class="py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600 mb-2">Alamat</dt>
                        <dd class="text-sm text-gray-900">{{ $invoice->alamat }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <dt class="text-sm font-semibold text-gray-600">Business</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $invoice->bisnes->nama_bisnes }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Invoice Items -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
            <h2 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-shopping-cart mr-3"></i>
                Item Invoice
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Item</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Kuantiti</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Harga Unit</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($invoice->items as $item)
                        <tr class="hover:bg-orange-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->product_name }}</td>
                            <td class="px-6 py-4 text-sm text-center text-gray-600">{{ $item->kuantiti }}</td>
                            <td class="px-6 py-4 text-sm text-right text-gray-600">RM {{ number_format($item->harga, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-right font-medium text-gray-900">RM {{ number_format($item->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center">
                                <div class="text-gray-400">
                                    <i class="fas fa-shopping-cart text-3xl mb-2"></i>
                                    <p>Tiada item dalam invoice ini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-gray-900">JUMLAH KESELURUHAN</td>
                        <td class="px-6 py-4 text-right text-lg font-bold text-green-600">RM {{ number_format($invoice->jumlah, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Notes Section -->
    @if ($invoice->catatan)
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-sticky-note mr-3"></i>
                    Catatan
                </h2>
            </div>
            <div class="p-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700">{{ $invoice->catatan }}</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
