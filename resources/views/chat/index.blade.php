<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-100 flex flex-col h-[700px]">
                <!-- Header -->
                <div class="p-4 border-b border-gray-100 bg-white flex items-center justify-between z-10 sticky top-0">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold border-2 border-white shadow-sm">
                                A
                            </div>
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800 leading-tight">Admin Store</h2>
                            <p class="text-xs text-gray-500 font-medium flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span> Online
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('home') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                        <x-lucide-x class="w-5 h-5" />
                    </a>
                </div>

                <!-- Chat Area (Alpine JS Component) -->
                <div x-data="chatComponent()" x-init="init()" class="flex-grow flex flex-col overflow-hidden bg-gray-50/50">
                    
                    <!-- Messages List -->
                    <div class="flex-grow overflow-y-auto p-4 md:p-6 space-y-4" id="chat-messages" x-ref="messagesContainer">
                        <template x-for="msg in messages" :key="msg.id">
                            <div :class="{'flex justify-start': msg.isAdmin, 'flex justify-end': !msg.isAdmin}">
                                <div class="max-w-[75%] md:max-w-[60%] flex flex-col" :class="{'items-start': msg.isAdmin, 'items-end': !msg.isAdmin}">
                                    <!-- Order Card Reference -->
                                    <template x-if="msg.order">
                                        <div class="mb-1.5 bg-gray-50 border border-indigo-100 rounded-lg p-2.5 shadow-sm text-sm w-full cursor-pointer hover:bg-indigo-50 hover:border-indigo-300 transition-colors"
                                             @click="window.location.href = '/orders/' + msg.order.id">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="font-bold text-indigo-800" x-text="msg.order.order_number"></span>
                                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700 uppercase tracking-wider" x-text="msg.order.status"></span>
                                            </div>
                                            <div class="text-[11px] text-gray-500 font-medium flex justify-between items-center">
                                                <span>Total Belanja</span>
                                                <span class="text-gray-700 font-bold">Rp <span x-text="new Intl.NumberFormat('id-ID').format(msg.order.total_price)"></span></span>
                                            </div>
                                        </div>
                                    </template>

                                    <div class="px-4 py-2.5 rounded-2xl shadow-sm text-sm" 
                                         :class="{'bg-white text-gray-800 border border-gray-100 rounded-tl-sm': msg.isAdmin, 'bg-indigo-600 text-white rounded-tr-sm': !msg.isAdmin}">
                                        <p x-text="msg.content" class="whitespace-pre-line break-words"></p>
                                    </div>
                                    <span class="text-[10px] text-gray-400 mt-1 font-medium px-1" x-text="msg.time"></span>
                                </div>
                            </div>
                        </template>
                        
                        <!-- Empty state -->
                        <div x-show="messages.length === 0" class="h-full flex flex-col items-center justify-center text-gray-400 space-y-3" style="display: none;">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-100">
                                <x-lucide-message-circle class="w-8 h-8 text-indigo-300" />
                            </div>
                            <p class="text-sm font-medium">Belum ada obrolan. Sapa admin sekarang!</p>
                        </div>
                    </div>

                    <div class="p-4 bg-white border-t border-gray-100 inline-block w-full transition-all">
                        <form @submit.prevent="sendMessage" class="flex flex-col gap-2 relative">
                            <!-- Order Select Dropdown -->
                            <div class="w-full mb-1" x-show="showOrderSelect" style="display: none;" x-transition>
                                <select x-model="selectedOrderId" class="w-full text-sm border border-gray-200 rounded-xl focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-700 bg-gray-50 p-2.5 outline-none font-medium cursor-pointer shadow-sm">
                                    <option value="">-- Pilih Pesanan Konsultasi (Opsional) --</option>
                                    @foreach($orders as $order)
                                        <option value="{{ $order->id }}">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }} - Rp {{ number_format($order->total_price, 0, ',', '.') }} ({{ ucfirst($order->status) }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex gap-2 relative items-center w-full">
                                <button type="button" @click="showOrderSelect = !showOrderSelect" class="p-2.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-full transition-colors focus:outline-none flex-shrink-0" :class="{'text-indigo-600 bg-indigo-50': selectedOrderId}" title="Tautkan Pesanan">
                                    <x-lucide-paperclip class="w-5 h-5" />
                                </button>
                                
                                <input type="text" x-model="newMessage" placeholder="Tulis pesan untuk Admin..." 
                                    class="w-full bg-gray-50 rounded-full pl-5 pr-12 py-3 border border-transparent focus:border-indigo-300 focus:bg-white focus:ring-2 focus:ring-indigo-200 transition-all text-sm outline-none shadow-sm flex-grow"
                                    :disabled="sending">
                                
                                <button type="submit" :disabled="!newMessage.trim() || sending" 
                                    class="absolute right-2 top-1.5 bottom-1.5 aspect-square rounded-full bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white flex items-center justify-center transition-colors shadow-sm">
                                    <x-lucide-send class="w-4 h-4 ml-0.5" x-show="!sending" />
                                    <x-lucide-loader-2 class="w-4 h-4 animate-spin" x-show="sending" style="display: none;" />
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function chatComponent() {
            return {
                messages: [],
                newMessage: '',
                sending: false,
                selectedOrderId: '',
                showOrderSelect: false,
                customerId: {{ auth()->id() }},
                
                init() {
                    this.fetchMessages();
                    
                    if (window.Echo) {
                        window.Echo.private('chat.room.' + this.customerId)
                            .listen('.MessageSent', (e) => {
                                if (!this.messages.find(m => m.id === e.id)) {
                                    this.messages.push(e);
                                    this.scrollToBottom();
                                }
                            });
                    }
                },
                
                scrollToBottom() {
                    setTimeout(() => {
                        const container = this.$refs.messagesContainer;
                        if(container) {
                            container.scrollTop = container.scrollHeight;
                        }
                    }, 50);
                },
                
                async fetchMessages(forceScroll = true) {
                    try {
                        const response = await fetch('{{ route('chat.messages') }}');
                        const data = await response.json();
                        
                        this.messages = data;
                        if (forceScroll) {
                            this.scrollToBottom();
                        }
                    } catch (error) {
                        console.error("Error fetching messages:", error);
                    }
                },
                
                async sendMessage() {
                    if (!this.newMessage.trim()) return;
                    
                    this.sending = true;
                    
                    const msgContent = this.newMessage;
                    const orderId = this.selectedOrderId;
                    this.newMessage = '';
                    this.selectedOrderId = '';
                    this.showOrderSelect = false;
                    
                    try {
                        await fetch('{{ route('chat.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                content: msgContent,
                                order_id: orderId || null
                            })
                        });
                        
                    } catch (error) {
                        console.error("Error sending message:", error);
                    } finally {
                        this.sending = false;
                    }
                }
            }
        }
    </script>
</x-app-layout>
