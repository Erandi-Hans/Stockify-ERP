@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Page Header and Create Button -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Purchase Management</h2>
        <a href="{{ route('purchases.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            + New Stock Purchase
        </a>
    </div>

    <!-- Success Message Notification -->
    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
        {{ session('success') }}
    </div>
    @endif

    <!-- Search Form -->
    <div class="mb-6">
        <form action="{{ route('purchases.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by supplier or product..." class="w-1/3 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Search</button>
        </form>
    </div>

    <!-- Purchases Data Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">PO Number</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Supplier</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Qty</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Unit Cost</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total Cost</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($purchases as $purchase)
                <tr class="hover:bg-gray-50">
                    <!-- Purchase Date -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $purchase->purchase_date }}</td>
                    <!-- Purchase Order Number -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">{{ $purchase->purchase_number }}</td>
                    <!-- Supplier Name -->
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $purchase->supplier->name ?? 'N/A' }}</td>
                    <!-- Product Name -->
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $purchase->product->name ?? 'N/A' }}</td>
                    <!-- Quantity -->
                    <td class="px-6 py-4 text-sm font-bold text-blue-600">{{ $purchase->quantity }}</td>
                    <!-- Unit Cost -->
                    <td class="px-6 py-4 text-sm text-gray-600">Rs. {{ number_format($purchase->unit_cost, 2) }}</td>
                    <!-- Total Cost -->
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rs. {{ number_format($purchase->total_cost, 2) }}</td>
                    <!-- Action Buttons (Edit and Delete) -->
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('purchases.edit', $purchase->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>

                        <!-- Delete Form with DELETE method directive -->
                        <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this purchase?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <!-- Empty State Row -->
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">No purchases recorded yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $purchases->links() }}
    </div>
</div>
@endsection