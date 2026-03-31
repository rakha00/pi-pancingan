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
                            <a href="{{ route('admin.orders.index') }}" class="ml-1 md:ml-2 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Daftar Pesanan</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <x-lucide-chevron-right class="w-4 h-4 text-gray-400" />
                            <span class="ml-1 text-gray-700 dark:text-gray-200 md:ml-2">Detail Pesanan</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Detail Pesanan') }} <span class="text-indigo-600 dark:text-indigo-400">#{{ $order->id }}</span>
                </h2>
                <span class="px-4 py-1.5 inline-flex text-sm font-bold rounded-full shadow-sm
                    @if($order->status === 'paid' || $order->status === 'delivered') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 border border-green-200 dark:border-green-800/50
                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-800/50
                    @elseif($order->status === 'shipped') bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 border border-blue-200 dark:border-blue-800/50
                    @elseif($order->status === 'canceled' || $order->status === 'failed' || $order->status === 'reported') bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 border border-red-200 dark:border-red-800/50
                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600 @endif">
                    Status: {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Order Info -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700 p-6 md:p-8 transition-colors">
                        <div class="flex items-center gap-3 mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                            <x-lucide-shopping-bag class="w-6 h-6 text-indigo-500 dark:text-indigo-400" />
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Daftar Item</h3>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left table-auto">
                                <thead>
                                    <tr>
                                        <th class="py-3 px-4 bg-gray-50 dark:bg-gray-900/50 font-semibold text-gray-600 dark:text-gray-400 text-sm rounded-l-lg">Produk</th>
                                        <th class="py-3 px-4 bg-gray-50 dark:bg-gray-900/50 font-semibold text-gray-600 dark:text-gray-400 text-sm text-right">Harga</th>
                                        <th class="py-3 px-4 bg-gray-50 dark:bg-gray-900/50 font-semibold text-gray-600 dark:text-gray-400 text-sm text-center">Qty</th>
                                        <th class="py-3 px-4 bg-gray-50 dark:bg-gray-900/50 font-semibold text-gray-600 dark:text-gray-400 text-sm text-right rounded-r-lg">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr class="border-b border-gray-100 dark:border-gray-700/50">
                                        <td class="py-4 px-4 flex items-center">
                                            @if($item->product && $item->product->image_path)
                                                <img src="{{ Storage::url($item->product->image_path) }}" class="h-12 w-12 object-cover rounded-lg shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-100/10 mr-4">
                                            @else
                                                <div class="h-12 w-12 bg-gray-100 dark:bg-gray-700 flex items-center justify-center rounded-lg mr-4 border border-dashed border-gray-300 dark:border-gray-600">
                                                    <x-lucide-image-off class="w-5 h-5 text-gray-400" />
                                                </div>
                                            @endif
                                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ $item->product->name ?? 'Unknown Product' }}</span>
                                        </td>
                                        <td class="py-4 px-4 text-right text-gray-700 dark:text-gray-300">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="bg-indigo-50 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300 px-2.5 py-1 rounded-md font-bold text-xs">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="py-4 px-4 text-right font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="py-6 px-4 text-right font-bold text-lg text-gray-700 dark:text-gray-300">Total Keseluruhan</td>
                                        <td class="py-6 px-4 text-right font-black text-2xl text-indigo-600 dark:text-indigo-400">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Customer Info & Status Update -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700 p-6 transition-colors">
                        <div class="flex items-center gap-2 mb-4 border-b border-gray-100 dark:border-gray-700 pb-3">
                            <x-lucide-user class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Informasi Pelanggan</h3>
                        </div>
                        
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs uppercase tracking-wider font-semibold text-gray-500 dark:text-gray-400 mb-1">Nama Pembeli</p>
                                <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $order->user->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wider font-semibold text-gray-500 dark:text-gray-400 mb-1">Email</p>
                                <p class="text-gray-900 dark:text-gray-100">{{ $order->user->email ?? 'N/A' }}</p>
                            </div>
                            <div class="pt-2">
                                <p class="text-xs uppercase tracking-wider font-semibold text-gray-500 dark:text-gray-400 mb-2">Alamat Pengiriman</p>
                                <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-sm whitespace-pre-line leading-relaxed">
                                    <x-lucide-map-pin class="w-4 h-4 inline text-indigo-500 mb-1 mr-1" />{{ $order->shipping_address }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700 p-6 transition-colors">
                        <div class="flex items-center gap-2 mb-4 border-b border-gray-100 dark:border-gray-700 pb-3">
                            <x-lucide-settings class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Pembaruan Status</h3>
                        </div>
                        
                        @if($order->status == 'paid')
                            <!-- Quick Ship Button if Paid -->
                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mb-6 bg-blue-50 dark:bg-blue-900/20 p-5 rounded-xl border border-blue-200 dark:border-blue-800/50">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="shipped">
                                <div class="mb-4">
                                    <h4 class="font-bold text-blue-800 dark:text-blue-300 flex items-center gap-2"><x-lucide-check-circle class="w-5 h-5"/> Pembayaran Diterima!</h4>
                                    <p class="text-sm text-blue-600 dark:text-blue-400 mt-1 leading-relaxed">Persiapkan produk dan lakukan pengiriman. Jika sudah, klik tombol di bawah.</p>
                                </div>
                                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-bold py-2.5 px-4 rounded-lg shadow-md transition-all hover:-translate-y-0.5">
                                    <x-lucide-truck class="w-5 h-5" /> Tandai Barang Dikirim
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label class="block text-xs uppercase tracking-wider font-semibold text-gray-500 dark:text-gray-400 mb-2">Ubah Status Manual</label>
                                <select name="status" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                                    <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid (Sudah Dibayar)</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (Dalam Pengiriman)</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered (Selesai/Diterima)</option>
                                    <option value="reported" {{ $order->status == 'reported' ? 'selected' : '' }}>Reported (Bermasalah)</option>
                                    <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed (Gagal)</option>
                                    <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled (Dibatalkan)</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gray-800 hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 text-white font-bold py-2.5 px-4 rounded-lg transition-colors">
                                <x-lucide-save class="w-4 h-4" /> Simpan Perubahan
                            </button>
                        </form>
                    </div>
                    
                    <!-- Laporan Pembeli -->
                    @if($order->reports && $order->reports->count() > 0)
                    <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-900/50 shadow-sm sm:rounded-2xl p-6 transition-colors mb-6">
                        <div class="flex items-center gap-2 mb-4 border-b border-red-200 dark:border-red-900/50 pb-3">
                            <x-lucide-alert-triangle class="w-5 h-5 text-red-600 dark:text-red-500" />
                            <h3 class="text-lg font-bold text-red-800 dark:text-red-400">Laporan Kendala</h3>
                        </div>
                        
                        <div class="space-y-4 pt-2">
                            @foreach($order->reports as $report)
                                <div class="bg-white dark:bg-red-900/20 p-4 rounded-xl shadow-sm border border-red-100 dark:border-red-900/30">
                                    <div class="flex justify-between items-start mb-3">
                                        <span class="font-bold text-red-700 dark:text-red-300 text-xs px-2.5 py-1 bg-red-100 dark:bg-red-900/50 rounded-md border border-red-200 dark:border-red-800/50 uppercase tracking-wide">
                                            {{ $report->reason_type }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 font-medium bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">{{ $report->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <p class="text-gray-800 dark:text-gray-200 text-sm whitespace-pre-line leading-relaxed italic bg-gray-50 dark:bg-gray-900/50 p-3 rounded-lg border-l-4 border-red-400 dark:border-red-500">"{{ $report->description }}"</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
