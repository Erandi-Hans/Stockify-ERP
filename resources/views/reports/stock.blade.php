@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6 print:hidden">
        <h2 class="text-2xl font-bold text-gray-800">Stock Inventory Report</h2>
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
            Print Report
        </button>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden border">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Category</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Current Stock</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Reorder Level</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Stock Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($products as $product)
                <tr>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $product->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm text-center font-bold text-gray-900">{{ $product->stock_quantity }}</td>
                    <td class="px-6 py-4 text-sm text-center text-gray-500">{{ $product->reorder_level }}</td>
                    <td class="px-6 py-4 text-sm text-center">
                        @if($product->stock_quantity <= $product->reorder_level)
                            <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Low Stock</span>
                            @else
                            <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">In Stock</span>
                            @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection