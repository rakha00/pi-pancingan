<x-app-layout>
    <!-- Hero Section -->
    <div class="relative bg-indigo-900 overflow-hidden">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl uppercase">
                Cast Deeper, Catch Bigger
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-indigo-100">
                Temukan peralatan pancing kualitas terbaik untuk menemani petualangan Anda. Dari joran, reel, hingga umpan premium, kami punya semuanya!
            </p>
            <div class="mt-10">
                <a href="#products" class="inline-flex items-center gap-2 bg-indigo-500 hover:bg-indigo-600 border border-transparent rounded-full px-8 py-3 text-base font-semibold text-white shadow-lg transition-transform hover:-translate-y-1 hover:shadow-xl">
                    <x-lucide-fish class="w-5 h-5" /> Belanja Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div id="products" class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-4xl">Koleksi Alat Pancing</h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 dark:text-gray-400">Peralatan pilihan dari para master angler.</p>
            </div>

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse($products as $product)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col group">
                    <div class="relative overflow-hidden h-56 bg-gray-100 dark:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                        @if($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" class="w-full h-full object-cover transition duration-300 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <x-lucide-image class="w-12 h-12 opacity-50" />
                            </div>
                        @endif
                        <div class="absolute top-3 right-3 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md z-10">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 line-clamp-1 mb-1">{{ $product->name }}</h3>
                        <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-auto mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        
                        <div class="flex gap-2 w-full mt-auto">
                            <a href="{{ route('product.show', $product->slug) }}" class="flex-1 flex items-center justify-center gap-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-semibold py-2.5 rounded-lg transition-colors duration-300" title="Lihat Detail Produk">
                                <x-lucide-eye class="w-4 h-4" /> Detail
                            </a>
                            
                            @auth
                            <form action="{{ route('cart.store', $product) }}" method="POST" class="flex-[1.5]">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full flex items-center justify-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg shadow-sm transition-colors duration-300" title="Langsung Tambahkan ke Keranjang">
                                    <x-lucide-shopping-cart class="w-4 h-4" /> + Keranjang
                                </button>
                            </form>
                            @else
                            <a href="{{ route('login') }}" class="flex-[1.5] flex items-center justify-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg shadow-sm transition-colors duration-300" title="Login untuk Membeli">
                                <x-lucide-shopping-cart class="w-4 h-4" /> + Keranjang
                            </a>
                            @endauth
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-16 text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <x-lucide-box class="w-16 h-16 mb-4 text-gray-300 dark:text-gray-600" />
                        <p class="text-xl font-medium">Belum ada produk alat pancing yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
