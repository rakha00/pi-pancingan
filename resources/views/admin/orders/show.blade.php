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
                        <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <span class="block text-sm font-medium text-gray-700 mb-2">Current Status</span>
                                <select name="status" class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition">
                                Update Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
