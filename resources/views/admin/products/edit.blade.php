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
                            <a href="{{ route('admin.products.index') }}" class="ml-1 md:ml-2 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Produk</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <x-lucide-chevron-right class="w-4 h-4 text-gray-400" />
                            <span class="ml-1 text-gray-700 dark:text-gray-200 md:ml-2">Edit Produk</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Data: {{ $product->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700 transition-colors">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="max-w-3xl">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Pilih Kategori</label>
                                <select name="category_id" class="shadow-sm border border-gray-300 dark:border-gray-700 rounded-lg w-full py-2.5 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nama Produk</label>
                                <input type="text" name="name" value="{{ $product->name }}" class="shadow-sm border border-gray-300 dark:border-gray-700 rounded-lg w-full py-2.5 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors" required>
                                @error('name') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Deskripsi Produk</label>
                            <textarea name="description" rows="5" class="shadow-sm border border-gray-300 dark:border-gray-700 rounded-lg w-full py-2.5 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors" required>{{ $product->description }}</textarea>
                            @error('description') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Harga (Rp)</label>
                                <input type="number" name="price" value="{{ $product->price }}" class="shadow-sm border border-gray-300 dark:border-gray-700 rounded-lg w-full py-2.5 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors" required min="0">
                                @error('price') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Stok Barang</label>
                                <input type="number" name="stock" value="{{ $product->stock }}" class="shadow-sm border border-gray-300 dark:border-gray-700 rounded-lg w-full py-2.5 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors" required min="0">
                                @error('stock') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-8 p-6 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl flex flex-col md:flex-row gap-6 items-start">
                            @if($product->image_path)
                                <div class="shrink-0 relative group">
                                    <div class="absolute inset-0 bg-black/40 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                                        <x-lucide-camera class="w-6 h-6 text-white" />
                                    </div>
                                    <img src="{{ Storage::url($product->image_path) }}" class="h-32 w-32 object-cover rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 ring-4 ring-white dark:ring-gray-800">
                                </div>
                            @endif
                            <div class="flex-grow w-full">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Ubah Gambar Produk (Opsional)</label>
                                <p class="mb-3 text-xs text-gray-500 dark:text-gray-400">Pilih gambar baru jika ingin menggantinya. Biarkan kosong jika tidak ingin mengubah.</p>
                                <input type="file" name="image_path" class="w-full text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/50 dark:file:text-indigo-300 transition-all cursor-pointer" accept="image/*">
                                @error('image_path') <span class="text-red-500 dark:text-red-400 text-xs mt-2 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-all hover:-translate-y-0.5">
                                <x-lucide-save class="w-5 h-5" /> Perbarui Produk
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300 font-medium">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
