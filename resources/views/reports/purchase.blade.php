@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Button -->
    <div class="flex items-center justify-between no-print">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Purchase Report</h1>
            <p class="text-sm text-gray-500">Track purchase orders, suppliers, and total expenditure.</p>
        </div>
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm px-4 py-2.5 rounded-xl shadow-sm inline-flex items-center transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Print Purchase Report
        </button>
    </div>

    <!-- Printable Header Banner -->
    <div class="hidden print:block text-center border-b pb-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Stockify ERP - Purchase Report</h1>
        <p class="text-sm text-gray-600">Generated on: {{ now()->format('Y-m-d H:i A') }}</p>
    </div>

    <!-- Purchase Data Table (Requirement #12) -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase">
                    <th class="px-6 py-3">Purchase No</th>
                    <th class="px-6 py-3">Supplier</th>
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3 text-right">Total Amount (Rs.)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($purchases as $purchase)
                <tr>
                    <td class="px-6 py-4 font-bold text-indigo-600">PO-{{ sprintf("%05d", $purchase->id) }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $purchase->supplier->company_name ?? $purchase->supplier->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $purchase->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4 text-right font-semibold text-gray-900">{{ number_format($purchase->total_amount, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-400">No purchase records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection