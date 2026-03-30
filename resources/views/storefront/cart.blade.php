<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <x-lucide-shopping-bag class="w-6 h-6 text-indigo-500" />
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('error'))
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-400 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-xl relative mb-6 shadow-sm flex items-center gap-3">
                    <x-lucide-alert-triangle class="w-5 h-5" /> {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl relative mb-6 shadow-sm flex items-center gap-3">
                    <x-lucide-check-circle class="w-5 h-5" /> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-6 sm:p-10">
                    @if($cartItems->isEmpty())
                        <div class="text-center py-16 text-gray-500 dark:text-gray-400 flex flex-col items-center">
                            <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-full mb-6">
                                <x-lucide-shopping-cart class="w-16 h-16 text-gray-400 dark:text-gray-500" />
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Keranjang Belanja Kosong</h3>
                            <p class="mb-8 max-w-md mx-auto">Anda belum menambahkan peralatan memancing ke keranjang Anda. Yuk mulai berbelanja!</p>
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition-transform hover:-translate-y-1">
                                <x-lucide-store class="w-5 h-5" /> Belanja Sekarang
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b-2 border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">
                                        <th class="py-4 font-semibold">Produk</th>
                                        <th class="py-4 font-semibold hidden md:table-cell">Harga Satuan</th>
                                        <th class="py-4 font-semibold text-center mt-2">Kuantitas</th>
                                        <th class="py-4 font-semibold text-right">Subtotal</th>
                                        <th class="py-4 font-semibold text-center w-16"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @php $total = 0; @endphp
                                    @foreach($cartItems as $item)
                                        @php $subtotal = $item->product->price * $item->quantity; $total += $subtotal; @endphp
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition duration-150">
                                            <td class="py-6">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-20 h-20 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 flex-shrink-0 flex items-center justify-center">
                                                        @if($item->product->image_path)
                                                            <img src="{{ Storage::url($item->product->image_path) }}" class="w-full h-full object-cover">
                                                        @else
                                                            <x-lucide-image class="w-8 h-8 text-gray-400 opacity-50" />
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-gray-900 dark:text-gray-100 text-lg block line-clamp-2 leading-tight mb-1">{{ $item->product->name }}</span>
                                                        <span class="text-xs text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50 dark:bg-indigo-900/30 px-2 py-1 rounded inline-block md:hidden">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-6 text-gray-600 dark:text-gray-300 font-medium hidden md:table-cell">
                                                Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                            </td>
                                            <td class="py-6 text-center">
                                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="relative flex items-center max-w-[8rem]">
                                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="bg-gray-50 dark:bg-gray-800 border-x-0 border-y sm:border-x border-gray-300 dark:border-gray-600 h-11 font-medium text-center text-gray-900 dark:text-white text-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full pb-6 pt-6 sm:rounded-md">
                                                    </div>
                                                    <button type="submit" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-bold bg-indigo-50 dark:bg-indigo-900/20 px-3 py-2 rounded-md transition sm:ml-2">Ubah</button>
                                                </form>
                                            </td>
                                            <td class="py-6 text-right font-black text-gray-900 dark:text-white text-lg">
                                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                                            </td>
                                            <td class="py-6 text-center">
                                                <form action="{{ route('cart.destroy', $item) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 p-2.5 rounded-full transition duration-200 focus:outline-none" title="Hapus Barang">
                                                        <x-lucide-trash-2 class="w-5 h-5" />
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-10 border-t-2 border-dashed border-gray-200 dark:border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
                            <a href="{{ route('home') }}" class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center gap-2 font-medium transition">
                                <x-lucide-arrow-left class="w-5 h-5" /> Lanjut Belanja
                            </a>
                            
                            <div class="flex flex-col md:flex-row items-center gap-6 bg-gray-50 dark:bg-gray-800/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 w-full md:w-auto">
                                <div class="text-center md:text-right">
                                    <span class="block text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider mb-1">Total Belanja</span>
                                    <span class="text-3xl font-black text-indigo-600 dark:text-indigo-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <a href="{{ route('checkout.index') }}" class="w-full md:w-auto flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-10 rounded-xl shadow-lg border border-transparent transition-all hover:scale-[1.02]">
                                    <x-lucide-credit-card class="w-5 h-5" /> Bayar Sekarang
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
