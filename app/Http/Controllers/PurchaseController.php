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
     * Display a listing of purchases.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $purchases = Purchase::with(['supplier', 'product'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('supplier', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('product', function ($q) use ($search) {
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
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('purchases.create', compact('suppliers', 'products'));
    }

    /**
     * Store a new purchase and update stock.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $validated['purchase_number'] = 'PO-' . date('Ymd') . '-' . rand(1000, 9999);
        $validated['total_cost'] = $validated['quantity'] * $validated['unit_cost'];

        DB::transaction(function () use ($validated) {
            Purchase::create($validated);

            $product = Product::findOrFail($validated['product_id']);
            $product->increment('stock_quantity', $validated['quantity']);
        });

        return redirect()->route('purchases.index')->with('success', 'Purchase saved successfully!');
    }

    /**
     * Prevent 404 on show route.
     */
    public function show(Purchase $purchase)
    {
        return redirect()->route('purchases.index');
    }

    /**
     * Show the edit form.
     */
    public function edit(Purchase $purchase)
    {
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('purchases.edit', compact('purchase', 'suppliers', 'products'));
    }

    /**
     * Update purchase record and update stock.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $validated['total_cost'] = $validated['quantity'] * $validated['unit_cost'];

        DB::transaction(function () use ($validated, $purchase) {
            // Revert previous stock
            $oldProduct = Product::findOrFail($purchase->product_id);
            $oldProduct->decrement('stock_quantity', $purchase->quantity);

            // Update purchase record
            $purchase->update($validated);

            // Add new stock
            $newProduct = Product::findOrFail($validated['product_id']);
            $newProduct->increment('stock_quantity', $validated['quantity']);
        });

        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully!');
    }

    /**
     * Delete purchase record and decrement stock.
     */
    public function destroy(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            $product = Product::findOrFail($purchase->product_id);
            $product->decrement('stock_quantity', $purchase->quantity);

            $purchase->delete();
        });

        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully!');
    }
}
