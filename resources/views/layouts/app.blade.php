<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockify ERP - Modern Management Panel</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Inter Google Font for Professional Look -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen overflow-hidden bg-gray-50">

        <!-- Modern Sidebar Navigation -->
        <aside class="w-72 bg-slate-900 text-slate-300 flex flex-col shadow-xl z-20 transition-all duration-300">
            <!-- Brand Logo / Header -->
            <div class="h-20 flex items-center px-6 bg-slate-950 border-b border-slate-800">
                <div class="flex items-center space-x-3">
                    <div class="bg-indigo-600 p-2 rounded-lg text-white shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold tracking-wider text-white">Stockify <span class="text-indigo-400">ERP</span></span>
                        <p class="text-xs text-slate-400">Advanced Inventory System</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Links with Active State Highlighting -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- Customers -->
                <a href="{{ route('customers.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('customers.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('customers.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Customers
                </a>

                <!-- Products -->
                <a href="{{ route('products.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('products.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('products.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Products
                </a>

                <!-- Categories -->
                <a href="{{ route('categories.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('categories.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Categories
                </a>

                <!-- Suppliers -->
                <a href="{{ route('suppliers.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('suppliers.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('suppliers.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Suppliers
                </a>

                <!-- Purchases -->
                <a href="{{ route('purchases.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('purchases.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('purchases.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Purchases
                </a>

                <!-- Invoices -->
                <a href="{{ route('invoices.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('invoices.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('invoices.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Invoices
                </a>

                <!-- Reports Section Divider -->
                <div class="pt-4 pb-2">
                    <span class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Reports Section</span>
                </div>

                <!-- Sales Report -->
                <a href="{{ route('reports.sales') }}"
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.sales') ? 'bg-slate-800 text-indigo-400 font-semibold' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('reports.sales') ? 'bg-indigo-400' : 'bg-slate-600' }} mr-3"></span>
                    Sales Report
                </a>

                <!-- Stock Report -->
                <a href="{{ route('reports.stock') }}"
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.stock') ? 'bg-slate-800 text-indigo-400 font-semibold' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('reports.stock') ? 'bg-indigo-400' : 'bg-slate-600' }} mr-3"></span>
                    Stock Report
                </a>

                <!-- Purchase Report -->
                <a href="{{ route('reports.purchase') }}"
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.purchase') ? 'bg-slate-800 text-indigo-400 font-semibold' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('reports.purchase') ? 'bg-indigo-400' : 'bg-slate-600' }} mr-3"></span>
                    Purchase Report
                </a>

                <!-- Customer Outstanding -->
                <a href="{{ route('reports.outstanding') }}"
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.outstanding') ? 'bg-slate-800 text-indigo-400 font-semibold' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('reports.outstanding') ? 'bg-indigo-400' : 'bg-slate-600' }} mr-3"></span>
                    Customer Outstanding
                </a>

            </nav>

            <!-- Sidebar Footer / User Info Mini Card -->
            <div class="p-4 bg-slate-950 border-t border-slate-800 flex items-center justify-between">
                <div class="flex items-center space-x-3 overflow-hidden">
                    <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="truncate">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name ?? 'System User' }}</p>
                        <p class="text-xs text-indigo-400 truncate">{{ auth()->user()->role->name ?? 'Administrator' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Modern Top Header Navbar -->
            <header class="bg-white shadow-sm h-20 flex items-center justify-between px-8 z-10 border-b border-gray-200">
                <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-bold text-gray-800 tracking-tight">
                        Management Dashboard
                    </h1>
                </div>

                <div class="flex items-center space-x-6">
                    <!-- Quick Notification / Status Badge -->
                    <div class="hidden md:flex items-center space-x-2 bg-indigo-50 px-3 py-1.5 rounded-full border border-indigo-100">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-semibold text-indigo-700">System Active</span>
                    </div>

                    <!-- User Profile & Logout Form -->
                    <div class="flex items-center space-x-4 border-l pl-6 border-gray-200">
                        <div class="text-right hidden sm:block">
                            <span class="block text-sm font-semibold text-gray-900">{{ auth()->user()->name ?? 'System User' }}</span>
                            <span class="block text-xs text-gray-500">{{ auth()->user()->email ?? 'admin@stockify.com' }}</span>
                        </div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center space-x-1.5 bg-red-50 hover:bg-red-100 text-red-600 px-3.5 py-2 rounded-xl text-sm font-semibold transition-colors duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8">

                <!-- Success Flash Notification -->
                @if(session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl shadow-sm flex items-start space-x-3" role="alert">
                    <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-bold text-sm">Success</p>
                        <p class="text-sm mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                <!-- Error Flash Notification -->
                @if(session('error'))
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-4 rounded-xl shadow-sm flex items-start space-x-3" role="alert">
                    <svg class="w-5 h-5 text-rose-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <p class="font-bold text-sm">Error</p>
                        <p class="text-sm mt-0.5">{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                <!-- Yield Dynamic Content -->
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>