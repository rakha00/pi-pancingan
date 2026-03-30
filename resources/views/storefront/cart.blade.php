<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    @if($cartItems->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            Your cart is empty. <br>
                            <a href="{{ route('home') }}" class="text-indigo-600 font-semibold underline mt-2 block">Go Shopping</a>
                        </div>
                    @else
                        <table class="w-full text-left table-auto">
                            <thead>
                                <tr>
                                    <th class="py-3 border-b-2 text-left">Product</th>
                                    <th class="py-3 border-b-2 text-left">Price</th>
                                    <th class="py-3 border-b-2 text-left">Quantity</th>
                                    <th class="py-3 border-b-2 text-right">Subtotal</th>
                                    <th class="py-3 border-b-2 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($cartItems as $item)
                                    @php $subtotal = $item->product->price * $item->quantity; $total += $subtotal; @endphp
                                    <tr>
                                        <td class="py-4 border-b">
                                            <div class="flex items-center">
                                                @if($item->product->image_path)
                                                    <img src="{{ Storage::url($item->product->image_path) }}" class="w-16 h-16 object-cover rounded mr-4">
                                                @else
                                                    <div class="w-16 h-16 bg-gray-200 rounded mr-4"></div>
                                                @endif
                                                <span class="font-semibold">{{ $item->product->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 border-b text-gray-600">Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                        <td class="py-4 border-b">
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="w-16 border-gray-300 rounded shadow-sm">
                                                <button type="submit" class="text-indigo-600 hover:text-indigo-900 text-sm font-semibold">Update</button>
                                            </form>
                                        </td>
                                        <td class="py-4 border-b text-right font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                        <td class="py-4 border-b text-center">
                                            <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="py-6 text-right font-bold text-xl">Grand Total</td>
                                    <td class="py-6 text-right font-bold text-2xl text-indigo-600">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="mt-8 flex justify-end">
                            <a href="{{ route('checkout.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg text-lg transition">
                                Proceed to Checkout
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
