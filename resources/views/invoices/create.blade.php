@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md border border-gray-200 my-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Create Sales Invoice</h2>

    @if ($errors->any())
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Customer *</label>
                <select name="customer_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Invoice Date *</label>
                <input type="date" name="invoice_date" value="{{ date('Y-m-d') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
            </div>
        </div>

        <h3 class="text-lg font-semibold text-gray-700 mt-6 mb-3">Invoice Item (Product)</h3>
        <div class="grid grid-cols-4 gap-3 mb-4 bg-gray-50 p-4 rounded-lg border">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Product *</label>
                <select name="products[0][product_id]" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->stock_quantity }}) - Rs. {{ $product->selling_price }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Quantity *</label>
                <input type="number" name="products[0][quantity]" value="1" min="1" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Unit Price (Rs.) *</label>
                <input type="number" step="0.01" name="products[0][unit_price]" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Discount (Rs.)</label>
                <input type="number" step="0.01" name="discount" value="0" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tax (Rs.)</label>
                <input type="number" step="0.01" name="tax" value="0" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Paid Amount (Rs.) *</label>
                <input type="number" step="0.01" name="paid_amount" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('invoices.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save Invoice</button>
        </div>
    </form>
</div>
@endsection