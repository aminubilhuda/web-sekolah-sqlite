@extends('layouts.app')

@section('content')
    <main class="flex-grow py-16">
        <div class="container mx-auto px-4">
            <!-- Filter Section -->
            <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button class="filter-btn px-5 py-2.5 bg-white rounded-full shadow-md font-medium transition-all duration-300" data-status="all">
                    Semua Alumni
                </button>
                <button class="filter-btn px-5 py-2.5 bg-white rounded-full shadow-md font-medium transition-all duration-300" data-status="bekerja">
                    Alumni Bekerja
                </button>
                <button class="filter-btn px-5 py-2.5 bg-white rounded-full shadow-md font-medium transition-all duration-300" data-status="kuliah">
                    Alumni Kuliah
                </button>
                <button class="filter-btn px-5 py-2.5 bg-white rounded-full shadow-md font-medium transition-all duration-300" data-status="wirausaha">
                    Alumni Wirausaha
                </button>
            </div>
            
            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
                <div class="bg-white p-6 rounded-2xl shadow-md text-center">
                    <div class="text-3xl font-bold text-primary mb-2">{{ $alumni->count() }}</div>
                    <div class="text-gray-600">Total Alumni</div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-md text-center">
                    <div class="text-3xl font-bold text-secondary mb-2">{{ $alumni->where('status', 'bekerja')->count() }}</div>
                    <div class="text-gray-600">Alumni Bekerja</div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-md text-center">
                    <div class="text-3xl font-bold text-primary mb-2">{{ $alumni->where('status', 'kuliah')->count() }}</div>
                    <div class="text-gray-600">Alumni Kuliah</div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-md text-center">
                    <div class="text-3xl font-bold text-secondary mb-2">{{ $alumni->where('status', 'wirausaha')->count() }}</div>
                    <div class="text-gray-600">Alumni Wirausaha</div>
                </div>
            </div>
            
            <!-- Alumni Grid -->
            <div id="alumni-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($alumni as $alum)
                <div class="testimonial-card bg-white rounded-3xl shadow-lg overflow-hidden transition-all duration-300 transform hover:-translate-y-1" 
                     data-id="{{ $alum->id }}" 
                     data-status="{{ $alum->status }}"
                     data-testimoni="{{ strip_tags($alum->testimoni) }}">
                    <div class="relative">
                        <div class="h-40 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-t-3xl"></div>
                        <div class="absolute -bottom-12 left-6">
                            <div class="alumni-image bg-white p-1 rounded-full shadow-lg">
                                @if($alum->foto)
                                    <img src="{{ asset('storage/' . $alum->foto) }}" alt="{{ $alum->nama }}" class="w-24 h-24 rounded-full object-cover">
                                @else
                                    <img src="{{ asset('images/default-avatar.png') }}" alt="{{ $alum->nama }}" class="w-24 h-24 rounded-full object-cover">
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-14 px-6 pb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-bold text-xl text-gray-900">{{ $alum->nama }}</h3>
                                <p class="text-blue-600 font-medium">
                                    @if($alum->status == 'bekerja')
                                        {{ $alum->pekerjaan }}
                                    @elseif($alum->status == 'kuliah')
                                        {{ $alum->perguruan_tinggi }}
                                    @else
                                        Wirausaha
                                    @endif
                                </p>
                            </div>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        
                        <div class="mb-5">
                            <div class="text-gray-600 italic relative pl-8">
                                <i class="fas fa-quote-left text-blue-500 opacity-20 absolute left-0 top-0 text-3xl"></i>
                                <div class="testimonial-preview">
                                    {{ Str::limit(strip_tags($alum->testimoni), 150) }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="tag px-3 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full font-medium">Angkatan {{ $alum->tahun_lulus }}</span>
                            <span class="tag px-3 py-1 bg-emerald-100 text-emerald-800 text-xs rounded-full font-medium">{{ $alum->jurusan->nama_jurusan }}</span>
                        </div>
                        
                        <button class="w-full gradient-button text-white py-3 rounded-xl font-medium flex items-center justify-center gap-2 hover:opacity-90 transition-opacity" onclick="showFullStory({{ $alum->id }})">
                            <i class="far fa-comment-dots"></i> Lihat Selengkapnya
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <div id="no-alumni-message" class="text-center py-16 hidden">
                <i class="fas fa-search text-5xl text-gray-300 mb-4"></i>
                <p class="text-xl text-gray-500">Tidak ada alumni yang cocok dengan filter ini.</p>
            </div>
            
            <!-- Load More Button -->
            <div class="text-center mt-16">
                <button id="load-more-btn" class="gradient-button text-white px-8 py-4 rounded-full text-lg font-medium inline-flex items-center gap-3 hover:opacity-90 transition-opacity">
                    <i class="fas fa-rotate"></i> Muat Lebih Banyak
                </button>
            </div>
        </div>
    </main>
    
    <!-- Modal Full Story -->
    <div id="fullStoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full mx-4 overflow-hidden transform transition-all duration-300" id="modal-content-wrapper">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-2xl font-bold text-gray-900" id="modalTitle"></h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-700 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="prose max-w-none modal-content" id="modalContent">
                    <div id="modalTestimoni" class="text-gray-700 leading-relaxed"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .gradient-button, .filter-btn.active {
        background: linear-gradient(135deg, #4F46E5 0%, #2563EB 100%);
        color: white;
    }

    .testimonial-card {
        opacity: 0;
        transform: translateY(20px);
        animation: cardFadeIn 0.5s ease forwards;
    }

    @keyframes cardFadeIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .testimonial-card.hidden {
        display: none;
    }

    .modal-content {
        max-height: 70vh;
        overflow-y: auto;
        padding-right: 1rem; /* for scrollbar */
    }

    .modal-content::-webkit-scrollbar {
        width: 8px;
    }

    .modal-content::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .modal-content::-webkit-scrollbar-thumb {
        background: #a5b4fc;
        border-radius: 4px;
    }

    .modal-content::-webkit-scrollbar-thumb:hover {
        background: #818cf8;
    }

    #fullStoryModal.flex {
        animation: modalFadeIn 0.3s ease;
    }
    #fullStoryModal.hidden #modal-content-wrapper {
        animation: modalFadeOut 0.3s ease forwards;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes modalFadeOut {
        from { opacity: 1; transform: scale(1); }
        to { opacity: 0; transform: scale(0.95); }
    }
    </style>

    <script>
    function showFullStory(id) {
        const modal = document.getElementById('fullStoryModal');
        const title = document.getElementById('modalTitle');
        const testimoni = document.getElementById('modalTestimoni');
        const card = document.querySelector(`[data-id="${id}"]`);
        
        title.textContent = 'Testimoni dari ' + card.querySelector('h3').textContent;
        
        const fullTestimoni = card.getAttribute('data-testimoni');
        testimoni.innerHTML = fullTestimoni.replace(/\n/g, '<br>');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('fullStoryModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const alumniGrid = document.getElementById('alumni-grid');
        const allCards = Array.from(alumniGrid.children);
        const noResultsMessage = document.getElementById('no-alumni-message');
        const loadMoreBtn = document.getElementById('load-more-btn');

        let currentFilter = 'all';
        const itemsPerPage = 6;

        function applyFilterAndPagination() {
            let visibleCount = 0;
            const filteredCards = [];

            // Hide all cards and check which ones match the filter
            allCards.forEach(card => {
                const cardStatus = card.dataset.status;
                if (currentFilter === 'all' || currentFilter === cardStatus) {
                    filteredCards.push(card);
                } else {
                    card.classList.add('hidden');
                }
            });

            // Show only the items for the current page
            filteredCards.forEach((card, index) => {
                if (index < itemsPerPage) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Update UI based on filtered results
            if (filteredCards.length === 0) {
                noResultsMessage.classList.remove('hidden');
            } else {
                noResultsMessage.classList.add('hidden');
            }

            if (filteredCards.length > itemsPerPage) {
                loadMoreBtn.classList.remove('hidden');
            } else {
                loadMoreBtn.classList.add('hidden');
            }
        }

        function loadMoreItems() {
            const hiddenCards = Array.from(alumniGrid.querySelectorAll('.testimonial-card.hidden[data-status="' + (currentFilter === 'all' ? '' : currentFilter) + '"]'));
            if (currentFilter === 'all') {
                 const allHiddenCards = Array.from(alumniGrid.querySelectorAll('.testimonial-card.hidden'));
                 for (let i = 0; i < itemsPerPage && i < allHiddenCards.length; i++) {
                    allHiddenCards[i].classList.remove('hidden');
                }
                if (allHiddenCards.length <= itemsPerPage) {
                    loadMoreBtn.classList.add('hidden');
                }
            } else {
                const filteredHiddenCards = allCards.filter(card => card.dataset.status === currentFilter && card.classList.contains('hidden'));
                for (let i = 0; i < itemsPerPage && i < filteredHiddenCards.length; i++) {
                    filteredHiddenCards[i].classList.remove('hidden');
                }
                if (filteredHiddenCards.length <= itemsPerPage) {
                    loadMoreBtn.classList.add('hidden');
                }
            }
        }

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('active', 'gradient-button', 'text-white'));
                button.classList.add('active', 'gradient-button', 'text-white');
                currentFilter = button.dataset.status;
                applyFilterAndPagination();
            });
        });

        loadMoreBtn.addEventListener('click', loadMoreItems);

        // Initial setup
        filterButtons[0].click(); // Simulate a click on the 'All' button to initialize
    });
    </script>
@endsection
