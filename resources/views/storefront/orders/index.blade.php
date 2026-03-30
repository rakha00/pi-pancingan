<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <x-lucide-package class="w-6 h-6 text-indigo-500" />
            {{ __('Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-6 sm:p-10">
                    @if($orders->isEmpty())
                        <div class="text-center py-16 text-gray-500 dark:text-gray-400">
                            <x-lucide-inbox class="w-16 h-16 mx-auto mb-4 opacity-50 text-gray-400" />
                            <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">Belum Memiliki Pesanan</h3>
                            <p class="mb-6">Anda belum pernah melakukan pemesanan.</p>
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-full shadow transition-all hover:-translate-y-1">
                                <x-lucide-store class="w-4 h-4" /> Belanja Sekarang
                            </a>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($orders as $order)
                                <a href="{{ route('orders.show', $order) }}" class="block p-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900/50 hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors group">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                        <div>
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="font-bold text-gray-900 dark:text-white">Order #{{ $order->id }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                            </div>
                                            <p class="text-indigo-600 dark:text-indigo-400 font-black text-xl mb-3">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="flex items-center justify-between md:justify-end gap-6">
                                            <div>
                                                @if($order->status == 'pending')
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-400">Menunggu Pembayaran</span>
                                                @elseif($order->status == 'paid')
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-400">Dikemas / Berhasil Dibayar</span>
                                                @elseif($order->status == 'shipped')
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-400 flex items-center gap-1.5"><x-lucide-truck class="w-3 h-3"/> Sedang Dikirim</span>
                                                @elseif($order->status == 'delivered')
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400 flex items-center gap-1.5"><x-lucide-check-circle class="w-3 h-3"/> Selesai</span>
                                                @elseif($order->status == 'reported')
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-400">Dalam Komplain/Dilaporkan</span>
                                                @else
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Dibatalkan</span>
                                                @endif
                                            </div>
                                            <div class="text-gray-400 group-hover:text-indigo-500 dark:group-hover:text-indigo-400 hidden sm:block">
                                                <x-lucide-chevron-right class="w-6 h-6" />
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
