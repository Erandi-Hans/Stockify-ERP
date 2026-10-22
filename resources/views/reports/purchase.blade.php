@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6 print:hidden">
        <h2 class="text-2xl font-bold text-gray-800">Purchase History Report</h2>
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
            Print Report
        </button>
    </div>

    <!-- Filter Form -->
    <div class="bg-white p-4 rounded-lg shadow mb-6 border print:hidden">
        <form method="GET" action="{{ route('reports.purchase') }}" class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded text-sm hover:bg-gray-900">Filter</button>
                <a href="{{ route('reports.purchase') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded text-sm">Reset</a>
            </div>
        </form>
    </div>

    <!-- Purchase Report Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden border">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Purchase No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Supplier</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Total Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($purchases as $purchase)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $purchase->purchase_date }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $purchase->purchase_number ?? 'PO-'.$purchase->id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $purchase->supplier->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm text-right font-bold text-gray-900">Rs. {{ number_format($purchase->total_amount, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No purchase records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 print:hidden">
        {{ $purchases->links() }}
    </div>
</div>
@endsection