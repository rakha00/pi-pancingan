<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 transition-colors">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">Total Revenue</h3>
                    <p class="text-3xl font-extrabold text-green-600 dark:text-green-400 mt-2">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 transition-colors">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">Total Orders</h3>
                    <p class="text-3xl font-extrabold text-blue-600 dark:text-blue-400 mt-2">{{ $ordersCount }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 transition-colors">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">Total Products</h3>
                    <p class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-2">{{ $productsCount }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <h3 class="text-xl font-bold mb-4">Recent Orders</h3>
                    @if($recentOrders->count() > 0)
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Order ID</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Total</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">#{{ $order->id }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">{{ $order->user->name ?? 'Guest' }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($order->status === 'paid' || $order->status === 'delivered') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                            @elseif($order->status === 'shipped') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                            @elseif($order->status === 'canceled' || $order->status === 'failed' || $order->status === 'reported') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No recent orders found.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
