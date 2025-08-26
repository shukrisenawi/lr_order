@extends('layouts.app')

@section('title', 'J&T Express API Settings')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-light text-gray-800 mb-2">J&T Express API Settings</h1>
            <p class="text-gray-500">Configure and manage J&T Express shipping integration</p>
        </div>

        <!-- API Configuration -->
        <div class="bg-white border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">API Configuration</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">API Endpoint</label>
                    <input type="text" value="https://demoopenapi.jtexpress.my/webopenplatformapi/api/order/addOrder"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" readonly>
                    <p class="mt-1 text-sm text-gray-500">Testing environment endpoint</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">API Account</label>
                    <input type="text" value="640826271705595946"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" readonly>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Private Key</label>
                    <input type="password" value="8e88c8477d4e4939859c560192fcafbc"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" readonly>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Request Method</label>
                    <input type="text" value="POST"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" readonly>
                </div>
            </div>
        </div>

        <!-- Test Order Form -->
        <div class="bg-white border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Test Order Submission</h3>

            <form id="jtExpressForm" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Customer Code *</label>
                        <input type="text" name="customerCode" value="ITTEST0001"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Order Number *</label>
                        <input type="text" name="txlogisticId" value="YLTEST202404101519"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Express Type *</label>
                        <select name="expressType"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="EZ">EZ (Standard)</option>
                            <option value="EX">EX (Express)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Weight (kg) *</label>
                        <input type="number" name="weight" value="10" step="0.01"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Sender Information -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Sender Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                            <input type="text" name="sender[name]" value="J&T sender"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                            <input type="text" name="sender[phone]" value="60123456"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Postcode *</label>
                            <input type="text" name="sender[postCode]" value="81930"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Country Code *</label>
                            <input type="text" name="sender[countryCode]" value="MYS"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <input type="text" name="sender[address]" value="No 32, Jalan Kempas 4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                            <input type="text" name="sender[prov]" value="Johor"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                            <input type="text" name="sender[city]" value="Bandar Penawar"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Area *</label>
                            <input type="text" name="sender[area]" value="Taman Desaru Utama"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Receiver Information -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Receiver Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                            <input type="text" name="receiver[name]" value="J&T receiver"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                            <input type="text" name="receiver[phone]" value="60987654"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Postcode *</label>
                            <input type="text" name="receiver[postCode]" value="31000"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Country Code *</label>
                            <input type="text" name="receiver[countryCode]" value="MYS"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <input type="text" name="receiver[address]" value="4678, Laluan Sentang 35"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                            <input type="text" name="receiver[prov]" value="Perak"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                            <input type="text" name="receiver[city]" value="Batu Gajah"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Area *</label>
                            <input type="text" name="receiver[area]" value="Kampung Seri Mariah"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Items -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Items</h4>
                    <div id="items-container">
                        <div class="item-row grid grid-cols-1 md:grid-cols-6 gap-4 mb-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Item Name *</label>
                                <input type="text" name="items[0][itemName]" value="basketball"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                                <input type="number" name="items[0][number]" value="2"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Value *</label>
                                <input type="number" name="items[0][itemValue]" value="50" step="0.01"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg) *</label>
                                <input type="number" name="items[0][weight]" value="10" step="0.01"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="flex items-end">
                                <button type="button"
                                    class="remove-item w-full px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                                    Remove
                                </button>
                            </div>
                        </div>

                        <div class="item-row grid grid-cols-1 md:grid-cols-6 gap-4 mb-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Item Name *</label>
                                <input type="text" name="items[1][itemName]" value="phone"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                                <input type="number" name="items[1][number]" value="1"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Value *</label>
                                <input type="number" name="items[1][itemValue]" value="4000" step="0.01"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg) *</label>
                                <input type="number" name="items[1][weight]" value="100" step="0.01"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="flex items-end">
                                <button type="button"
                                    class="remove-item w-full px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-item"
                        class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Add Item
                    </button>
                </div>

                <!-- Submit Button -->
                <div class="border-t border-gray-200 pt-6">
                    <button type="submit"
                        class="px-6 py-3 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Send Order to J&T Express
                    </button>
                </div>
            </form>

            <!-- Response Display -->
            <div id="response-container" class="mt-6 hidden">
                <h4 class="text-md font-medium text-gray-900 mb-2">API Response</h4>
                <pre id="response-content" class="bg-gray-50 border border-gray-200 p-4 rounded-md overflow-x-auto"></pre>
            </div>
        </div>
    </div>

    <!-- JavaScript for form handling -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('jtExpressForm');
            const addItemButton = document.getElementById('add-item');
            const itemsContainer = document.getElementById('items-container');
            const responseContainer = document.getElementById('response-container');
            const responseContent = document.getElementById('response-content');

            // Add item button click handler
            addItemButton.addEventListener('click', function() {
                const itemIndex = itemsContainer.children.length;
                const itemRow = document.createElement('div');
                itemRow.className = 'item-row grid grid-cols-1 md:grid-cols-6 gap-4 mb-4';
                itemRow.innerHTML = `
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Item Name *</label>
                        <input type="text"
                               name="items[${itemIndex}][itemName]"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                        <input type="number"
                               name="items[${itemIndex}][number]"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Value *</label>
                        <input type="number"
                               name="items[${itemIndex}][itemValue]"
                               step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg) *</label>
                        <input type="number"
                               name="items[${itemIndex}][weight]"
                               step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="flex items-end">
                        <button type="button" class="remove-item w-full px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                            Remove
                        </button>
                    </div>
                `;
                itemsContainer.appendChild(itemRow);

                // Add event listener to the new remove button
                const removeButton = itemRow.querySelector('.remove-item');
                removeButton.addEventListener('click', function() {
                    itemsContainer.removeChild(itemRow);
                });
            });

            // Add event listeners to existing remove buttons
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const itemRow = this.closest('.item-row');
                    itemsContainer.removeChild(itemRow);
                });
            });

            // Form submission handler
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Get form data
                const formData = new FormData(form);
                const data = {};

                // Convert FormData to JSON
                for (const [key, value] of formData.entries()) {
                    // Handle array fields like items
                    if (key.startsWith('items')) {
                        const match = key.match(/items\[(\d+)\]\[(\w+)\]/);
                        if (match) {
                            const index = match[1];
                            const field = match[2];
                            if (!data.items) data.items = [];
                            if (!data.items[index]) data.items[index] = {};
                            data.items[index][field] = value;
                        }
                    } else {
                        data[key] = value;
                    }
                }

                // Remove any undefined items
                if (data.items) {
                    data.items = data.items.filter(item => item !== undefined);
                }

                // Send request to server
                fetch('/settings/jt-express/send-order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(result => {
                        // Display response
                        responseContent.textContent = JSON.stringify(result, null, 2);
                        responseContainer.classList.remove('hidden');

                        // Show success or error message
                        if (result.success) {
                            responseContent.classList.remove('bg-red-50', 'text-red-700');
                            responseContent.classList.add('bg-green-50', 'text-green-700');
                        } else {
                            responseContent.classList.remove('bg-green-50', 'text-green-700');
                            responseContent.classList.add('bg-red-50', 'text-red-700');
                        }
                    })
                    .catch(error => {
                        // Display error
                        responseContent.textContent = 'Error: ' + error.message;
                        responseContent.classList.remove('bg-green-50', 'text-green-700');
                        responseContent.classList.add('bg-red-50', 'text-red-700');
                        responseContainer.classList.remove('hidden');
                    });
            });
        });
    </script>
@endsection
