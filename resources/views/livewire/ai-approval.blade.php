<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Create by AI Approval</h1>
                <p class="text-gray-600">Review and approve items created by AI</p>
                <div class="flex gap-4 mt-4">
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-users mr-2"></i>
                        Customers: {{ $customerCount }}
                    </div>
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-file-invoice mr-2"></i>
                        Invoices: {{ $invoiceCount }}
                    </div>
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        <i class="fas fa-calculator mr-2"></i>
                        Total: {{ $customerCount + $invoiceCount }}
                    </div>
                </div>
            </div>
            <div class="flex gap-4">
                @if($activeTab === 'customers' && $customers->count() > 0)
                    <button wire:click="approveAllCustomers"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-xl shadow-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <i class="fas fa-check-circle mr-2"></i>
                        Approve All Customers
                    </button>
                @elseif($activeTab === 'invoices' && $invoices->count() > 0)
                    <button wire:click="approveAllInvoices"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-xl shadow-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <i class="fas fa-check-circle mr-2"></i>
                        Approve All Invoices
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <!-- Tabs -->
    <div class="mb-8">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button
                    wire:click="setActiveTab('customers')"
                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'customers' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} transition-colors">
                    <i class="fas fa-users mr-2"></i>
                    Customers
                    @if($customerCount > 0)
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            {{ $customerCount }}
                        </span>
                    @endif
                </button>
                <button
                    wire:click="setActiveTab('invoices')"
                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'invoices' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} transition-colors">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Invoices
                    @if($invoiceCount > 0)
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            {{ $invoiceCount }}
                        </span>
                    @endif
                </button>
            </nav>
        </div>
    </div>

    <!-- Tab Content -->
    @if($activeTab === 'customers')
        <!-- Customer Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Alamat</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No Tel</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Created</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($customers as $customer)
                            <tr class="hover:bg-blue-50 transition-colors duration-200" wire:key="customer-{{ $customer->id }}">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $customer->gelaran }} {{ $customer->nama_penerima }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $customer->alamat }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $customer->no_tel }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $customer->email ?: '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $customer->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('customer.show', $customer) }}"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-amber-700 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors duration-200">
                                            <i class="fas fa-eye mr-1"></i>
                                            View
                                        </a>
                                        <button wire:click="approveCustomer({{ $customer->id }})"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            <i class="fas fa-check mr-2"></i>
                                            Approve
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gray-100 rounded-full p-4 mb-4">
                                            <i class="fas fa-users text-gray-400 text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-1">No pending customers</h3>
                                        <p class="text-gray-500">All customers have been approved.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @elseif($activeTab === 'invoices')
        <!-- Invoice Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Invoice No</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama Penerima</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Alamat</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No Tel</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Created</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($invoices as $invoice)
                            <tr class="hover:bg-green-50 transition-colors duration-200" wire:key="invoice-{{ $invoice->id }}">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $invoice->invoice_no }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $invoice->nama_penerima }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $invoice->alamat }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $invoice->no_tel }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-green-600">RM {{ number_format($invoice->jumlah, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($invoice->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($invoice->status === 'paid') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $invoice->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('invoice.show', $invoice) }}"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                            <i class="fas fa-eye mr-1"></i>
                                            View
                                        </a>
                                        <button wire:click="approveInvoice({{ $invoice->id }})"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            <i class="fas fa-check mr-2"></i>
                                            Approve
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gray-100 rounded-full p-4 mb-4">
                                            <i class="fas fa-file-invoice text-gray-400 text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-1">No pending invoices</h3>
                                        <p class="text-gray-500">All invoices have been approved.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>