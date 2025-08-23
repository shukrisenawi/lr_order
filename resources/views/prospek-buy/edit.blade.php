@extends('layouts.app')

@section('title', 'Edit Purchase')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Purchase</h1>
                <p class="text-gray-600">Update purchase information</p>
            </div>
            <a href="{{ route('prospek-buy.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Purchase Information</h3>
        </div>
        
        <form method="POST" action="{{ route('prospek-buy.update', $prospekBuy) }}" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Prospect -->
                <div>
                    <label for="prospek_id" class="block text-sm font-medium text-gray-700 mb-2">Prospect</label>
                    <select name="prospek_id" id="prospek_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('prospek_id') border-red-500 @enderror">
                        <option value="">Select Prospect</option>
                        @foreach($prospek as $prospect)
                            <option value="{{ $prospect->id }}" {{ old('prospek_id', $prospekBuy->prospek_id) == $prospect->id ? 'selected' : '' }}>
                                {{ $prospect->gelaran }} - {{ $prospect->no_tel }}
                            </option>
                        @endforeach
                    </select>
                    @error('prospek_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Product -->
                <div>
                    <label for="produk_id" class="block text-sm font-medium text-gray-700 mb-2">Product</label>
                    <select name="produk_id" id="produk_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('produk_id') border-red-500 @enderror">
                        <option value="">Select Product</option>
                        @foreach($produk as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}" {{ old('produk_id', $prospekBuy->produk_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} - RM {{ number_format($product->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('produk_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity -->
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $prospekBuy->quantity) }}" min="1"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('quantity') border-red-500 @enderror">
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Unit Price (RM)</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $prospekBuy->price) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('price') border-red-500 @enderror">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Purchase Date -->
                <div>
                    <label for="purchase_date" class="block text-sm font-medium text-gray-700 mb-2">Purchase Date</label>
                    <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', $prospekBuy->purchase_date ? $prospekBuy->purchase_date->format('Y-m-d') : '') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('purchase_date') border-red-500 @enderror">
                    @error('purchase_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Total (Calculated) -->
                <div>
                    <label for="total" class="block text-sm font-medium text-gray-700 mb-2">Total Amount (RM)</label>
                    <input type="text" id="total" readonly 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                    <textarea name="notes" id="notes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('notes') border-red-500 @enderror">{{ old('notes', $prospekBuy->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('prospek-buy.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    Update Purchase
                </button>
            </div>
        </form>
    </div>

    <script>
        // Auto-fill price when product is selected and calculate total
        document.getElementById('produk_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            if (price) {
                document.getElementById('price').value = price;
                calculateTotal();
            }
        });

        // Calculate total when quantity or price changes
        document.getElementById('quantity').addEventListener('input', calculateTotal);
        document.getElementById('price').addEventListener('input', calculateTotal);

        function calculateTotal() {
            const quantity = parseFloat(document.getElementById('quantity').value) || 0;
            const price = parseFloat(document.getElementById('price').value) || 0;
            const total = quantity * price;
            document.getElementById('total').value = 'RM ' + total.toFixed(2);
        }

        // Initial calculation
        calculateTotal();
    </script>
@endsection
