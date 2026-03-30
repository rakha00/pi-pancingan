<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Order Summary</h3>
                    <ul class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                        <li class="flex justify-between items-center text-sm">
                            <div class="flex items-center">
                                <span class="font-semibold">{{ $item->product->name }}</span>
                                <span class="text-gray-500 ml-2">x {{ $item->quantity }}</span>
                            </div>
                            <span class="text-gray-700">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                        </li>
                        @endforeach
                    </ul>
                    <div class="border-t pt-4 flex justify-between items-center outline-none font-bold text-lg">
                        <span>Total to Pay:</span>
                        <span class="text-indigo-600 text-xl">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-fit">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Shipping Information</h3>
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Full Delivery Address</label>
                            <textarea name="address" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Jalan Pancingan No 123, Rt 02 Rw 01, Jakarta..."></textarea>
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow transition">
                            Create Order & Pay
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
