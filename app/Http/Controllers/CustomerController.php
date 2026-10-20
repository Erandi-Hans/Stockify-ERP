<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Display a listing of customers with search and pagination
    public function index(Request $request)
    {
        $search = $request->input('search');

        $customers = Customer::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(10);

        return view('customers.index', compact('customers'));
    }

    // Show the form for creating a new customer
    public function create()
    {
        return view('customers.create');
    }

    // Store a newly created customer in database with server-side validation
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\.\'-]+$/' // Accepts only letters and spaces
            ],
            'email' => 'nullable|email|unique:customers,email',
            'phone' => [
                'required',
                'string',
                'regex:/^[0-9\+\-\s\(\)]+$/',
                'digits:10' // Validates exactly 10 digits
            ],
            'address' => 'nullable|string|max:500',
        ], [
            'name.regex' => 'Customer name can only contain letters and spaces.',
            'phone.regex' => 'Mobile number must contain only numeric digits.',
            'phone.digits' => 'Mobile number must be exactly 10 digits long.',
        ]);

        Customer::create($validatedData);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    // Show the form for editing the specified customer
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    // Update the specified customer in database
    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\.\'-]+$/'
            ],
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone' => [
                'required',
                'string',
                'regex:/^[0-9\+\-\s\(\)]+$/',
                'digits:10' // Validates exactly 10 digits
            ],
            'address' => 'nullable|string|max:500',
        ]);

        $customer->update($validatedData);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    // Remove the specified customer from database
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
