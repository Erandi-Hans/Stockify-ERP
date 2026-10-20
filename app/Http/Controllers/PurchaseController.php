<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of purchases with search functionality.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $purchases = Purchase::with(['supplier', 'product'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('supplier', function ($q) use ($search) { // use ($search) එකතු කරන්න
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('product', function ($q) use ($search) { // use ($search) එකතු කරන්න
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new purchase record.
     */
    public function create()
    {
        $suppliers = Supplier::where('status', 1)->get();
        $products = Product::all();

        return view('purchases.create', compact('suppliers', 'products'));
    }

    /**
     * Store a new purchase and update product stock quantity using DB Transaction.
     */
    public function store(Request $request)
    {
        // Strict input validation using Regex
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        // Calculate total cost automatically
        $validated['total_cost'] = $validated['quantity'] * $validated['unit_cost'];

        // Use DB Transaction to guarantee data integrity
        DB::transaction(function () use ($validated) {
            // 1. Create the Purchase record
            Purchase::create($validated);

            // 2. Automatically update product stock quantity
            $product = Product::findOrFail($validated['product_id']);
            $product->increment('stock_quantity', $validated['quantity']);
        });

        return redirect()->route('purchases.index')->with('success', 'Purchase recorded and stock updated successfully!');
    }
}
