@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header & Print Action Button -->
    <div class="flex items-center justify-between no-print">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Stock Report</h1>
            <p class="text-sm text-gray-500">Monitor current stock levels, categories, and reorder alerts.</p>
        </div>
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm px-4 py-2.5 rounded-xl shadow-sm inline-flex items-center transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Print Stock Report
        </button>
    </div>

    <!-- Printable Title Banner -->
    <div class="hidden print:block text-center border-b pb-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Stockify ERP - Stock Status Report</h1>
        <p class="text-sm text-gray-600">Generated on: {{ now()->format('Y-m-d H:i A') }}</p>
    </div>

    <!-- Stock Data Table (Requirement #12) -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase">
                    <th class="px-6 py-3">Product Name</th>
                    <th class="px-6 py-3">Category</th>
                    <th class="px-6 py-3 text-center">Current Stock</th>
                    <th class="px-6 py-3 text-center">Reorder Level</th>
                    <th class="px-6 py-3 text-center">Stock Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($products as $product)
                <tr>
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $product->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $product->category->name ?? 'Uncategorized' }}</td>
                    <td class="px-6 py-4 text-center font-bold {{ $product->stock_quantity <= $product->reorder_level ? 'text-rose-600' : 'text-gray-900' }}">
                        {{ $product->stock_quantity }}
                    </td>
                    <td class="px-6 py-4 text-center text-gray-500">{{ $product->reorder_level }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($product->stock_quantity <= $product->reorder_level)
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-50 text-rose-700 border border-rose-200">
                                Low Stock
                            </span>
                            @else
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                In Stock
                            </span>
                            @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">No product records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection