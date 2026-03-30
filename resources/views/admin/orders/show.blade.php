<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details #') }}{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Order Info -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2">Items</h3>
                        <table class="w-full text-left table-auto">
                            <thead>
                                <tr>
                                    <th class="py-2 border-b">Product</th>
                                    <th class="py-2 border-b">Price</th>
                                    <th class="py-2 border-b">Qty</th>
                                    <th class="py-2 border-b text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="py-3 border-b flex items-center">
                                        @if($item->product && $item->product->image_path)
                                            <img src="{{ Storage::url($item->product->image_path) }}" class="h-10 w-10 object-cover rounded mr-3">
                                        @else
                                            <div class="h-10 w-10 bg-gray-200 rounded mr-3"></div>
                                        @endif
                                        <span>{{ $item->product->name ?? 'Unknown Product' }}</span>
                                    </td>
                                    <td class="py-3 border-b">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="py-3 border-b">{{ $item->quantity }}</td>
                                    <td class="py-3 border-b text-right font-semibold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="py-4 text-right font-bold text-lg">Total</td>
                                    <td class="py-4 text-right font-bold text-xl text-blue-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

        <!-- Customer Info & Status Update -->
        <div class="space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Customer Info</h3>
                <p class="mb-1"><span class="font-semibold text-gray-600">Name:</span> {{ $order->user->name ?? 'N/A' }}</p>
                <p class="mb-1"><span class="font-semibold text-gray-600">Email:</span> {{ $order->user->email ?? 'N/A' }}</p>
                <h4 class="font-semibold mt-4 text-gray-600">Shipping Address:</h4>
                <p class="text-gray-800 bg-gray-50 p-3 rounded mt-1 text-sm whitespace-pre-line">{{ $order->shipping_address }}</p>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Order Status</h3>
                
                @if($order->status == 'paid')
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mb-6 bg-blue-50 p-4 rounded-lg flex items-center justify-between border border-blue-200">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="shipped">
                        <div>
                            <p class="font-bold text-blue-800">Pembayaran telah diterima.</p>
                            <p class="text-sm text-blue-600">Tekan tombol di samping untuk mengonfirmasi bahwa barang telah dikirim.</p>
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition">
                            Kirim Barang 🚀
                        </button>
                    </form>
                @endif
                
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <span class="block text-sm font-medium text-gray-700 mb-2">Update Status Manual</span>
                        <select name="status" class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid (Dibayar)</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (Dikirim)</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered (Selesai)</option>
                            <option value="reported" {{ $order->status == 'reported' ? 'selected' : '' }}>Reported (Bermasalah)</option>
                            <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition">
                        Update Status
                    </button>
                </form>
            </div>
            
            @if($order->reports && $order->reports->count() > 0)
            <div class="bg-red-50 border border-red-200 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b border-red-200 pb-2 text-red-800">Laporan Customer</h3>
                @foreach($order->reports as $report)
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-red-100 mb-3">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-bold text-red-700 uppercase text-xs px-2 py-1 bg-red-100 rounded">{{ $report->reason_type }}</span>
                            <span class="text-xs text-gray-500">{{ $report->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <p class="text-gray-800 text-sm whitespace-pre-line">{{ $report->description }}</p>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
            </div>
        </div>
    </div>
</x-admin-layout>
