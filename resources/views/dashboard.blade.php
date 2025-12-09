<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Expense Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold">Expense Manager</a>
            <div class="space-x-4">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-200">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="{{ route('expenses.index') }}" class="hover:text-blue-200">
                    <i class="fas fa-money-bill-wave"></i> Expenses
                </a>
                <a href="{{ route('categories.index') }}" class="hover:text-blue-200">
                    <i class="fas fa-list"></i> Categories
                </a>
                @auth
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-blue-200">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-6 p-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Monthly Expenses Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-wallet text-blue-600 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Monthly Expenses</h3>
                        <p class="text-2xl font-bold">₹{{ number_format($monthlyExpenses, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Recent Expenses Count -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-receipt text-green-600 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Recent Expenses</h3>
                        <p class="text-2xl font-bold">{{ $recentExpenses->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-lg mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('expenses.create') }}" class="block bg-blue-600 text-white py-2 px-4 rounded text-center hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i> Add New Expense
                    </a>
                    <a href="{{ route('categories.index') }}" class="block bg-gray-200 py-2 px-4 rounded text-center hover:bg-gray-300">
                        <i class="fas fa-cog mr-2"></i> Manage Categories
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Expenses -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-lg mb-4">Recent Expenses</h3>
                @if($recentExpenses->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2">Title</th>
                                <th class="text-left py-2">Category</th>
                                <th class="text-left py-2">Amount</th>
                                <th class="text-left py-2">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentExpenses as $expense)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2">{{ $expense->title }}</td>
                                <td class="py-2">
                                    @if($expense->category)
                                    <span class="px-2 py-1 rounded text-xs" style="background-color: {{ $expense->category->color ?? '#e5e7eb' }}">
                                        {{ $expense->category->name }}
                                    </span>
                                    @else
                                    <span class="text-gray-500">No Category</span>
                                    @endif
                                </td>
                                <td class="py-2">₹{{ number_format($expense->amount, 2) }}</td>
                                <td class="py-2">{{ $expense->date->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-receipt text-4xl mb-4"></i>
                    <p>No expenses recorded yet.</p>
                    <a href="{{ route('expenses.create') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                        Add your first expense
                    </a>
                </div>
                @endif
            </div>

            <!-- Category Breakdown -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-lg mb-4">Category Breakdown (This Month)</h3>
                @if($monthlyExpenses > 0)
                <div class="space-y-4">
                    @foreach($categories as $category)
                        @php
                            $categoryTotal = $category->expenses->sum('amount');
                            $percentage = $monthlyExpenses > 0 ? ($categoryTotal / $monthlyExpenses * 100) : 0;
                        @endphp
                        @if($categoryTotal > 0)
                        <div>
                            <div class="flex justify-between mb-1">
                                <span>{{ $category->name }}</span>
                                <span>₹{{ number_format($categoryTotal, 2) }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full" 
                                     style="width: {{ $percentage }}%; background-color: {{ $category->color ?? '#3b82f6' }}">
                                </div>
                            </div>
                            <div class="text-right text-sm text-gray-500 mt-1">
                                {{ number_format($percentage, 1) }}%
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-chart-pie text-4xl mb-4"></i>
                    <p>No expenses this month to show breakdown.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Monthly Trend -->
        @if($monthlyTrend->count() > 0)
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-lg mb-4">Monthly Trend (Last 6 Months)</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Month</th>
                            <th class="text-left py-2">Year</th>
                            <th class="text-left py-2">Total Expenses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlyTrend as $trend)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2">
                                {{ date('F', mktime(0, 0, 0, $trend->month, 1)) }}
                            </td>
                            <td class="py-2">{{ $trend->year }}</td>
                            <td class="py-2 font-medium">₹{{ number_format($trend->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</body>
</html>