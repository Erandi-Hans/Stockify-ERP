<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of sales invoices with search and pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $invoices = Invoice::with(['customer', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new sales invoice.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('stock_quantity', '>', 0)->get();

        return view('invoices.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created invoice, validate stock, and update inventory atomically.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        // Wrap database operations in a transaction for data integrity
        DB::transaction(function () use ($validated, $request) {
            $subtotal = 0;

            // Calculate subtotal for all items and validate stock availability
            foreach ($validated['products'] as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                // Strict Stock Validation: Ensure stock never becomes negative
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->name}. Available: {$product->stock_quantity}");
                }

                $subtotal += $item['quantity'] * $item['unit_price'];
            }

            $discount = $request->input('discount', 0);
            $tax = $request->input('tax', 0);
            $grandTotal = ($subtotal - $discount) + $tax;
            $paidAmount = $request->input('paid_amount', 0);
            $dueAmount = $grandTotal - $paidAmount;

            // Determine payment status
            $status = 'Unpaid';
            if ($paidAmount >= $grandTotal) {
                $status = 'Paid';
                $dueAmount = 0;
            } elseif ($paidAmount > 0) {
                $status = 'Partially Paid';
            }

            // Create the main invoice record
            $invoice = Invoice::create([
                'invoice_number' => 'INV-' . date('Ymd') . '-' . rand(1000, 9999),
                'customer_id' => $validated['customer_id'],
                'user_id' => Auth::id(),
                'invoice_date' => $validated['invoice_date'],
                'total_amount' => $grandTotal,
                'paid_amount' => $paidAmount,
                'due_amount' => $dueAmount,
                'status' => $status,
            ]);

            // Save invoice items and decrement product stock
            foreach ($validated['products'] as $item) {
                $itemSubtotal = $item['quantity'] * $item['unit_price'];

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $itemSubtotal,
                ]);

                // Decrement stock quantity
                $product = Product::findOrFail($item['product_id']);
                $product->decrement('stock_quantity', $item['quantity']);
            }
        });

        return redirect()->route('invoices.index')->with('success', 'Sales invoice created successfully and stock updated!');
    }

    /**
     * Display the specified invoice details for viewing and printing.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'user', 'invoiceItems.product']);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Remove the specified invoice and restore product stock.
     */
    public function destroy(Invoice $invoice)
    {
        DB::transaction(function () use ($invoice) {
            // Restore product stock quantities
            foreach ($invoice->invoiceItems as $item) {
                $product = Product::findOrFail($item->product_id);
                $product->increment('stock_quantity', $item->quantity);
            }

            // Delete invoice items and invoice
            $invoice->invoiceItems()->delete();
            $invoice->delete();
        });

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted and stock restored successfully!');
    }
}
