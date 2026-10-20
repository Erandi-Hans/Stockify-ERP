@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Product Management</h2>
        <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            + Add New Product
        </a>
    </div>

    <!-- Search Form -->
    <div class="mb-6">
        <form action="{{ route('products.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by product name or SKU..." class="w-1/3 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Search</button>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">SKU / Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Supplier</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Prices (Cost / Sell)</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Stock Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                        <div class="text-xs text-gray-500">SKU: {{ $product->sku }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $product->supplier->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        Rs. {{ number_format($product->cost_price, 2) }} / <span class="font-semibold text-gray-900">Rs. {{ number_format($product->unit_price, 2) }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="font-bold {{ $product->stock_quantity <= $product->reorder_level ? 'text-red-600 bg-red-100 px-2 py-1 rounded' : 'text-green-700' }}">
                            {{ $product->stock_quantity }} units
                        </span>
                        @if($product->stock_quantity <= $product->reorder_level)
                            <span class="block text-[10px] text-red-500 font-semibold uppercase">Low Stock</span>
                            @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection