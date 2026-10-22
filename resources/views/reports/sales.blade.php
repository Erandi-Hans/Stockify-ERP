@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6 print:hidden">
        <h2 class="text-2xl font-bold text-gray-800">Sales Report</h2>
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
            Print Report
        </button>
    </div>

    <!-- Filter Form -->
    <div class="bg-white p-4 rounded-lg shadow mb-6 border print:hidden">
        <form method="GET" action="{{ route('reports.sales') }}" class="grid grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Customer</label>
                <select name="customer_id" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="">All Customers</option>
                    @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $customerId == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded text-sm hover:bg-gray-900">Filter</button>
                <a href="{{ route('reports.sales') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded text-sm">Reset</a>
            </div>
        </form>
    </div>

    <!-- Report Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden border">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Invoice No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Total</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Paid</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Balance</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($invoices as $invoice)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $invoice->invoice_date }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $invoice->invoice_number }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $invoice->customer->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm text-right font-bold text-gray-900">Rs. {{ number_format($invoice->total_amount, 2) }}</td>
                    <td class="px-6 py-4 text-sm text-right text-green-600">Rs. {{ number_format($invoice->paid_amount, 2) }}</td>
                    <td class="px-6 py-4 text-sm text-right text-red-600">Rs. {{ number_format($invoice->due_amount, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No sales records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection