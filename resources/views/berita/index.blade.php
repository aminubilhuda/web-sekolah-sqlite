@extends('layouts.app')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
        }
        
        .news-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .breaking-news {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { background-color: #dc2626; }
            50% { background-color: #ef4444; }
            100% { background-color: #dc2626; }
        }
        
        .category-tag {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 10;
        }
        
        .trending-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        
        .hero-gradient {
            background: linear-gradient(to right, rgba(0,0,0,0.8), rgba(0,0,0,0.2));
        }
    </style>
@endpush

@section('content')
    <!-- Breaking News -->
    @if($beritas->where('headline', 'Yes')->first())
    <div class="bg-blue-500 py-3 text-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center">
                <span class="bg-red-500 text-white px-3 py-1 rounded mr-4 font-bold">HEADLINE</span>
                <div class="overflow-hidden w-full">
                    <marquee behavior="scroll" direction="left" scrollamount="5" class="w-full">
                        <span class="mr-8">🔥 {{ $beritas->where('headline', 'Yes')->first()->judul }}</span>
                    </marquee>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Berita Utama -->
            <div class="w-full lg:w-8/12">
                <h2 class="text-2xl font-bold mb-6 pb-2 border-b-2 border-primary inline-block">Berita Terbaru</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($beritas->where('headline', 'No')->take(4) as $berita)
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="relative">
                            @if($berita->gambar)
                                <img src="{{ asset('storage/' . $berita->gambar) }}" 
                                     alt="{{ $berita->judul }}"
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                                    <i data-lucide="newspaper" class="w-12 h-12 text-gray-400"></i>
                                </div>
                            @endif
                            <span class="absolute top-4 left-4 bg-primary text-white px-3 py-1 rounded-full text-xs font-medium">
                                {{ $berita->kategori }}
                            </span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-lg mb-2">{{ $berita->judul }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit(strip_tags($berita->isi), 150) }}</p>
                            <div class="flex justify-between items-center text-xs text-gray-500">
                                <span>{{ \Carbon\Carbon::parse($berita->tanggal_publish)->diffForHumans() }}</span>
                                <a href="{{ route('berita.show', $berita->slug) }}" class="text-blue-600 hover:text-blue-700">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Headline Berita -->
                @if($beritas->where('headline', 'Yes')->first())
                <div class="mt-10">
                    <h2 class="text-2xl font-bold mb-6 pb-2 border-b-2 border-primary inline-block">Headline</h2>
                    
                    <div class="bg-white rounded-xl overflow-hidden shadow-md">
                        <div class="md:flex">
                            <div class="md:w-5/12">
                                @if($beritas->where('headline', 'Yes')->first()->gambar)
                                    <img src="{{ asset('storage/' . $beritas->where('headline', 'Yes')->first()->gambar) }}" 
                                         alt="{{ $beritas->where('headline', 'Yes')->first()->judul }}"
                                         class="w-full h-64 object-cover">
                                @else
                                    <div class="w-full h-64 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                                        <i data-lucide="newspaper" class="w-12 h-12 text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="md:w-7/12 p-6">
                                <span class="bg-primary text-white px-3 py-1 rounded-full text-xs font-medium">
                                    {{ $beritas->where('headline', 'Yes')->first()->kategori }}
                                </span>
                                <h3 class="font-bold text-2xl mt-3 mb-3">
                                    {{ $beritas->where('headline', 'Yes')->first()->judul }}
                                </h3>
                                <p class="text-gray-600 mb-4">
                                    {{ Str::limit(strip_tags($beritas->where('headline', 'Yes')->first()->isi), 200) }}
                                </p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                                    <span>{{ $beritas->where('headline', 'Yes')->first()->penulis }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ \Carbon\Carbon::parse($beritas->where('headline', 'Yes')->first()->tanggal_publish)->diffForHumans() }}</span>
                                </div>
                                <a href="{{ route('berita.show', $beritas->where('headline', 'Yes')->first()->slug) }}"
                                    class="inline-flex items-center space-x-2 text-blue-600 hover:text-blue-700 font-medium mt-4 transition-colors">
                                    <span>Baca Selengkapnya</span>
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="w-full lg:w-4/12">
                <!-- Kategori -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <h3 class="font-bold text-lg mb-4 pb-2 border-b">Kategori Berita</h3>
                    <ul>
                        @php
                            $kategoris = $beritas->pluck('kategori')->unique();
                        @endphp
                        @foreach($kategoris as $kategori)
                        <li class="py-2 border-b">
                            <a href="#" class="flex justify-between items-center text-gray-700 hover:text-primary transition">
                                <span>{{ $kategori }}</span>
                                <span class="bg-gray-200 text-gray-700 rounded-full px-2 py-1 text-xs">
                                    {{ $beritas->where('kategori', $kategori)->count() }}
                                </span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                <!-- Berita Populer -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="font-bold text-lg mb-4 pb-2 border-b">Berita Populer</h3>
                    
                    <div class="space-y-4">
                        @foreach($beritas->take(4) as $berita)
                        <div class="flex">
                            <div class="flex-shrink-0 mr-4">
                                @if($berita->gambar)
                                    <img src="{{ asset('storage/' . $berita->gambar) }}" 
                                         alt="{{ $berita->judul }}"
                                         class="w-16 h-16 object-cover rounded-xl">
                                @else
                                    <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-purple-100 rounded-xl flex items-center justify-center">
                                        <i data-lucide="newspaper" class="w-8 h-8 text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('berita.show', $berita->slug) }}" class="font-semibold text-gray-800 hover:text-primary transition">
                                    {{ Str::limit($berita->judul, 50) }}
                                </a>
                                <div class="flex items-center text-xs text-gray-500 mt-1">
                                    <span>{{ $berita->kategori }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ \Carbon\Carbon::parse($berita->tanggal_publish)->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Newsletter -->
                <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-xl shadow-md p-6 mt-8">
                    <h3 class="font-bold text-lg text-white mb-3">Berlangganan Newsletter</h3>
                    <p class="text-red-100 mb-4">Dapatkan update berita terbaru langsung ke email Anda</p>
                    <form>
                        <div class="mb-3">
                            <input type="email" placeholder="Email Anda" class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400 bg-white">
                        </div>
                        <button type="submit" class="w-full bg-white text-red-600 font-medium py-3 rounded-lg hover:bg-red-50 transition">Langganan Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

@push('scripts')
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#1a56db',
                    secondary: '#1e429f',
                    dark: '#1f2937',
                    accent: '#dc2626',
                }
            }
        }
    }
</script>
@endpush
@endsection 