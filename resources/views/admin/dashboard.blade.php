<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <x-lucide-layout-dashboard class="w-6 h-6 text-indigo-500" />
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Revenue Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 tracking-wider uppercase">Total Pendapatan</h3>
                        <div class="p-2 bg-green-50 dark:bg-green-900/30 rounded-lg">
                            <x-lucide-wallet class="w-5 h-5 text-green-600 dark:text-green-400" />
                        </div>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 font-medium">Dari pesanan dibayar & terkirim</p>
                    </div>
                </div>

                <!-- Pesanan Baru Card -->
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-6 shadow-md border border-indigo-500 flex flex-col justify-between hover:shadow-lg transition-shadow relative overflow-hidden">
                    <div class="absolute right-0 top-0 opacity-10 transform translate-x-1/4 -translate-y-1/4">
                        <x-lucide-shopping-bag class="w-32 h-32 text-indigo-100" />
                    </div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <h3 class="text-sm font-semibold text-indigo-100 tracking-wider uppercase">Pesanan Baru (Perlu Diproses)</h3>
                        <div class="p-2 bg-indigo-400/30 rounded-lg">
                            <x-lucide-bell-ring class="w-5 h-5 text-white" />
                        </div>
                    </div>
                    <div class="relative z-10">
                        <p class="text-4xl font-black text-white">{{ $incomingOrdersCount }} <span class="text-lg font-medium text-indigo-200">Pesanan</span></p>
                        <p class="text-xs text-indigo-200 mt-2 font-medium">Status Paid, siap kirim!</p>
                    </div>
                </div>

                <!-- Total Orders Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 tracking-wider uppercase">Semua Pesanan</h3>
                        <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                            <x-lucide-shopping-cart class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                        </div>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $ordersCount }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 font-medium">Total riwayat pesanan</p>
                    </div>
                </div>

                <!-- Products Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 tracking-wider uppercase">Total Produk</h3>
                        <div class="p-2 bg-orange-50 dark:bg-orange-900/30 rounded-lg">
                            <x-lucide-package class="w-5 h-5 text-orange-600 dark:text-orange-400" />
                        </div>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $productsCount }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 font-medium">Katalog aktif saat ini</p>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg">
                            <x-lucide-clock class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Pesanan Masuk Terbaru</h3>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors flex items-center gap-1 group">
                        Lihat Semua Pesanan <x-lucide-arrow-right class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" />
                    </a>
                </div>

                <div class="overflow-x-auto">
                    @if($recentOrders->count() > 0)
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-900/50">
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Order ID</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Waktu</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">Total Tagihan</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">Status</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">Quick Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($recentOrders as $order)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors group">
                                    <td class="py-4 px-6">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline inline-flex items-center gap-1">
                                            #ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-100 to-indigo-200 dark:from-indigo-900 dark:to-indigo-800 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold font-mono text-xs">
                                                {{ substr($order->user->name ?? '?', 0, 1) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $order->user->name ?? 'Guest' }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $order->user->email ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-500 dark:text-gray-400 font-medium">
                                        {{ $order->created_at->diffForHumans() }}
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border
                                            @if($order->status === 'paid') bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-900/50 dark:text-indigo-300 dark:border-indigo-800/50
                                            @elseif($order->status === 'delivered' || $order->status === 'shipped') bg-green-50 text-green-700 border-green-200 dark:bg-green-900/50 dark:text-green-300 dark:border-green-800/50
                                            @elseif($order->status === 'pending') bg-yellow-50 text-yellow-700 border-yellow-200 dark:bg-yellow-900/50 dark:text-yellow-300 dark:border-yellow-800/50
                                            @elseif($order->status === 'canceled' || $order->status === 'failed' || $order->status === 'reported') bg-red-50 text-red-700 border-red-200 dark:bg-red-900/50 dark:text-red-300 dark:border-red-800/50
                                            @else bg-gray-50 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right space-x-2 flex justify-end items-center gap-2">
                                        <a href="{{ route('admin.orders.show', $order) }}" title="Lihat Detail Pesanan" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg transition-colors">
                                            <x-lucide-eye class="w-5 h-5" />
                                        </a>

                                        @if($order->status === 'paid')
                                            <!-- Quick Action: Process Order (Set to Shipped) -->
                                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="inline-block" onsubmit="return confirm('Proses pesanan ini untuk dikirim?');">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="shipped">
                                                <button type="submit" title="Proses Pengiriman" class="px-3 py-1.5 flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                                    <x-lucide-truck class="w-4 h-4" /> Kirim
                                                </button>
                                            </form>
                                        @elseif($order->status === 'pending')
                                            <!-- Quick Action: Pending Order, wait for payment -->
                                            <span title="Menunggu Pembayaran Customer" class="px-3 py-1.5 flex items-center gap-1.5 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs font-bold rounded-lg cursor-not-allowed">
                                                <x-lucide-hourglass class="w-4 h-4" /> Menunggu
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-12 text-center flex flex-col items-center justify-center">
                            <div class="w-20 h-20 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                <x-lucide-inbox class="w-10 h-10 text-gray-400 dark:text-gray-500" />
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Belum Ada Pesanan</h3>
                            <p class="text-gray-500 dark:text-gray-400">Pesanan yang masuk akan muncul di daftar ini.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
