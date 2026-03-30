<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome to Pi-Pancingan E-Commerce') }}
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

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    @if($product->image_path)
                        <img src="{{ Storage::url($product->image_path) }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">No Image</div>
                    @endif
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        <p class="text-blue-600 font-bold mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <a href="{{ route('product.show', $product->slug) }}" class="mt-4 block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded">
                            View Details
                        </a>
                    </div>
                </div>
                @empty
                    <div class="col-span-full text-center p-6 bg-white rounded-lg shadow-md text-gray-500">
                        No products available at the moment.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
