@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 no-print">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Sales Report</h1>
            <p class="text-sm text-gray-500">Filter and analyze customer sales, payments, and outstanding balances.</p>
        </div>
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm px-4 py-2.5 rounded-xl shadow-sm inline-flex items-center self-start sm:self-auto transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Print Sales Report
        </button>
    </div>

    <!-- Printable Header (Visible only when printed) -->
    <div class="hidden print:block text-center border-b pb-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Stockify ERP - Sales Report</h1>
        <p class="text-sm text-gray-600">Generated on: {{ now()->format('Y-m-d H:i A') }}</p>
    </div>

    <!-- Date Range & Customer Filter Form (Requirement #12) -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 no-print">
        <form method="GET" action="{{ route('reports.sales') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Select Customer</label>
                <select name="customer_id" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Customers</option>
                    @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm py-2 rounded-xl transition-colors">
                    Filter
                </button>
                <a href="{{ route('reports.sales') }}" class="px-4 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-xl text-sm font-medium transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase">
                    <th class="px-6 py-3">Invoice No</th>
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3">Customer</th>
                    <th class="px-6 py-3 text-right">Total (Rs.)</th>
                    <th class="px-6 py-3 text-right">Paid (Rs.)</th>
                    <th class="px-6 py-3 text-right">Balance (Rs.)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($invoices as $invoice)
                <tr>
                    <td class="px-6 py-4 font-bold text-indigo-600">{{ $invoice->invoice_number }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $invoice->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $invoice->customer->name ?? 'Guest Customer' }}</td>
                    <td class="px-6 py-4 text-right font-semibold text-gray-900">{{ number_format($invoice->grand_total, 2) }}</td>
                    <td class="px-6 py-4 text-right text-emerald-600 font-semibold">{{ number_format($invoice->paid_amount, 2) }}</td>
                    <td class="px-6 py-4 text-right text-rose-600 font-semibold">{{ number_format($invoice->grand_total - $invoice->paid_amount, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">No sales records found for the selected criteria.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection