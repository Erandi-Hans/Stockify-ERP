@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md border border-gray-200 my-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Purchase Record</h2>

    <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Select Supplier *</label>
            <select name="supplier_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}" {{ old('supplier_id', $purchase->supplier_id) == $supplier->id ? 'selected' : '' }}>
                    {{ $supplier->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Select Product *</label>
            <select name="product_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                @foreach($products as $product)
                <option value="{{ $product->id }}" {{ old('product_id', $purchase->product_id) == $product->id ? 'selected' : '' }}>
                    {{ $product->name }} (Current Stock: {{ $product->stock_quantity }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                <input type="number" name="quantity" value="{{ old('quantity', $purchase->quantity) }}" min="1" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unit Cost (Rs.) *</label>
                <input type="number" step="0.01" name="unit_cost" value="{{ old('unit_cost', $purchase->unit_cost) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Date *</label>
            <input type="date" name="purchase_date" value="{{ old('purchase_date', $purchase->purchase_date) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea name="notes" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ old('notes', $purchase->notes) }}</textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('purchases.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Update Purchase</button>
        </div>
    </form>
</div>
@endsection