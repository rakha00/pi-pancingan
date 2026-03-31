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
                            <span class="ml-1 text-gray-700 dark:text-gray-200 md:ml-2">Live Chat Pusat</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                Kotak Masuk Chat
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden text-gray-900 dark:text-gray-100 transition-colors">
                
                <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    @forelse($customers as $customer)
                        @php
                            $latestMsg = $customer->messages()->latest()->first();
                        @endphp
                        <a href="{{ route('admin.chats.show', $customer) }}" class="flex items-center p-5 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                            <div class="relative shrink-0 mr-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                                @if($customer->unread_count > 0)
                                    <div class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full border-2 border-white dark:border-gray-800 flex items-center justify-center text-[10px] text-white font-bold">
                                        {{ $customer->unread_count }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow min-w-0">
                                <div class="flex justify-between items-center mb-1">
                                    <h4 class="font-bold text-gray-900 dark:text-gray-100 truncate pr-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $customer->name }}</h4>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 shrink-0">{{ $latestMsg->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm truncate {{ $customer->unread_count > 0 ? 'text-gray-800 dark:text-gray-200 font-bold' : 'text-gray-500 dark:text-gray-400' }}">
                                    @if($latestMsg->sender_id !== $customer->id) 
                                        <span class="text-indigo-500 dark:text-indigo-400 text-xs mr-1"><x-lucide-reply class="w-3 h-3 inline" /> Anda: </span> 
                                    @endif
                                    {{ $latestMsg->content }}
                                </p>
                            </div>
                        </a>
                    @empty
                        <div class="p-12 text-center flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-50 dark:bg-gray-900/50 rounded-full flex items-center justify-center mb-4 border border-gray-100 dark:border-gray-700">
                                <x-lucide-message-square class="w-8 h-8 text-gray-400 dark:text-gray-500" />
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Kotak Masuk Kosong</h3>
                            <p class="text-gray-500 dark:text-gray-400 mt-1">Belum ada pelanggan yang memulai percakapan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
