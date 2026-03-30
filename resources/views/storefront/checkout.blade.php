<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <x-lucide-credit-card class="w-6 h-6 text-indigo-500" />
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Column: Shipping Info (Forms) -->
            <div class="lg:col-span-7">
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="bg-indigo-50 dark:bg-gray-800/80 p-6 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white flex items-center gap-3">
                            <x-lucide-map-pin class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                            Informasi Pengiriman
                        </h3>
                    </div>
                    <div class="p-6 md:p-8">
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            
                            <div class="mb-8">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-3">Alamat Lengkap Pengiriman</label>
                                <textarea name="address" rows="5" class="w-full bg-white dark:bg-gray-900 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm transition placeholder-gray-400 dark:placeholder-gray-500 p-4" required placeholder="Contoh: Jl Raya Pancingan No. 123, Kelurahan Maju, Kec. Jaya, Kota Bandar Lampung (Patokan depan tugu ikan)..."></textarea>
                                @error('address') <p class="text-red-500 dark:text-red-400 text-xs italic mt-2">{{ $message }}</p> @enderror
                            </div>

                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 mb-8 flex items-start gap-3">
                                <x-lucide-info class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" />
                                <p class="text-sm text-blue-800 dark:text-blue-200">
                                    Pastikan alamat yang Anda masukkan sudah benar dan spesifik agar kurir dapat menemukan lokasi Anda dengan mudah. Pembayaran akan diproses via Midtrans yang menjamin keamanan transaksi 100%.
                                </p>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 text-lg group">
                                <x-lucide-zap class="w-6 h-6 group-hover:scale-110 transition-transform" />
                                Proses Pembayaran & Buat Pesanan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary Details (Receipt Style) -->
            <div class="lg:col-span-5">
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden sticky top-6">
                    <div class="bg-gray-50 dark:bg-gray-800/80 p-6 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white flex items-center gap-3">
                            <x-lucide-receipt class="w-6 h-6 text-gray-500 dark:text-gray-400" />
                            Ringkasan Pesanan
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <ul class="space-y-5 mb-8 max-h-96 overflow-y-auto pr-2">
                            @foreach($cartItems as $item)
                            <li class="flex items-start gap-4">
                                <div class="w-16 h-16 rounded-md bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden flex-shrink-0 border border-gray-200 dark:border-gray-600">
                                    @if($item->product->image_path)
                                        <img src="{{ Storage::url($item->product->image_path) }}" class="w-full h-full object-cover">
                                    @else
                                        <x-lucide-image class="w-6 h-6 text-gray-400 opacity-50" />
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100 line-clamp-2 leading-tight">{{ $item->product->name }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Rp {{ number_format($item->product->price, 0, ',', '.') }} &times; {{ $item->quantity }}</p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>

                        <div class="border-t-2 border-dashed border-gray-200 dark:border-gray-700 pt-6 space-y-3">
                            <div class="flex justify-between text-gray-600 dark:text-gray-300 text-sm">
                                <span>Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600 dark:text-gray-300 text-sm">
                                <span>Biaya Pengiriman</span>
                                <span class="text-green-600 dark:text-green-400 font-bold">Gratis</span>
                            </div>
                            <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <span class="font-extrabold text-gray-900 dark:text-white text-lg">Total Pembayaran</span>
                                <span class="font-black text-indigo-600 dark:text-indigo-400 text-2xl">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
