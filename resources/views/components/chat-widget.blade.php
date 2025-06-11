<!-- Chat Widget -->
<div x-data="{
    isOpen: false,
    messages: [],
    newMessage: '',
    sessionId: '{{ Str::random(32) }}',
    isLoading: false,
    touchStartY: null,

    init() {
        this.loadChatHistory();

        // Watch for isOpen changes to auto scroll when chat opens
        this.$watch('isOpen', (value) => {
            if (value) {
                this.$nextTick(() => {
                    this.scrollToBottom();
                    // Auto focus on input when chat opens
                    if (this.$refs.messageInput) {
                        this.$refs.messageInput.focus();
                    }
                });
            }
        });

        // Handle viewport changes for mobile keyboards
        if (window.visualViewport) {
            window.visualViewport.addEventListener('resize', () => {
                if (this.isOpen) {
                    this.$nextTick(() => {
                        this.scrollToBottom();
                    });
                }
            });
        }
    },

    async loadChatHistory() {
        try {
            const response = await fetch(`/chat/history?session_id=${this.sessionId}`);
            const data = await response.json();
            this.messages = data;

            // Auto scroll to bottom after loading history
            this.$nextTick(() => {
                this.scrollToBottom();
                // Auto focus on input if chat is open
                if (this.isOpen && this.$refs.messageInput) {
                    this.$refs.messageInput.focus();
                }
            });
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

        // Auto scroll after adding user message
        this.$nextTick(() => {
            this.scrollToBottom();
        });

        // Small delay to show loading indicator, then scroll
        setTimeout(() => {
            this.scrollToBottom();
        }, 100);

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

            // Auto scroll after AI response
            this.$nextTick(() => {
                this.scrollToBottom();
                // Auto focus back to input after AI response
                if (this.$refs.messageInput) {
                    this.$refs.messageInput.focus();
                }
            });
        } catch (error) {
            console.error('Error sending message:', error);
            // Add error message to chat
            this.messages.push({
                message: 'Maaf, terjadi kesalahan. Silakan coba lagi nanti.',
                is_from_user: false,
                created_at: new Date().toISOString()
            });

            // Auto scroll after error message
            this.$nextTick(() => {
                this.scrollToBottom();
                // Auto focus back to input after error
                if (this.$refs.messageInput) {
                    this.$refs.messageInput.focus();
                }
            });
        } finally {
            this.isLoading = false;
        }
    },

    scrollToBottom() {
        if (this.$refs.chatContainer) {
            // Smooth scroll to bottom
            this.$refs.chatContainer.scrollTo({
                top: this.$refs.chatContainer.scrollHeight,
                behavior: 'smooth'
            });
        }
    },

    // Handle touch events for better mobile experience
    handleTouchStart(event) {
        this.touchStartY = event.touches[0].clientY;
    },

    handleTouchMove(event) {
        if (this.touchStartY) {
            const touchY = event.touches[0].clientY;
            const deltaY = this.touchStartY - touchY;

            // Prevent rubber band effect on iOS
            if (this.$refs.chatContainer) {
                const container = this.$refs.chatContainer;
                const atTop = container.scrollTop === 0;
                const atBottom = container.scrollHeight - container.clientHeight <= container.scrollTop + 1;

                if ((atTop && deltaY < 0) || (atBottom && deltaY > 0)) {
                    event.preventDefault();
                }
            }
        }
    }
}" class="fixed bottom-4 right-4 z-50">
    <!-- Chat Button -->
    <button @click="isOpen = !isOpen"
        class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-3 md:p-4 shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 touch-manipulation">
        <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
        <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Chat Window -->
    <div x-show="isOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="fixed bottom-20 right-2 md:right-4 w-[calc(100vw-1rem)] md:w-[420px] bg-white rounded-xl md:rounded-lg shadow-xl border border-gray-200 max-h-[calc(100vh-7rem)] md:max-h-none md:h-[520px] flex flex-col mobile-chat-window">

        <!-- Chat Header -->
        <div
            class="bg-blue-600 text-white px-3 md:px-4 py-2 md:py-3 rounded-t-xl md:rounded-t-lg flex justify-between items-center flex-shrink-0">
            <h3 class="font-semibold text-sm md:text-lg">Chat dengan AI Asisten</h3>
            <button @click="isOpen = false" class="text-white hover:text-gray-200 p-1 touch-manipulation">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Chat Messages -->
        <div class="flex-1 md:flex-none overflow-y-auto p-3 md:p-4 space-y-3 md:space-y-4 scroll-smooth min-h-0 md:h-[420px] chat-container chat-scrollbar"
            x-ref="chatContainer" @touchstart="handleTouchStart($event)" @touchmove="handleTouchMove($event)">

            <!-- Welcome Message - Only show when no messages -->
            <div x-show="messages.length === 0 && !isLoading"
                class="flex flex-col items-center justify-center h-full text-center py-8">
                <div class="bg-blue-100 rounded-full p-4 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 md:h-10 md:w-10 text-blue-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <h4 class="text-sm md:text-lg font-semibold text-gray-700 mb-2">Halo! 👋</h4>
                <p class="text-xs md:text-sm text-gray-500 px-4">
                    Saya adalah AI Asisten sekolah. Silakan tanyakan tentang informasi sekolah, jurusan, fasilitas, atau
                    hal lainnya!
                </p>
            </div>

            <template x-for="(message, index) in messages" :key="index">
                <div :class="{ 'flex items-start': true, 'justify-end': message.is_from_user }">
                    <div :class="{ 'flex-shrink-0': true, 'order-2': message.is_from_user }">
                        <div
                            :class="{
                                'h-6 w-6 md:h-8 md:w-8 rounded-full flex items-center justify-center': true,
                                'bg-blue-600 text-white': !
                                    message.is_from_user,
                                'bg-gray-200 text-gray-600': message.is_from_user
                            }">
                            <template x-if="!message.is_from_user">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-5 md:w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </template>
                            <template x-if="message.is_from_user">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-5 md:w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </template>
                        </div>
                    </div>
                    <div
                        :class="{
                            'ml-2 md:ml-3': !message.is_from_user,
                            'mr-2 md:mr-3': message.is_from_user,
                            'bg-gray-100': !message
                                .is_from_user,
                            'bg-blue-600 text-white': message
                                .is_from_user,
                            'rounded-lg px-3 py-2 md:px-4 md:py-2 max-w-[280px] md:max-w-[320px]': true
                        }">
                        <p class="text-sm md:text-base leading-relaxed break-words" x-text="message.message"></p>
                        <p class="text-xs md:text-sm mt-1 opacity-75"
                            x-text="new Date(message.created_at).toLocaleTimeString()">
                        </p>
                    </div>
                </div>
            </template>

            <!-- Loading Indicator -->
            <div x-show="isLoading" class="flex items-start">
                <div class="flex-shrink-0">
                    <div
                        class="h-6 w-6 md:h-8 md:w-8 rounded-full bg-blue-600 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-5 md:w-5 animate-spin"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                </div>
                <div class="ml-2 md:ml-3 bg-gray-100 rounded-lg px-3 py-2 md:px-4 md:py-2">
                    <p class="text-sm text-gray-800">Mengetik...</p>
                </div>
            </div>
        </div>

        <!-- Chat Input -->
        <div
            class="border-t border-gray-200 p-4 md:p-4 bg-white rounded-b-xl md:rounded-b-lg flex-shrink-0 chat-widget-mobile">
            <form @submit.prevent="sendMessage" class="flex space-x-3">
                <input type="text" x-model="newMessage" x-ref="messageInput" placeholder="Ketik pesan..."
                    class="flex-1 border border-gray-300 rounded-lg px-3 py-2.5 md:px-4 md:py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none touch-manipulation"
                    :disabled="isLoading" @keydown.enter="sendMessage" autocomplete="off" autocorrect="off"
                    autocapitalize="off" spellcheck="false">
                <button type="submit"
                    class="bg-blue-600 text-white rounded-lg px-3 py-2.5 md:px-4 md:py-3 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200 touch-manipulation flex-shrink-0"
                    :disabled="isLoading || !newMessage.trim()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
