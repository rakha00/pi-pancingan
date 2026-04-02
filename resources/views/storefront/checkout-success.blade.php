<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <x-lucide-check-circle class="w-6 h-6 text-green-500" />
            {{ __('Pesanan Berhasil Dibuat!') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden text-center p-10 md:p-16 relative">
                
                <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-green-400 via-emerald-500 to-teal-500"></div>

                <div class="mb-8 relative inline-flex">
                    <div class="absolute inset-0 bg-green-200 dark:bg-green-900/50 rounded-full blur-xl opacity-50"></div>
                    <div class="bg-green-100 dark:bg-gray-700 p-5 rounded-full relative z-10 border-4 border-white dark:border-gray-800 shadow-lg">
                        <x-lucide-check class="mx-auto h-16 w-16 text-green-600 dark:text-green-400 stroke-[3]" />
                    </div>
                </div>

                <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-3">Terima Kasih atas Pesanan Anda!</h3>
                <div class="inline-block bg-gray-100 dark:bg-gray-700 px-5 py-2 rounded-lg mb-8">
                    <p class="text-gray-600 dark:text-gray-300">ID Pesanan: <strong class="text-gray-900 dark:text-white font-mono text-lg ml-2">#{{ $order->id }}</strong></p>
                </div>
                
                <p class="text-gray-600 dark:text-gray-400 mb-10 text-lg leading-relaxed max-w-lg mx-auto">
                    Data pesanan Anda telah disimpan dengan aman di sistem kami. Langkah terakhir adalah <strong class="text-gray-900 dark:text-white">menyelesaikan pembayaran</strong> melalui Midtrans agar kami dapat segera memproses dan mengirimkan peralatan tempur Anda.
                </p>

                @if($order->snap_token)
                    <button id="pay-button" class="group relative bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-10 rounded-2xl shadow-[0_0_20px_rgba(79,70,229,0.4)] transition-all hover:-translate-y-1 mb-10 w-full md:w-auto text-lg overflow-hidden flex items-center gap-3 justify-center mx-auto">
                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        <x-lucide-credit-card class="w-6 h-6 relative z-10" />
                        <span class="relative z-10">Bayar Melalui Midtrans</span>
                    </button>

                    <!-- Midtrans Snap Script -->
                    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') ?? env('MIDTRANS_CLIENT_KEY') }}"></script>
                    <script type="text/javascript">
                        document.getElementById('pay-button').onclick = function(){
                            snap.pay('{{ $order->snap_token }}', {
                                onSuccess: function(result){
                                    window.location.href = "{{ route('orders.index') }}";
                                },
                                onPending: function(result){
                                    window.location.href = "{{ route('orders.index') }}";
                                },
                                onError: function(result){
                                    alert("Payment failed!");
                                },
                                onClose: function(){
                                    console.log('Customer closed the popup without finishing the payment');
                                }
                            });
                        };
                    </script>
                @else
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-200 p-5 rounded-xl text-left mt-4 shadow-sm flex items-start gap-4">
                        <x-lucide-alert-triangle class="w-6 h-6 flex-shrink-0 mt-0.5" />
                        <p class="text-sm"><strong>Pemberitahuan Sistem:</strong> Konfigurasi Midtrans belum lengkap (Server Key tidak ditemukan). Pesanan Anda tersimpan dengan status <em>pending</em>, namun pembayaran tidak dapat diproses secara online saat ini.</p>
                    </div>
                @endif
                
                <div class="mt-8 border-t border-gray-100 dark:border-gray-700 pt-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-bold tracking-wide transition">
                        <x-lucide-arrow-left class="w-5 h-5" /> Kembali Ke Halaman Utama
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
