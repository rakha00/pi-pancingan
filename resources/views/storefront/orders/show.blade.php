<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-indigo-500 transition"><x-lucide-arrow-left class="w-6 h-6" /></a>
                {{ __('Detail Pesanan #') }}{{ $order->id }}
            </h2>
            <div>
                @if($order->status == 'pending')
                    <span class="px-4 py-1.5 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-400">Menunggu Pembayaran</span>
                @elseif($order->status == 'paid')
                    <span class="px-4 py-1.5 rounded-full text-sm font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-400">Dikemas</span>
                @elseif($order->status == 'shipped')
                    <span class="px-4 py-1.5 rounded-full text-sm font-bold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-400 flex items-center gap-2"><x-lucide-truck class="w-4 h-4"/> Sedang Dikirim</span>
                @elseif($order->status == 'delivered')
                    <span class="px-4 py-1.5 rounded-full text-sm font-bold bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400 flex items-center gap-2"><x-lucide-check-circle class="w-4 h-4"/> Selesai</span>
                @elseif($order->status == 'reported')
                    <span class="px-4 py-1.5 rounded-full text-sm font-bold bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-400">Dalam Komplain</span>
                @else
                    <span class="px-4 py-1.5 rounded-full text-sm font-bold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Dibatalkan / Gagal</span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl relative shadow-sm flex items-center gap-3">
                    <x-lucide-check-circle class="w-5 h-5" /> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-6 md:p-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">Produk yang Dipesan</h3>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4 p-4 border border-gray-100 dark:border-gray-700 rounded-xl">
                            <div class="w-20 h-20 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 flex-shrink-0 flex items-center justify-center">
                                @if($item->product && $item->product->image_path)
                                    <img src="{{ Storage::url($item->product->image_path) }}" class="w-full h-full object-cover">
                                @else
                                    <x-lucide-image class="w-6 h-6 text-gray-400 opacity-50" />
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white">{{ $item->product->name ?? 'Produk Tidak Ditemukan' }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}</p>
                                </div>
                                <p class="font-black text-indigo-600 dark:text-indigo-400 text-lg">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center text-xl">
                        <span class="font-bold text-gray-600 dark:text-gray-400">Total Harga</span>
                        <span class="font-black text-indigo-600 dark:text-indigo-400 text-2xl">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Data Pengiriman -->
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700 p-6 md:p-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">Alamat Pengiriman</h3>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $order->shipping_address }}</p>
                </div>

                <!-- Aksi Pesanan -->
                <div class="bg-indigo-50 dark:bg-indigo-900/10 shadow-xl sm:rounded-2xl border border-indigo-100 dark:border-indigo-900 p-6 md:p-8 flex flex-col justify-center">
                    @if($order->status == 'shipped')
                        <h3 class="text-lg font-bold text-indigo-900 dark:text-indigo-300 mb-2">Barang Anda Sedang Dalam Perjalanan!</h3>
                        <p class="text-indigo-700/80 dark:text-indigo-400/80 text-sm mb-6">Jika barang sudah Anda terima dengan baik, silakan lakukan konfirmasi. Atau laporkan masalah jika terdapat kendala.</p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <form action="{{ route('orders.confirm', $order) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Apakah Anda yakin barang sudah diterima dengan kondisi baik?')" class="w-full flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition-transform hover:-translate-y-1">
                                    <x-lucide-check-circle class="w-5 h-5" /> Pesanan Diterima
                                </button>
                            </form>
                            
                            <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'report-order')" class="w-full flex items-center justify-center gap-2 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400 font-bold border border-red-200 dark:border-red-900/50 py-3 px-4 rounded-xl shadow-sm transition-colors">
                                <x-lucide-alert-circle class="w-5 h-5" /> Lapor Masalah
                            </button>
                        </div>
                    @elseif($order->status == 'delivered')
                        <div class="text-center">
                            <div class="bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <x-lucide-check-circle class="w-10 h-10" />
                            </div>
                            <h3 class="text-lg font-bold text-green-900 dark:text-green-300 mb-2">Pesanan Telah Selesai</h3>
                            <p class="text-green-700/80 dark:text-green-400/80 text-sm">Terima kasih telah berbelanja di Pi-Pancingan! Pesanan di atas sudah diterima.</p>
                        </div>
                    @elseif($order->status == 'reported')
                        <div class="text-center">
                            <div class="bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <x-lucide-alert-triangle class="w-10 h-10" />
                            </div>
                            <h3 class="text-lg font-bold text-red-900 dark:text-red-300 mb-2">Pesanan Dalam Proses Komplain</h3>
                            <p class="text-red-700/80 dark:text-red-400/80 text-sm">Masalah Anda sedang ditinjau oleh tim kami. Harap menunggu informasi selanjutnya.</p>
                        </div>
                    @elseif($order->status == 'pending')
                        <div class="text-center">
                            <h3 class="text-lg font-bold text-indigo-900 dark:text-indigo-300 mb-2">Menunggu Pembayaran</h3>
                            <p class="text-indigo-700/80 dark:text-indigo-400/80 text-sm mb-6">Selesaikan pembayaran via Midtrans agar pesanan Anda segera kami proses dan kirimkan.</p>

                            @if($order->snap_token)
                                <button id="pay-button" class="w-full relative shadow-lg bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl transition-all hover:-translate-y-1 overflow-hidden flex items-center justify-center gap-2 group">
                                    <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                                    <x-lucide-credit-card class="w-5 h-5 relative z-10" />
                                    <span class="relative z-10">Selesaikan Pembayaran Sekarang</span>
                                </button>

                                <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') ?? env('MIDTRANS_CLIENT_KEY') }}"></script>
                                <script type="text/javascript">
                                    document.getElementById('pay-button').onclick = function(){
                                        snap.pay('{{ $order->snap_token }}', {
                                            onSuccess: function(result){
                                                window.location.reload();
                                            },
                                            onPending: function(result){
                                                window.location.reload();
                                            },
                                            onError: function(result){
                                                alert("Pembayaran Gagal!");
                                            },
                                            onClose: function(){
                                                console.log('Customer closed the popup without finishing the payment');
                                            }
                                        });
                                    };
                                </script>
                            @else
                                <div class="bg-red-50 text-red-700 p-3 rounded-lg text-sm border border-red-200 text-left flex items-start gap-2">
                                    <x-lucide-alert-triangle class="w-5 h-5" /> <span>Token Incomplete. Konfigurasi Gateway Payment bermasalah.</span>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center opacity-70">
                            <x-lucide-clock class="w-12 h-12 mx-auto mb-3 text-indigo-400" />
                            <p class="text-indigo-900 dark:text-indigo-300 text-sm font-medium">Status Anda saat ini tidak memerlukan intervensi lanjutan. Harap tunggu proses dari toko kami.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Laporan -->
    <x-modal name="report-order" maxWidth="lg">
        <form method="post" action="{{ route('orders.report', $order) }}" class="p-6">
            @csrf
            <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-4 border-b border-gray-100 dark:border-gray-700 pb-3">
                <x-lucide-alert-octagon class="w-5 h-5 text-red-500" /> Laporkan Masalah Pesanan
            </h2>

            <div class="space-y-4">
                <div>
                    <x-input-label for="reason_type" value="Jenis Kendala" />
                    <select id="reason_type" name="reason_type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="Barang belum sampai">Barang belum sampai dalam batas waktu normal</option>
                        <option value="Barang tidak sesuai/rusak">Barang yang datang tidak sesuai / rusak</option>
                        <option value="Barang kurang">Kuantitas di dalam paket kurang</option>
                        <option value="Lainnya">Masalah lainnya</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="description" value="Deskripsi Detail Masalah" />
                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Jelaskan secara detail masalah pada pesanan Anda..."></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                    Kirim Laporan
                </button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
