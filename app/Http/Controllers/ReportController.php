<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Customer;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Sales Report with date range and customer filter.
     */
    public function sales(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $customerId = $request->input('customer_id');

        $customers = Customer::all();

        $invoices = Invoice::with('customer')
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('invoice_date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('invoice_date', '<=', $endDate);
            })
            ->when($customerId, function ($query) use ($customerId) {
                return $query->where('customer_id', $customerId);
            })
            ->latest()
            ->paginate(15);

        return view('reports.sales', compact('invoices', 'customers', 'startDate', 'endDate', 'customerId'));
    }

    /**
     * Stock Status Report.
     */
    public function stock(Request $request)
    {
        $search = $request->input('search');

        $products = Product::with('category')
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            })
            ->paginate(15);

        return view('reports.stock', compact('products', 'search'));
    }

    /**
     * Purchase History Report with date range and supplier filter.
     */
    public function purchase(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $purchases = Purchase::with('supplier')
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('purchase_date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('purchase_date', '<=', $endDate);
            })
            ->latest()
            ->paginate(15);

        return view('reports.purchase', compact('purchases', 'startDate', 'endDate'));
    }

    /**
     * Customer Outstanding Balance Report.
     */
    public function customerOutstanding()
    {
        // Fetch customers with their invoices using Eloquent relationship
        $customers = Customer::with('invoices')->get();

        return view('reports.outstanding', compact('customers'));
    }
}
