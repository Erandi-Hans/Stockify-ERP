@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Purchase Management</h2>
        <a href="{{ route('purchases.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            + New Stock Purchase
        </a>
    </div>

    <!-- Search Form -->
    <div class="mb-6">
        <form action="{{ route('purchases.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by supplier or product..." class="w-1/3 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Search</button>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Supplier</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Qty Received</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Unit Cost</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total Cost</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($purchases as $purchase)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $purchase->purchase_date }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $purchase->supplier->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $purchase->product->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-blue-600">+{{ $purchase->quantity }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">Rs. {{ number_format($purchase->unit_cost, 2) }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rs. {{ number_format($purchase->total_cost, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No purchases recorded yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $purchases->links() }}
    </div>
</div>
@endsection