@extends('layouts.app')

@section('content')
<!-- Custom Styles to strictly isolate print view -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #printable-invoice,
        #printable-invoice * {
            visibility: visible;
        }

        #printable-invoice {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 20px;
            box-shadow: none !important;
            border: none !important;
        }

        .print-no-show {
            display: none !important;
        }
    }
</style>

<div id="printable-invoice" class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md border border-gray-200 my-6">
    <!-- Invoice Header -->
    <div class="flex justify-between items-center border-b pb-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">STOCKIFY ERP</h1>
            <p class="text-sm text-gray-500">Advanced Sales & Inventory Management</p>
        </div>
        <div class="text-right">
            <h2 class="text-xl font-semibold text-gray-700">INVOICE</h2>
            <p class="text-sm font-medium text-gray-600">{{ $invoice->invoice_number }}</p>
            <p class="text-sm text-gray-600">Date: {{ $invoice->invoice_date }}</p>
        </div>
    </div>

    <!-- Customer Details -->
    <div class="mb-6">
        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">CUSTOMER DETAILS:</h3>
        <p class="text-lg font-bold text-gray-800">{{ $invoice->customer->name ?? 'N/A' }}</p>
        <p class="text-sm text-gray-600">{{ $invoice->customer->phone ?? '' }} | {{ $invoice->customer->email ?? '' }}</p>
    </div>

    <!-- Items Table -->
    <table class="min-w-full divide-y divide-gray-200 mb-6">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">PRODUCT</th>
                <th class="px-4 py-2 text-center text-xs font-semibold text-gray-600 uppercase">QTY</th>
                <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase">UNIT PRICE</th>
                <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase">SUBTOTAL</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @php $calculatedSubtotal = 0; @endphp
            @foreach($invoice->invoiceItems as $item)
            @php $calculatedSubtotal += $item->subtotal; @endphp
            <tr>
                <td class="px-4 py-2 text-sm text-gray-800">{{ $item->product->name ?? 'N/A' }}</td>
                <td class="px-4 py-2 text-sm text-center text-gray-600">{{ $item->quantity }}</td>
                <td class="px-4 py-2 text-sm text-right text-gray-600">Rs. {{ number_format($item->unit_price, 2) }}</td>
                <td class="px-4 py-2 text-sm text-right font-semibold text-gray-800">Rs. {{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Invoice Totals Summary -->
    <div class="flex justify-end mb-6">
        <div class="w-1/2 space-y-2 text-sm">
            <div class="flex justify-between text-gray-600">
                <span>Items Subtotal:</span>
                <span>Rs. {{ number_format($calculatedSubtotal, 2) }}</span>
            </div>

            <div class="flex justify-between font-bold text-gray-800 border-t pt-2 text-base">
                <span>Grand Total:</span>
                <span>Rs. {{ number_format($invoice->total_amount, 2) }}</span>
            </div>

            <div class="flex justify-between text-gray-600">
                <span>Paid Amount:</span>
                <span>Rs. {{ number_format($invoice->paid_amount, 2) }}</span>
            </div>

            <div class="flex justify-between text-gray-700 font-semibold border-t pt-1">
                <span>Due Balance:</span>
                <span>Rs. {{ number_format($invoice->due_amount, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Action Buttons (Hidden during print) -->
    <div class="flex justify-between print-no-show print:hidden pt-4 border-t">
        <a href="{{ route('invoices.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Back to List</a>
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Print Invoice</button>
    </div>
</div>
@endsection