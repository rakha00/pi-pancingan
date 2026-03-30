<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Created Successfully!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center p-8">
                
                <div class="mb-6">
                    <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-gray-800 mb-2">Thank you for your order!</h3>
                <p class="text-gray-600 mb-6">Order ID: <strong>#{{ $order->id }}</strong></p>
                <p class="text-gray-600 mb-8">Your order has been saved successfully. Please complete the payment process below.</p>

                @if($order->snap_token)
                    <button id="pay-button" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg text-lg transition mb-8 w-full md:w-auto">
                        Pay with Midtrans
                    </button>

                    <!-- Midtrans Snap Script -->
                    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') ?? env('MIDTRANS_CLIENT_KEY') }}"></script>
                    <script type="text/javascript">
                        document.getElementById('pay-button').onclick = function(){
                            snap.pay('{{ $order->snap_token }}', {
                                onSuccess: function(result){
                                    window.location.href = "{{ route('home') }}";
                                },
                                onPending: function(result){
                                    window.location.href = "{{ route('home') }}";
                                },
                                onError: function(result){
                                    alert("Payment failed!");
                                },
                                onClose: function(){
                                    console.log('Customer closed the popup without finishing the payment');
                                }
                            });
                        };
                    </script>
                @else
                    <div class="bg-yellow-100 text-yellow-800 p-4 rounded text-left mt-4 border border-yellow-300">
                        <p><strong>Notice:</strong> The payment gateway (Midtrans) was not fully configured (missing Server Key). This order is saved as pending in the database.</p>
                    </div>
                @endif
                
                <div class="mt-8 border-t pt-6 text-left">
                    <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold underline">
                        &larr; Back to Shop
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
