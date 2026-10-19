@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header & Action Button -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Customer Management</h2>
        <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">Add New Customer</a>
    </div>

    <!-- Search Bar & Filters -->
    <div class="mb-6 flex justify-between items-center">
        <div class="w-1/3">
            <input type="text" placeholder="Search by name or phone..." class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Sample Row -->
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Erandi Hansika</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">erandi@example.com</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">0712345678</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>

                        <!-- Delete Form with JavaScript Confirmation -->
                        <form action="#" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this customer record?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination Section -->
    <div class="mt-4">
        <!-- Laravel pagination links -->
        <!-- Example: {{ $customers->links() }} -->
    </div>
</div>
@endsection