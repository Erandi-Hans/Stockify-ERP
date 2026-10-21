@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Purchase Management</h2>
        <a href="{{ route('purchases.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
            + New Stock Purchase
        </a>
    </div>

    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
    @endif

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
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $purchase->purchase_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">{{ $purchase->purchase_number }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $purchase->supplier->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $purchase->product->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-blue-600">{{ $purchase->quantity }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">Rs. {{ number_format($purchase->unit_cost, 2) }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rs. {{ number_format($purchase->total_cost, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('purchases.edit', $purchase->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>

                        <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete karayla nishchita ahat ka?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">No purchases recorded yet.</td>
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