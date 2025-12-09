@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-plus text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Create New Category</h1>
                    <p class="text-blue-100">Organize your expenses with categories</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="p-6">
            <form method="POST" action="{{ route('categories.store') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Category Name *
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name"
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="e.g., Food, Transportation, Entertainment"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Type *
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative">
                            <input type="radio" 
                                   name="type" 
                                   value="expense" 
                                   {{ old('type', 'expense') == 'expense' ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="p-4 border-2 border-gray-300 rounded-lg text-center cursor-pointer 
                                        peer-checked:border-blue-500 peer-checked:bg-blue-50 transition">
                                <i class="fas fa-arrow-down text-red-500 text-xl mb-2"></i>
                                <div class="font-medium">Expense</div>
                                <div class="text-sm text-gray-600">Money spent</div>
                            </div>
                        </label>
                        <label class="relative">
                            <input type="radio" 
                                   name="type" 
                                   value="income" 
                                   {{ old('type') == 'income' ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="p-4 border-2 border-gray-300 rounded-lg text-center cursor-pointer 
                                        peer-checked:border-green-500 peer-checked:bg-green-50 transition">
                                <i class="fas fa-arrow-up text-green-500 text-xl mb-2"></i>
                                <div class="font-medium">Income</div>
                                <div class="text-sm text-gray-600">Money earned</div>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                        Color
                    </label>
                    <div class="flex items-center space-x-4">
                        <input type="color" 
                               name="color" 
                               id="color"
                               value="{{ old('color', '#3b82f6') }}"
                               class="w-16 h-16 cursor-pointer">
                        <div class="flex-1">
                            <input type="text" 
                                   id="colorHex"
                                   value="{{ old('color', '#3b82f6') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="#3b82f6"
                                   readonly>
                            <p class="mt-1 text-sm text-gray-500">Click the color box to pick a color</p>
                        </div>
                    </div>
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description (Optional)
                    </label>
                    <textarea name="description" 
                              id="description"
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Add a description for this category...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t">
                    <a href="{{ route('categories.index') }}"
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:opacity-90 transition focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-plus mr-2"></i> Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Sync color picker with text input
    document.getElementById('color').addEventListener('input', function() {
        document.getElementById('colorHex').value = this.value;
    });
    
    document.getElementById('colorHex').addEventListener('input', function() {
        document.getElementById('color').value = this.value;
    });
</script>
@endsection