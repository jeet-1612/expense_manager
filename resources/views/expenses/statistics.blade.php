@extends('layouts.app')

@section('title', 'Expense Statistics')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Expense Statistics</h1>
                <p class="text-gray-600 mt-2">Visualize your spending patterns</p>
            </div>
            <a href="{{ route('expenses.index') }}" 
               class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Expenses
            </a>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ date('F Y') }}</div>
                    <div class="text-gray-600">Current Month</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ $categoryData->count() }}</div>
                    <div class="text-gray-600">Active Categories</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-credit-card text-purple-600 text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ $paymentData->count() }}</div>
                    <div class="text-gray-600">Payment Methods</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-money-bill-wave text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">
                        ₹{{ number_format($categoryData->sum('total'), 2) }}
                    </div>
                    <div class="text-gray-600">This Month's Total</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Monthly Trend -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Monthly Trend ({{ date('Y') }})</h3>
            @if($monthlyData->count() > 0)
            <div class="space-y-4">
                @foreach($monthlyData as $data)
                @php
                    $monthName = DateTime::createFromFormat('!m', $data->month)->format('F');
                    $percentage = ($data->total / $monthlyData->max('total')) * 100;
                @endphp
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">{{ $monthName }}</span>
                        <span class="text-sm font-medium text-gray-900">₹{{ number_format($data->total, 2) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full" 
                             style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-chart-line text-4xl mb-4"></i>
                <p>No data available for this year.</p>
            </div>
            @endif
        </div>

        <!-- Category Distribution -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Category Distribution (This Month)</h3>
            @if($categoryData->count() > 0)
            <div class="space-y-4">
                @foreach($categoryData as $category)
                @php
                    $total = $categoryData->sum('total');
                    $percentage = $total > 0 ? ($category['total'] / $total * 100) : 0;
                @endphp
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">{{ $category['name'] }}</span>
                        <span class="text-sm font-medium text-gray-900">₹{{ number_format($category['total'], 2) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full" 
                             style="width: {{ $percentage }}%; background-color: {{ $category['color'] ?? '#3b82f6' }}"></div>
                    </div>
                    <div class="text-right text-sm text-gray-500 mt-1">
                        {{ number_format($percentage, 1) }}%
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-chart-pie text-4xl mb-4"></i>
                <p>No expenses this month to show distribution.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Payment Method Distribution -->
    <div class="mt-8 bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Payment Method Distribution (This Month)</h3>
        @if($paymentData->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($paymentData as $data)
            @php
                $total = $paymentData->sum('total');
                $percentage = $total > 0 ? ($data->total / $total * 100) : 0;
                $colors = [
                    'cash' => 'bg-green-500',
                    'credit_card' => 'bg-blue-500',
                    'debit_card' => 'bg-purple-500',
                    'bank_transfer' => 'bg-yellow-500',
                    'upi' => 'bg-red-500',
                    'other' => 'bg-gray-500'
                ];
                $colorClass = $colors[$data->payment_method] ?? 'bg-gray-500';
            @endphp
            <div class="text-center">
                <div class="text-3xl font-bold text-gray-900 mb-2">₹{{ number_format($data->total, 2) }}</div>
                <div class="h-3 w-full bg-gray-200 rounded-full mb-2 overflow-hidden">
                    <div class="h-full {{ $colorClass }} rounded-full" style="width: {{ $percentage }}%"></div>
                </div>
                <div class="text-sm font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $data->payment_method)) }}</div>
                <div class="text-sm text-gray-500">{{ number_format($percentage, 1) }}%</div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-credit-card text-4xl mb-4"></i>
            <p>No payment data available for this month.</p>
        </div>
        @endif
    </div>
</div>
@endsection