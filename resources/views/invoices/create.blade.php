@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md border border-gray-200 my-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Create Sales Invoice</h2>

    <!-- Display validation errors -->
    @if ($errors->any())
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf

        <!-- Customer and Date Selection -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Customer *</label>
                <select name="customer_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Invoice Date *</label>
                <input type="date" name="invoice_date" value="{{ date('Y-m-d') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <!-- Dynamic Product Items Section -->
        <div class="flex items-center justify-between mt-6 mb-3">
            <h3 class="text-lg font-semibold text-gray-700">Invoice Items (Products)</h3>
            <button type="button" id="add-product-btn" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 px-3 py-1.5 rounded-lg text-sm font-semibold border border-indigo-200 transition-colors">
                + Add Another Product
            </button>
        </div>

        <div id="product-rows-container" class="space-y-3 mb-6">
            <!-- Initial Product Row -->
            <div class="product-row grid grid-cols-12 gap-3 bg-gray-50 p-4 rounded-lg border border-gray-200 items-end">
                <div class="col-span-5">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Product *</label>
                    <select name="products[0][product_id]" class="product-select w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-indigo-500" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                        @php
                        $price = $product->selling_price ?? $product->price ?? $product->unit_price ?? 0;
                        @endphp
                        <option value="{{ $product->id }}" data-price="{{ $price }}" data-stock="{{ $product->stock_quantity }}">
                            {{ $product->name }} (Stock: {{ $product->stock_quantity }}) - Rs. {{ number_format($price, 2) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Quantity *</label>
                    <input type="number" name="products[0][quantity]" value="1" min="1" class="quantity-input w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                </div>
                <div class="col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Unit Price (Rs.) *</label>
                    <input type="number" step="0.01" name="products[0][unit_price]" class="unit-price-input w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100" readonly required>
                </div>
                <div class="col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Row Total (Rs.)</label>
                    <input type="number" step="0.01" class="row-total-input w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100" value="0.00" readonly>
                </div>
                <div class="col-span-1 text-center">
                    <button type="button" class="remove-row-btn text-rose-500 hover:text-rose-700 font-bold p-2 hidden">✕</button>
                </div>
            </div>
        </div>

        <!-- Calculation Summary Section -->
        <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subtotal (Rs.)</label>
                    <input type="number" step="0.01" id="subtotal" name="subtotal" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white font-semibold text-gray-800" value="0.00" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Discount (Rs.)</label>
                    <input type="number" step="0.01" id="discount" name="discount" value="0.00" min="0" class="calculation-trigger w-full border border-gray-300 rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tax (Rs.)</label>
                    <input type="number" step="0.01" id="tax" name="tax" value="0.00" min="0" class="calculation-trigger w-full border border-gray-300 rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-indigo-900 mb-1">Grand Total (Rs.)</label>
                    <input type="number" step="0.01" id="grand_total" name="grand_total" class="w-full border border-indigo-300 rounded-lg px-4 py-2 bg-indigo-100 font-bold text-indigo-900" value="0.00" readonly>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 pt-4 border-t border-indigo-100">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Paid Amount (Rs.) *</label>
                    <input type="number" step="0.01" id="paid_amount" name="paid_amount" required value="0.00" min="0" class="calculation-trigger w-full border border-gray-300 rounded-lg px-4 py-2 font-semibold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Due / Outstanding (Rs.)</label>
                    <input type="number" step="0.01" id="due_amount" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 font-semibold text-rose-600" value="0.00" readonly>
                </div>
            </div>
        </div>

        <!-- Form Buttons -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('invoices.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-xl font-medium transition-colors">Cancel</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-semibold transition-colors shadow-md shadow-indigo-600/30">Save Invoice</button>
        </div>
    </form>
</div>

<!-- JavaScript Logic for Autofill, Dynamic Rows & Auto Calculations -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rowIndex = 1;

        // Function to recalculate all financial values
        function calculateTotals() {
            let subtotal = 0;

            document.querySelectorAll('.product-row').forEach(row => {
                const qty = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const price = parseFloat(row.querySelector('.unit-price-input').value) || 0;
                const rowTotal = qty * price;

                row.querySelector('.row-total-input').value = rowTotal.toFixed(2);
                subtotal += rowTotal;
            });

            document.getElementById('subtotal').value = subtotal.toFixed(2);

            const discount = parseFloat(document.getElementById('discount').value) || 0;
            const tax = parseFloat(document.getElementById('tax').value) || 0;
            const grandTotal = Math.max(0, (subtotal - discount) + tax);

            document.getElementById('grand_total').value = grandTotal.toFixed(2);

            const paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;
            const dueAmount = Math.max(0, grandTotal - paidAmount);

            document.getElementById('due_amount').value = dueAmount.toFixed(2);
        }

        // Attach event listener for Autofill unit price on product select
        document.getElementById('product-rows-container').addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select')) {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const price = selectedOption.getAttribute('data-price') || 0;
                const row = e.target.closest('.product-row');

                row.querySelector('.unit-price-input').value = parseFloat(price).toFixed(2);
                calculateTotals();
            }
        });

        // Recalculate on quantity changes
        document.getElementById('product-rows-container').addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity-input')) {
                calculateTotals();
            }
        });

        // Recalculate on Discount, Tax, and Paid Amount changes
        document.querySelectorAll('.calculation-trigger').forEach(input => {
            input.addEventListener('input', calculateTotals);
        });

        // Add Product Row Dynamically
        document.getElementById('add-product-btn').addEventListener('click', function() {
            const container = document.getElementById('product-rows-container');
            const firstRow = container.querySelector('.product-row');
            const newRow = firstRow.cloneNode(true);

            // Update field names with index
            newRow.querySelector('.product-select').name = `products[${rowIndex}][product_id]`;
            newRow.querySelector('.quantity-input').name = `products[${rowIndex}][quantity]`;
            newRow.querySelector('.unit-price-input').name = `products[${rowIndex}][unit_price]`;

            // Clear values
            newRow.querySelector('.product-select').value = '';
            newRow.querySelector('.quantity-input').value = 1;
            newRow.querySelector('.unit-price-input').value = '';
            newRow.querySelector('.row-total-input').value = '0.00';

            // Show remove button
            const removeBtn = newRow.querySelector('.remove-row-btn');
            removeBtn.classList.remove('hidden');

            container.appendChild(newRow);
            rowIndex++;
        });

        // Remove Product Row
        document.getElementById('product-rows-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row-btn')) {
                e.target.closest('.product-row').remove();
                calculateTotals();
            }
        });
    });
</script>
@endsection