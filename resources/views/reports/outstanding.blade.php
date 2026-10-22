@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6 print:hidden">
        <h2 class="text-2xl font-bold text-gray-800">Customer Outstanding Report</h2>
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
            Print Report
        </button>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden border">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Phone</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Total Sales</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Total Paid</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Outstanding Balance</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($customers as $customer)
                <tr>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $customer['name'] }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $customer['phone'] }}</td>
                    <td class="px-6 py-4 text-sm text-right text-gray-800">Rs. {{ number_format($customer['total_sales'], 2) }}</td>
                    <td class="px-6 py-4 text-sm text-right text-green-600">Rs. {{ number_format($customer['total_paid'], 2) }}</td>
                    <td class="px-6 py-4 text-sm text-right font-bold text-red-600">Rs. {{ number_format($customer['outstanding'], 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No outstanding customer balances found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection