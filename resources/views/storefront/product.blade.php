<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <x-lucide-package class="w-5 h-5 text-indigo-500" />
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-8 flex flex-col md:flex-row gap-10">
                    
                    <!-- Product Image -->
                    <div class="w-full md:w-1/2">
                        <div class="rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-700 border border-gray-100 dark:border-gray-600 aspect-square flex items-center justify-center relative shadow-inner">
                            @if($product->image_path)
                                <img src="{{ Storage::url($product->image_path) }}" class="w-full h-full object-cover">
                            @else
                                <x-lucide-image class="w-24 h-24 text-gray-400 dark:text-gray-500 opacity-50" />
                            @endif
                            <div class="absolute top-4 left-4 bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-bold text-gray-800 dark:text-gray-200 shadow-sm border border-white/20">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </div>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="w-full md:w-1/2 flex flex-col justify-center">
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white mb-4">{{ $product->name }}</h1>
                        
                        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-4xl font-black text-indigo-600 dark:text-indigo-400">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <span class="bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300 text-xs font-bold px-3 py-1.5 rounded-md border border-green-200 dark:border-green-800">
                                Stok: {{ $product->stock }}
                            </span>
                        </div>

                        <div class="prose max-w-none text-gray-600 dark:text-gray-300 text-lg leading-relaxed mb-8">
                            {{ $product->description }}
                        </div>

                        @auth
                            <form action="{{ route('cart.store', $product) }}" method="POST" class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
                                @csrf
                                <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah Pembelian</label>
                                <div class="flex items-center gap-4">
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="block w-24 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-12 px-4">
                                    <button type="submit" class="flex-1 h-12 flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 border border-transparent rounded-lg text-white font-bold shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                                        <x-lucide-shopping-cart class="w-5 h-5" /> 
                                        Masukkan Keranjang
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-200 px-6 py-4 rounded-xl flex items-center gap-3">
                                <x-lucide-alert-circle class="w-6 h-6 flex-shrink-0" />
                                <div>
                                    <span class="block mb-1">Anda harus masuk (login) untuk membeli.</span>
                                    <a href="{{ route('login') }}" class="font-bold underline hover:text-yellow-600 dark:hover:text-yellow-400 transition">Login sekarang &rarr;</a>
                                </div>
                            </div>
                        @endauth

                        <div class="mt-8 space-y-4">
                            <div class="flex items-center gap-3 text-gray-500 dark:text-gray-400">
                                <x-lucide-shield-check class="w-5 h-5 text-green-500" />
                                <span class="text-sm">Jaminan kualitas original 100%</span>
                            </div>
                            <div class="flex items-center gap-3 text-gray-500 dark:text-gray-400">
                                <x-lucide-truck class="w-5 h-5 text-blue-500" />
                                <span class="text-sm">Pengiriman aman & cepat ke seluruh Indonesia</span>
                            </div>
                        </div>

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
