<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Manager - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <i class="fas fa-chart-pie text-xl"></i>
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold">ExpenseManager</a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('dashboard') }}" 
                       class="{{ request()->routeIs('dashboard') ? 'bg-white/20' : '' }} hover:bg-white/10 px-3 py-2 rounded-lg transition">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('expenses.index') }}" 
                       class="{{ request()->routeIs('expenses.*') ? 'bg-white/20' : '' }} hover:bg-white/10 px-3 py-2 rounded-lg transition">
                        <i class="fas fa-money-bill-wave mr-2"></i>Expenses
                    </a>
                    <a href="{{ route('categories.index') }}" 
                       class="{{ request()->routeIs('categories.*') ? 'bg-white/20' : '' }} hover:bg-white/10 px-3 py-2 rounded-lg transition">
                        <i class="fas fa-list mr-2"></i>Categories
                    </a>
                </div>

                <!-- User Dropdown -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- User Dropdown -->
<div class="relative group">
    <button class="flex items-center space-x-2 focus:outline-none">
        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
            <i class="fas fa-user"></i>
        </div>
        <span>{{ Auth::user()->name }}</span>
        <i class="fas fa-chevron-down text-sm"></i>
    </button>
    
    <!-- Dropdown Menu -->
    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden group-hover:block z-50">
        <div class="px-4 py-2 border-b">
            <p class="text-sm text-gray-700">{{ Auth::user()->email }}</p>
        </div>
        
        <!-- Profile Link -->
        <a href="{{ route('profile.edit') }}" 
           class="block px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center">
            <i class="fas fa-user-edit mr-3 text-gray-500"></i>
            Edit Profile
        </a>
        
        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center">
                <i class="fas fa-sign-out-alt mr-3 text-gray-500"></i>
                Logout
            </button>
        </form>
    </div>
</div>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="px-4 py-2 bg-transparent border-2 border-white text-white rounded-lg hover:bg-white/10 transition font-medium">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation -->
    <div class="md:hidden bg-white shadow">
        <div class="container mx-auto px-4 py-2">
            <div class="flex justify-around">
                <a href="{{ route('dashboard') }}" 
                   class="flex flex-col items-center text-gray-600 hover:text-blue-600 {{ request()->routeIs('dashboard') ? 'text-blue-600' : '' }}">
                    <i class="fas fa-home text-lg mb-1"></i>
                    <span class="text-xs">Dashboard</span>
                </a>
                <a href="{{ route('expenses.index') }}" 
                   class="flex flex-col items-center text-gray-600 hover:text-blue-600 {{ request()->routeIs('expenses.*') ? 'text-blue-600' : '' }}">
                    <i class="fas fa-money-bill-wave text-lg mb-1"></i>
                    <span class="text-xs">Expenses</span>
                </a>
                <a href="{{ route('categories.index') }}" 
                   class="flex flex-col items-center text-gray-600 hover:text-blue-600 {{ request()->routeIs('categories.*') ? 'text-blue-600' : '' }}">
                    <i class="fas fa-list text-lg mb-1"></i>
                    <span class="text-xs">Categories</span>
                </a>
                @auth
                <form method="POST" action="{{ route('logout') }}" class="flex flex-col items-center">
                    @csrf
                    <button type="submit" class="flex flex-col items-center text-gray-600 hover:text-blue-600">
                        <i class="fas fa-sign-out-alt text-lg mb-1"></i>
                        <span class="text-xs">Logout</span>
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </div>

    <main class="container mx-auto px-4 py-6">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <div class="flex justify-center items-center space-x-2 mb-4">
                    <i class="fas fa-chart-pie text-xl"></i>
                    <span class="text-xl font-bold">ExpenseManager</span>
                </div>
                <p class="text-gray-400 mb-4">Track your expenses. Achieve your financial goals.</p>
                <div class="flex justify-center space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
                <p class="text-gray-500 text-sm mt-6">&copy; {{ date('Y') }} Expense Manager. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for dropdown -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const userButton = document.querySelector('.group button');
            const dropdown = document.querySelector('.group .hidden');
            
            if (userButton) {
                userButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function() {
                    dropdown.classList.add('hidden');
                });
                
                // Prevent dropdown from closing when clicking inside
                dropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
    </script>
</body>
</html>