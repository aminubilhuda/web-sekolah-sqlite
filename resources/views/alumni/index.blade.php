@extends('layouts.app')

@section('content')
    <main class="flex-grow py-16">
        <div class="container mx-auto px-4">
            <!-- Filter Section -->
            <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button class="filter-btn px-5 py-2.5 bg-white rounded-full shadow-md font-medium gradient-button text-white" data-status="all">
                    Semua Alumni
                </button>
                <button class="filter-btn px-5 py-2.5 bg-white rounded-full shadow-md font-medium hover:bg-primary hover:text-white transition" data-status="bekerja">
                    Alumni Bekerja
                </button>
                <button class="filter-btn px-5 py-2.5 bg-white rounded-full shadow-md font-medium hover:bg-primary hover:text-white transition" data-status="kuliah">
                    Alumni Kuliah
                </button>
                <button class="filter-btn px-5 py-2.5 bg-white rounded-full shadow-md font-medium hover:bg-primary hover:text-white transition" data-status="wirausaha">
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($alumni as $alum)
                <div class="testimonial-card bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" data-id="{{ $alum->id }}" data-testimoni="{{ strip_tags($alum->testimoni) }}">
                    <div class="relative">
                        <div class="h-40 bg-gradient-to-r from-primary to-blue-600 rounded-t-3xl"></div>
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
                                <h3 class="font-bold text-xl">{{ $alum->nama }}</h3>
                                <p class="text-primary font-medium">
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
                                <i class="fas fa-quote-left text-primary opacity-20 absolute left-0 top-0 text-3xl"></i>
                                <div class="testimonial-preview">
                                    Assalamualaikum Warahmatullahi Wabarakatuh, salam sejahtera untuk kita semua.
                                    <br><br>
                                    {{ Str::limit(strip_tags($alum->testimoni), 150) }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="tag px-3 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full">Angkatan {{ $alum->tahun_lulus }}</span>
                            <span class="tag px-3 py-1 bg-emerald-100 text-emerald-800 text-xs rounded-full">{{ $alum->jurusan->nama_jurusan }}</span>
                        </div>
                        
                        <button class="w-full gradient-button text-white py-3 rounded-xl font-medium flex items-center justify-center gap-2 hover:opacity-90 transition-opacity" onclick="showFullStory({{ $alum->id }})">
                            <i class="far fa-comment-dots"></i> Lihat Selengkapnya
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Load More Button -->
            <div class="text-center mt-16">
                <button class="gradient-button text-white px-8 py-4 rounded-full text-lg font-medium inline-flex items-center gap-3 hover:opacity-90 transition-opacity">
                    <i class="fas fa-rotate"></i> Muat Lebih Banyak
                </button>
            </div>
        </div>
    </main>
    
    <!-- Modal Full Story -->
    <div id="fullStoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-3xl max-w-2xl w-full mx-4 overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-2xl font-bold" id="modalTitle"></h3>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="prose max-w-none" id="modalContent">
                    <div class="text-gray-600">
                        <div class="mb-4">
                            <p class="font-medium">Assalamualaikum Warahmatullahi Wabarakatuh, salam sejahtera untuk kita semua.</p>
                        </div>
                        <div id="modalTestimoni" class="whitespace-pre-line"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .gradient-button {
        background: linear-gradient(135deg, #4F46E5 0%, #2563EB 100%);
    }

    .testimonial-card {
        transition: all 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
    }

    .testimonial-preview {
        white-space: pre-line;
    }

    @keyframes cardStagger {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-stagger {
        animation: cardStagger 0.5s ease forwards;
    }

    @media (max-width: 768px) {
        .testimonial-card {
            margin: 0 1rem;
        }
    }

    .modal-content {
        max-height: 70vh;
        overflow-y: auto;
    }

    .modal-content::-webkit-scrollbar {
        width: 8px;
    }

    .modal-content::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .modal-content::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .modal-content::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #4F46E5 0%, #2563EB 100%);
        color: white;
    }
    </style>

    <script>
    function showFullStory(id) {
        const modal = document.getElementById('fullStoryModal');
        const title = document.getElementById('modalTitle');
        const testimoni = document.getElementById('modalTestimoni');
        const card = document.querySelector(`[data-id="${id}"]`);
        
        // Set judul modal
        title.textContent = 'Testimoni Alumni: ' + card.querySelector('.font-bold').textContent;
        
        // Ambil testimoni lengkap dari data attribute
        const fullTestimoni = card.getAttribute('data-testimoni');
        testimoni.textContent = fullTestimoni;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('fullStoryModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    </script>
@endsection
