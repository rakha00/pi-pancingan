<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
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
                                <span class="ml-1 text-gray-700 dark:text-gray-200 md:ml-2">Kategori</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Kategori Produk') }}
                </h2>
            </div>
            
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-bold py-2.5 px-5 rounded-lg shadow-md transition-all hover:-translate-y-0.5">
                <x-lucide-plus class="w-5 h-5" /> Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl mb-6 transition-colors border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Kategori</th>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Items</th>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm text-gray-500 dark:text-gray-400">{{ $category->id }}</td>
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $category->name }}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm">
                                    <span class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300 py-1.5 px-3 rounded-full text-xs font-bold border border-indigo-100 dark:border-indigo-800/50">
                                        <x-lucide-box class="w-3.5 h-3.5" /> {{ $category->products_count }} Produk
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm text-right">
                                    <div class="flex space-x-2 items-center justify-end">
                                        <a href="{{ route('admin.products.index', ['category_id' => $category->id]) }}" class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-900 dark:bg-indigo-900/30 dark:text-indigo-400 dark:hover:bg-indigo-900/80 dark:hover:text-indigo-300 rounded-lg transition-colors" title="Lihat Produk">
                                            <x-lucide-eye class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-900 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/80 dark:hover:text-blue-300 rounded-lg transition-colors" title="Edit Kategori">
                                            <x-lucide-edit class="w-4 h-4" />
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Pastikan tidak ada produk yang bergantung pada kategori ini!');" class="inline m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-900 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/80 dark:hover:text-red-300 rounded-lg transition-colors" title="Hapus Kategori">
                                                <x-lucide-trash-2 class="w-4 h-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 border-b border-gray-200 dark:border-gray-700 text-sm text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <x-lucide-inbox class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" />
                                        <p>Belum ada kategori yang dibuat.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    @if($categories->hasPages())
                    <div class="mt-6">
                        {{ $categories->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
