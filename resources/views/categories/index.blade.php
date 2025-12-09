@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
                <p class="text-gray-600 mt-2">Organize your expenses with categories</p>
            </div>
            <a href="{{ route('categories.create') }}" 
               class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:opacity-90 transition flex items-center">
                <i class="fas fa-plus mr-2"></i> Add Category
            </a>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition">
            <!-- Category Header -->
            <div class="p-6 border-b" style="background-color: {{ $category->display_color }}20;">
                <div class="flex justify-between items-start">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3" 
                             style="background-color: {{ $category->display_color }}">
                            <i class="fas fa-{{ $category->type === 'income' ? 'arrow-up' : 'arrow-down' }} text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $category->name }}</h3>
                            <div class="flex items-center mt-1">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $category->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($category->type) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-bold text-gray-900">{{ $category->expenses_count }}</span>
                        <div class="text-sm text-gray-600">expenses</div>
                    </div>
                </div>
            </div>

            <!-- Category Body -->
            <div class="p-6">
                @if($category->description)
                <p class="text-gray-600 mb-4">{{ $category->description }}</p>
                @endif

                <!-- Actions -->
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-palette mr-1"></i>
                        <span style="color: {{ $category->display_color }}">{{ $category->display_color }}</span>
                    </div>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('categories.edit', $category) }}" 
                           class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>
                        
                        <form method="POST" action="{{ route('categories.destroy', $category) }}"
                              onsubmit="return confirm('Are you sure you want to delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition flex items-center">
                                <i class="fas fa-trash mr-2"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State -->
    @if($categories->isEmpty())
    <div class="text-center py-16">
        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-list text-3xl text-gray-400"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No Categories Yet</h3>
        <p class="text-gray-600 mb-6">Create categories to organize your expenses better.</p>
        <a href="{{ route('categories.create') }}" 
           class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:opacity-90 transition inline-flex items-center">
            <i class="fas fa-plus mr-2"></i> Create Your First Category
        </a>
    </div>
    @endif

    <!-- Stats -->
    @if($categories->isNotEmpty())
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-chart-pie text-blue-600 text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ $categories->count() }}</div>
                    <div class="text-gray-600">Total Categories</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-arrow-up text-green-600 text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">
                        {{ $categories->where('type', 'income')->count() }}
                    </div>
                    <div class="text-gray-600">Income Categories</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-arrow-down text-red-600 text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">
                        {{ $categories->where('type', 'expense')->count() }}
                    </div>
                    <div class="text-gray-600">Expense Categories</div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection