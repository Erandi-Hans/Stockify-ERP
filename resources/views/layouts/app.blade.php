<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockify ERP - Admin Panel</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar Navigation -->
        <div class="w-64 bg-gray-900 text-white flex flex-col">
            <div class="p-5 text-2xl font-bold tracking-wider border-b border-gray-800">
                Stockify ERP
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="#" class="block px-4 py-2.5 rounded bg-gray-800 text-white font-medium">Dashboard</a>
                <a href="{{ route('customers.index') }}" class="block px-4 py-2.5 rounded hover:bg-gray-800 text-gray-300">Customers</a>
                <a href="{{ route('products.index') }}" class="block px-4 py-2.5 rounded hover:bg-gray-800 text-gray-300">Products</a>
                <a href="{{ route('categories.index') }}" class="block px-4 py-2.5 rounded hover:bg-gray-800 text-gray-300">Categories</a>
                <a href="{{ route('suppliers.index') }}" class="block px-4 py-2.5 rounded hover:bg-gray-800 text-gray-300">Suppliers</a>
                <a href="{{ route('purchases.index') }}" class="block px-4 py-2.5 rounded hover:bg-gray-800 text-gray-300">Purchases</a>
                <a href="{{ route('invoices.index') }}" class="block px-4 py-2.5 rounded hover:bg-gray-800 text-gray-300">Invoices</a>
                <div class="space-y-1">
                    <span class="block px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Reports</span>
                    <a href="{{ route('reports.sales') }}" class="block px-6 py-2 rounded text-sm text-gray-300 hover:bg-gray-800">Sales Report</a>
                    <a href="{{ route('reports.stock') }}" class="block px-6 py-2 rounded text-sm text-gray-300 hover:bg-gray-800">Stock Report</a>
                    <a href="{{ route('reports.purchase') }}" class="block px-6 py-2 rounded text-sm text-gray-300 hover:bg-gray-800">Purchase Report</a>
                    <a href="{{ route('reports.outstanding') }}" class="block px-6 py-2 rounded text-sm text-gray-300 hover:bg-gray-800">Customer Outstanding</a>
                </div>
            </nav>
        </div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Top Navbar -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-10">
                <div class="text-xl font-semibold text-gray-800">
                    Management Panel
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-600">
                        {{ auth()->user()->name ?? 'System User' }} ({{ auth()->user()->role->name ?? '' }})
                    </span>
                    <form action="#" method="POST">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">Logout</button>
                    </form>
                </div>
            </header>

            <!-- Page Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">

                <!-- Success / Error Notifications -->
                @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-medium">Success</p>
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-medium">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
                @endif

                <!-- Yield Dynamic Content -->
                @yield('content')
            </main>

        </div>
    </div>
</body>

</html>