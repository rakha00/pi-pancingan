<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-col md:flex-row gap-8">
                    
                    <div class="w-full md:w-1/2">
                        @if($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" class="w-full h-auto rounded-lg shadow-md">
                        @else
                            <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-500 rounded-lg">No Image</div>
                        @endif
                    </div>

                    <div class="w-full md:w-1/2">
                        <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mb-4">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        
                        <p class="text-4xl font-extrabold text-indigo-600 mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                        <div class="prose max-w-none text-gray-700 mb-6">
                            {{ $product->description }}
                        </div>

                        <p class="text-sm text-gray-600 mb-6">Available Stock: <strong>{{ $product->stock }}</strong></p>

                        @auth
                            <form action="{{ route('cart.store', $product) }}" method="POST" class="flex items-center gap-4">
                                @csrf
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-24">
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md shadow transition w-full md:w-auto">
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                                You must be logged in to add items to your cart. 
                                <a href="{{ route('login') }}" class="font-bold underline">Login here</a>.
                            </div>
                        @endauth

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
