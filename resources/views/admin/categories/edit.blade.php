<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4">
            <!-- Breadcrumbs -->
            <nav class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            <x-lucide-home class="w-4 h-4 mr-2" />
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <x-lucide-chevron-right class="w-4 h-4 text-gray-400" />
                            <a href="{{ route('admin.categories.index') }}" class="ml-1 md:ml-2 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Kategori</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <x-lucide-chevron-right class="w-4 h-4 text-gray-400" />
                            <span class="ml-1 text-gray-700 dark:text-gray-200 md:ml-2">Edit Kategori</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Data: {{ $category->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="max-w-md">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Category Name</label>
                            <input type="text" name="name" id="name" value="{{ $category->name }}" class="shadow appearance-none border border-gray-300 dark:border-gray-700 rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="flex items-center gap-4 mt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-bold py-2 px-6 rounded focus:outline-none shadow">
                                Update Category
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
