<!-- Simple Chat Widget Test -->
<div x-data="{ isOpen: false }" class="fixed bottom-4 right-4 z-50">
    <!-- Chat Button -->
    <button @click="isOpen = !isOpen"
        class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg transition-all duration-300">
        <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
        <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Chat Window -->
    <div x-show="isOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
        class="fixed bottom-20 right-4 w-96 bg-white rounded-lg shadow-xl border border-gray-200">

        <!-- Chat Header -->
        <div class="bg-blue-600 text-white px-4 py-3 rounded-t-lg">
            <h3 class="font-semibold">Chat Widget Test</h3>
        </div>

        <!-- Chat Content -->
        <div class="p-4">
            <p class="text-gray-600">Widget berfungsi dengan baik! 🎉</p>
        </div>
    </div>
</div>
