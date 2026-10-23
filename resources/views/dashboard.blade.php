@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Overview</h1>

    <!-- Top Counters Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <!-- Total Customers -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <p class="text-sm font-medium text-gray-500 uppercase">Total Customers</p>
            <p class="text-2xl font-bold text-gray-800 mt-2">{{ $totalCustomers }}</p>
        </div>

        <!-- Total Products -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <p class="text-sm font-medium text-gray-500 uppercase">Total Products</p>
            <p class="text-2xl font-bold text-gray-800 mt-2">{{ $totalProducts }}</p>
        </div>

        <!-- Total Suppliers -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <p class="text-sm font-medium text-gray-500 uppercase">Total Suppliers</p>
            <p class="text-2xl font-bold text-gray-800 mt-2">{{ $totalSuppliers }}</p>
        </div>

        <!-- Low Stock Alert -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <p class="text-sm font-medium text-red-500 uppercase">Low Stock Products</p>
            <p class="text-2xl font-bold text-red-600 mt-2">{{ $lowStockCount }}</p>
        </div>

        <!-- Today's Sales -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <p class="text-sm font-medium text-gray-500 uppercase">Today's Sales</p>
            <p class="text-2xl font-bold text-green-600 mt-2">Rs. {{ number_format($todaysSales, 2) }}</p>
        </div>

        <!-- Total Sales -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <p class="text-sm font-medium text-gray-500 uppercase">Total Sales</p>
            <p class="text-2xl font-bold text-blue-600 mt-2">Rs. {{ number_format($totalSales, 2) }}</p>
        </div>

        <!-- Outstanding Payments -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <p class="text-sm font-medium text-gray-500 uppercase">Outstanding Payments</p>
            <p class="text-2xl font-bold text-red-600 mt-2">Rs. {{ number_format($totalOutstanding, 2) }}</p>
        </div>

    </div>

    <!-- Recent Invoices Table -->
    <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Recent Invoices</h3>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Invoice No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Total</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recentInvoices as $invoice)
                <tr>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $invoice->invoice_number }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $invoice->customer->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $invoice->invoice_date }}</td>
                    <td class="px-6 py-4 text-sm text-right font-bold text-gray-900">Rs. {{ number_format($invoice->total_amount, 2) }}</td>
                    <td class="px-6 py-4 text-sm text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $invoice->status == 'Paid' ? 'bg-green-100 text-green-800' : ($invoice->status == 'Partially Paid' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $invoice->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No recent invoices found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection