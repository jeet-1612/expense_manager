@extends('layouts.app')

@section('title', 'Expense Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Expense Header -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold">{{ $expense->title }}</h1>
                    <p class="text-blue-100 mt-1">
                        <i class="far fa-calendar mr-2"></i>
                        {{ $expense->date->format('F d, Y') }}
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold">₹{{ number_format($expense->amount, 2) }}</div>
                    <div class="mt-2 text-sm bg-white/20 px-3 py-1 rounded-full inline-block">
                        {{ ucfirst($expense->payment_method) }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Expense Details -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Category</h3>
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $expense->category->color ?? '#3b82f6' }}"></div>
                        <span class="text-lg">{{ $expense->category->name }}</span>
                    </div>
                </div>

                <!-- Payment Method -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Payment Method</h3>
                    <div class="flex items-center text-lg">
                        @switch($expense->payment_method)
                            @case('credit_card')
                                <i class="far fa-credit-card mr-3 text-blue-500"></i>
                                @break
                            @case('debit_card')
                                <i class="far fa-credit-card mr-3 text-green-500"></i>
                                @break
                            @case('upi')
                                <i class="fas fa-mobile-alt mr-3 text-purple-500"></i>
                                @break
                            @default
                                <i class="fas fa-money-bill-wave mr-3 text-green-500"></i>
                        @endswitch
                        {{ ucfirst(str_replace('_', ' ', $expense->payment_method)) }}
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($expense->description)
            <div class="mt-6 pt-6 border-t">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Description</h3>
                <p class="text-gray-700 whitespace-pre-line">{{ $expense->description }}</p>
            </div>
            @endif

            <!-- Timestamps -->
            <div class="mt-6 pt-6 border-t">
                <div class="text-sm text-gray-500">
                    <div class="flex justify-between">
                        <span>Created: {{ $expense->created_at->format('M d, Y h:i A') }}</span>
                        <span>Last Updated: {{ $expense->updated_at->format('M d, Y h:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-gray-50 px-6 py-4 border-t flex justify-between">
            <a href="{{ route('expenses.index') }}"
               class="px-4 py-2 text-gray-600 hover:text-gray-800 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Expenses
            </a>
            
            <div class="flex space-x-3">
                <a href="{{ route('expenses.edit', $expense) }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <form method="POST" action="{{ route('expenses.destroy', $expense) }}"
                      onsubmit="return confirm('Are you sure you want to delete this expense?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center">
                        <i class="fas fa-trash mr-2"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection