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
                            <span class="ml-1 text-gray-700 dark:text-gray-200 md:ml-2">Daftar Pesanan</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kelola Pesanan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl transition-colors border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Order ID</th>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Pembayaran</th>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-5 py-4 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm font-semibold text-indigo-600 dark:text-indigo-400">#{{ $order->id }}</td>
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    <div class="flex items-center gap-2">
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold">
                                            {{ substr($order->user->name ?? '?', 0, 1) }}
                                        </div>
                                        {{ $order->user->name ?? 'Deleted User' }}
                                    </div>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm text-gray-800 dark:text-gray-200 font-medium">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm">
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full 
                                        @if($order->status === 'paid' || $order->status === 'delivered') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 border border-green-200 dark:border-green-800/50
                                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-800/50
                                        @elseif($order->status === 'shipped') bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 border border-blue-200 dark:border-blue-800/50
                                        @elseif($order->status === 'canceled' || $order->status === 'failed' || $order->status === 'reported') bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 border border-red-200 dark:border-red-800/50
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-100 dark:border-gray-700 text-sm text-right">
                                    <div class="flex space-x-2 items-center justify-end">
                                        @if($order->status === 'paid')
                                            <!-- Quick Ship Button if Paid -->
                                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="inline m-0" onsubmit="return confirm('Kirim pesanan ini sekarang?');">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="shipped">
                                                <button type="submit" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-900 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/80 dark:hover:text-blue-300 rounded-lg transition-colors" title="Konfirmasi & Kirim Barang">
                                                    <x-lucide-truck class="w-5 h-5" />
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.orders.show', $order) }}" class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-900 dark:bg-indigo-900/30 dark:text-indigo-400 dark:hover:bg-indigo-900/80 dark:hover:text-indigo-300 rounded-lg transition-colors" title="Lihat Detail Pesanan">
                                            <x-lucide-eye class="w-5 h-5" />
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 border-b border-gray-200 dark:border-gray-700 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <x-lucide-shopping-bag class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" />
                                        <p class="text-base font-medium">Belum ada pesanan yang masuk.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    @if($orders->hasPages())
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
