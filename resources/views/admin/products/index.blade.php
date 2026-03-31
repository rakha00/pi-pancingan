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
                        @if(isset($category))
                        <li>
                            <div class="flex items-center">
                                <x-lucide-chevron-right class="w-4 h-4 text-gray-400" />
                                <a href="{{ route('admin.categories.index') }}" class="ml-1 md:ml-2 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Kategori</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <x-lucide-chevron-right class="w-4 h-4 text-gray-400" />
                                <span class="ml-1 text-gray-700 dark:text-gray-200 md:ml-2">{{ $category->name }}</span>
                            </div>
                        </li>
                        @else
                        <li>
                            <div class="flex items-center">
                                <x-lucide-chevron-right class="w-4 h-4 text-gray-400" />
                                <span class="ml-1 text-gray-700 dark:text-gray-200 md:ml-2">Daftar Produk</span>
                            </div>
                        </li>
                        @endif
                    </ol>
                </nav>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    @if(isset($category))
                        {{ __('Produk Kategori: ') . $category->name }}
                    @else
                        {{ __('Semua Produk') }}
                    @endif
                </h2>
            </div>
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-bold py-2.5 px-5 rounded-lg shadow-md transition-all hover:-translate-y-0.5">
                <x-lucide-plus class="w-5 h-5" /> Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl transition-colors border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Gambar</th>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Produk</th>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Harga</th>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Stok</th>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm">
                                    @if($product->image_path)
                                        <img src="{{ Storage::url($product->image_path) }}" class="h-10 w-10 sm:h-12 sm:w-12 rounded-lg object-cover shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-100/10">
                                    @else
                                        <div class="h-10 w-10 sm:h-12 sm:w-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center border border-dashed border-gray-300 dark:border-gray-600">
                                            <x-lucide-image-off class="w-5 h-5 text-gray-400" />
                                        </div>
                                    @endif
                                </td>
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $product->name }}</td>
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-400">
                                    <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-700 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 dark:text-gray-300 py-1 px-2.5 rounded text-xs font-medium">
                                        {{ $product->category->name }}
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm text-gray-800 dark:text-gray-200 font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm text-center">
                                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold rounded-full {{ $product->stock > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm text-right">
                                    <div class="flex space-x-2 items-center justify-end">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-900 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/80 dark:hover:text-blue-300 rounded-lg transition-colors" title="Edit Produk">
                                            <x-lucide-edit class="w-4 h-4" />
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="inline m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-900 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/80 dark:hover:text-red-300 rounded-lg transition-colors" title="Hapus Produk">
                                                <x-lucide-trash-2 class="w-4 h-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 border-b border-gray-200 dark:border-gray-700 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <x-lucide-package-x class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" />
                                        <p class="text-base font-medium">Belum ada produk yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    @if($products->hasPages())
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
