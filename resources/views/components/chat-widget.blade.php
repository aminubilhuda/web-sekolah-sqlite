<!-- Chat Widget -->
<div x-data="{ 
    isOpen: false,
    messages: [],
    newMessage: '',
    sessionId: '{{ Str::random(32) }}',
    isLoading: false,
    
    init() {
        this.loadChatHistory();
    },
    
    async loadChatHistory() {
        try {
            const response = await fetch(`/chat/history?session_id=${this.sessionId}`);
            const data = await response.json();
            this.messages = data;
        } catch (error) {
            console.error('Error loading chat history:', error);
        }
    },
    
    async sendMessage() {
        if (!this.newMessage.trim()) return;
        
        this.isLoading = true;
        const userMessage = this.newMessage;
        this.newMessage = '';
        
        // Add user message to chat
        this.messages.push({
            message: userMessage,
            is_from_user: true,
            created_at: new Date().toISOString()
        });
        
        try {
            const response = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    message: userMessage,
                    session_id: this.sessionId
                })
            });
            
            const data = await response.json();
            
            if (data.error) {
                throw new Error(data.error);
            }
            
            // Add AI response to chat
            this.messages.push({
                message: data.message,
                is_from_user: false,
                created_at: new Date().toISOString()
            });
        } catch (error) {
            console.error('Error sending message:', error);
            // Add error message to chat
            this.messages.push({
                message: 'Maaf, terjadi kesalahan. Silakan coba lagi nanti.',
                is_from_user: false,
                created_at: new Date().toISOString()
            });
        } finally {
            this.isLoading = false;
        }
    }
}" class="fixed bottom-4 right-4 z-50">
    <!-- Chat Button -->
    <button @click="isOpen = !isOpen" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
        <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Chat Window -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="fixed bottom-20 right-4 w-96 bg-white rounded-lg shadow-xl border border-gray-200">
        
        <!-- Chat Header -->
        <div class="bg-blue-600 text-white px-4 py-3 rounded-t-lg flex justify-between items-center">
            <h3 class="font-semibold">Chat dengan AI Asisten</h3>
            <button @click="isOpen = false" class="text-white hover:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Chat Messages -->
        <div class="h-96 overflow-y-auto p-4 space-y-4" x-ref="chatContainer">
            <template x-for="(message, index) in messages" :key="index">
                <div :class="{'flex items-start': true, 'justify-end': message.is_from_user}">
                    <div :class="{'flex-shrink-0': true, 'order-2': message.is_from_user}">
                        <div :class="{'h-8 w-8 rounded-full flex items-center justify-center': true, 'bg-blue-600 text-white': !message.is_from_user, 'bg-gray-200 text-gray-600': message.is_from_user}">
                            <template x-if="!message.is_from_user">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </template>
                            <template x-if="message.is_from_user">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </template>
                        </div>
                    </div>
                    <div :class="{'ml-3': !message.is_from_user, 'mr-3': message.is_from_user, 'bg-gray-100': !message.is_from_user, 'bg-blue-600 text-white': message.is_from_user, 'rounded-lg px-4 py-2': true}">
                        <p class="text-sm" x-text="message.message"></p>
                        <p class="text-xs mt-1 opacity-75" x-text="new Date(message.created_at).toLocaleTimeString()"></p>
                    </div>
                </div>
            </template>
            
            <!-- Loading Indicator -->
            <div x-show="isLoading" class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                </div>
                <div class="ml-3 bg-gray-100 rounded-lg px-4 py-2">
                    <p class="text-sm text-gray-800">Mengetik...</p>
                </div>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="border-t border-gray-200 p-4">
            <form @submit.prevent="sendMessage" class="flex space-x-2">
                <input type="text" 
                       x-model="newMessage"
                       placeholder="Ketik pesan..." 
                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       :disabled="isLoading">
                <button type="submit" 
                        class="bg-blue-600 text-white rounded-lg px-4 py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="isLoading || !newMessage.trim()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div> 