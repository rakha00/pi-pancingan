<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4">
            <nav class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            <x-lucide-home class="w-4 h-4 mr-2" /> Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <x-lucide-chevron-right class="w-4 h-4 text-gray-400" />
                            <a href="{{ route('admin.chats.index') }}" class="ml-1 md:ml-2 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Live Chat Pusat</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <x-lucide-chevron-right class="w-4 h-4 text-gray-400" />
                            <span class="ml-1 text-gray-700 dark:text-gray-200 md:ml-2">{{ $customer->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 overflow-hidden shadow-lg sm:rounded-2xl flex flex-col h-[700px] transition-colors">
                
                <!-- Header -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex items-center justify-between z-10 sticky top-0 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold border-2 border-white dark:border-gray-800 shadow-sm">
                            {{ substr($customer->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 leading-tight">{{ $customer->name }}</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Customer</p>
                        </div>
                    </div>
                </div>

                <!-- Chat Area (Alpine JS Component) -->
                <div x-data="adminChatComponent()" x-init="init()" class="flex-grow flex flex-col overflow-hidden relative">
                    
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-5 dark:opacity-10 pointer-events-none" style="background-image: radial-gradient(#6366f1 1px, transparent 1px); background-size: 20px 20px;"></div>

                    <!-- Messages List -->
                    <div class="flex-grow overflow-y-auto p-4 md:p-6 space-y-4 relative z-0" id="chat-messages" x-ref="messagesContainer">
                        <template x-for="msg in messages" :key="msg.id">
                            <div :class="{'flex justify-end': msg.isAdmin, 'flex justify-start': !msg.isAdmin}">
                                <div class="max-w-[75%] md:max-w-[60%] flex flex-col" :class="{'items-end': msg.isAdmin, 'items-start': !msg.isAdmin}">
                                    <!-- Order Card Reference -->
                                    <template x-if="msg.order">
                                        <div class="mb-1.5 bg-white dark:bg-gray-800 border border-indigo-200 dark:border-indigo-900 rounded-lg p-2.5 shadow-sm text-sm w-full cursor-pointer hover:bg-indigo-50 dark:hover:bg-indigo-900/50 hover:border-indigo-400 transition-colors"
                                             @click="window.location.href = '/admin/orders/' + msg.order.id">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="font-bold text-indigo-700 dark:text-indigo-400" x-text="msg.order.order_number"></span>
                                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 uppercase tracking-wider" x-text="msg.order.status"></span>
                                            </div>
                                            <div class="text-[11px] text-gray-500 dark:text-gray-400 font-medium flex justify-between items-center">
                                                <span>Total Belanja</span>
                                                <span class="text-gray-700 dark:text-gray-300 font-bold">Rp <span x-text="new Intl.NumberFormat('id-ID').format(msg.order.total_price)"></span></span>
                                            </div>
                                        </div>
                                    </template>

                                    <div class="px-4 py-2.5 rounded-2xl shadow-sm text-sm" 
                                         :class="{'bg-indigo-600 text-white rounded-br-sm': msg.isAdmin, 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700 rounded-bl-sm': !msg.isAdmin}">
                                        <p x-text="msg.content" class="whitespace-pre-line break-words"></p>
                                    </div>
                                    <div class="flex items-center gap-1 mt-1 px-1">
                                        <span class="text-[10px] text-gray-500 font-medium" x-text="msg.time"></span>
                                        <template x-if="msg.isAdmin && msg.isRead">
                                            <x-lucide-check-check class="w-3 h-3 text-blue-500" />
                                        </template>
                                        <template x-if="msg.isAdmin && !msg.isRead">
                                            <x-lucide-check class="w-3 h-3 text-gray-400" />
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                        
                        <!-- Empty state -->
                        <div x-show="messages.length === 0" class="h-full flex flex-col items-center justify-center text-gray-500 dark:text-gray-400 space-y-3" style="display: none;">
                            <div class="w-16 h-16 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center shadow-sm border border-gray-200 dark:border-gray-700">
                                <x-lucide-message-circle class="w-8 h-8 text-indigo-300 dark:text-indigo-700" />
                            </div>
                            <p class="text-sm font-medium">Belum ada obrolan dengan pelanggan ini.</p>
                        </div>
                    </div>

                    <!-- Input Area -->
                    <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 relative z-10 transition-colors w-full">
                        <form @submit.prevent="sendMessage" class="flex flex-col gap-2 relative">
                            <!-- Order Select Dropdown -->
                            <div class="w-full mb-1" x-show="showOrderSelect" style="display: none;" x-transition>
                                <select x-model="selectedOrderId" class="w-full text-sm border border-gray-200 dark:border-gray-700 rounded-xl focus:border-indigo-300 dark:focus:border-indigo-600 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-900 focus:ring-opacity-50 text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-900 p-2.5 outline-none font-medium cursor-pointer shadow-sm">
                                    <option value="">-- Pilih Pesanan (Opsional) --</option>
                                    @foreach($orders as $order)
                                        <option value="{{ $order->id }}">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }} - Rp {{ number_format($order->total_price, 0, ',', '.') }} ({{ ucfirst($order->status) }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex gap-2 relative w-full items-center">
                                <button type="button" @click="showOrderSelect = !showOrderSelect" class="p-2.5 text-gray-400 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors focus:outline-none flex-shrink-0" :class="{'text-indigo-600 dark:text-indigo-400 bg-gray-100 dark:bg-gray-700': selectedOrderId}" title="Tautkan Pesanan">
                                    <x-lucide-paperclip class="w-5 h-5" />
                                </button>
                                
                                <input type="text" x-model="newMessage" placeholder="Tulis balasan sebagai Admin..." 
                                    class="w-full bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-full pl-5 pr-12 py-3 border border-transparent focus:border-indigo-300 dark:focus:border-indigo-600 focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-900 transition-all text-sm outline-none shadow-sm flex-grow"
                                    :disabled="sending">
                                
                                <button type="submit" :disabled="!newMessage.trim() || sending" 
                                    class="absolute right-2 top-1.5 bottom-1.5 aspect-square rounded-full bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-400 disabled:dark:bg-gray-700 disabled:cursor-not-allowed text-white flex items-center justify-center transition-colors shadow-sm">
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
        function adminChatComponent() {
            return {
                messages: [],
                newMessage: '',
                sending: false,
                selectedOrderId: '',
                showOrderSelect: false,
                customerId: {{ $customer->id }},
                
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
                        const response = await fetch('{{ route('admin.chats.messages', $customer) }}');
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
                        await fetch('{{ route('admin.chats.store', $customer) }}', {
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
</x-admin-layout>
