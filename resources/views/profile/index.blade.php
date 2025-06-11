@extends('layouts.app')

@push('styles')
 <style>
        .hero-pattern {
            background: linear-gradient(to right, rgba(7, 89, 133, 0.9), rgba(14, 165, 233, 0.7)), 
                         url('{{ $sekolah->logo_sekolah ? asset("storage/" . $sekolah->logo_sekolah) : asset("images/default-school.jpg") }}');
            background-size: cover;
            background-position: center;
        }
        
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 2px;
            height: 100%;
            background-color: #0ea5e9;
        }
        
        .achievement-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: #f97316;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
        
        .stats-card {
            border-left: 4px solid #0ea5e9;
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-pattern bg-linear-to-r/hsl from-indigo-500 to-teal-400text-white py-16 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-4">Profil {{ $sekolah->nama_sekolah ?? 'Sekolah' }}</h1>
            <p class="text-lg md:text-xl max-w-3xl mx-auto mb-8">
                {{ $sekolah->motto ?? 'Motto Sekolah' }}
            </p>
            <div class="flex justify-center">
                <div class="bg-white text-gray-800 rounded-lg py-2 px-6 inline-flex items-center">
                    <i class="fas fa-award text-accent mr-2"></i>
                    <span>Akreditasi {{ $sekolah->akreditasi ?? 'Belum Tersedia' }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- About School -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-12">
                <div class="md:w-1/2">
                    <div class="rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ $sekolah->logo_sekolah ? asset('storage/' . $sekolah->logo_sekolah) : asset('images/default-school.jpg') }}" 
                             alt="{{ $sekolah->nama_sekolah ?? 'Sekolah' }}" class="w-full h-96 object-cover">
                    </div>
                </div>
                
                <div class="md:w-1/2">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Tentang {{ $sekolah->nama_sekolah ?? 'Sekolah' }}</h2>
                    <div class="prose prose-lg max-w-none text-gray-600 mb-6">
                        {!! $sekolah->sejarah ?? 'Sejarah sekolah belum tersedia' !!}
                    </div>
                    <div class="prose prose-lg max-w-none text-gray-600 mb-8">
                        {!! $sekolah->sambutan_kepala_sekolah ?? 'Sambutan kepala sekolah belum tersedia' !!}
                    </div>
                    
                    <div class="flex flex-wrap gap-4">
                        <div class="bg-blue-50 rounded-lg p-4 flex items-center">
                            <i class="fas fa-graduation-cap text-primary text-2xl mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Akreditasi</p>
                                <p class="font-bold">{{ $sekolah->akreditasi ?? 'Belum Tersedia' }}</p>
                            </div>
                        </div>
                        
                        <div class="bg-orange-50 rounded-lg p-4 flex items-center">
                            <i class="fas fa-calendar text-accent text-2xl mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Tahun Berdiri</p>
                                <p class="font-bold">{{ $sekolah->tahun_berdiri ?? 'Belum Tersedia' }}</p>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 rounded-lg p-4 flex items-center">
                            <i class="fas fa-map-marker-alt text-green-500 text-2xl mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Lokasi</p>
                                <p class="font-bold">{{ $sekolah->kabupaten_kota ?? 'Belum Tersedia' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Visi & Misi</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Pedoman kami dalam membangun pendidikan berkualitas
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-12">
                <div class="bg-white rounded-xl shadow-lg p-8 relative overflow-hidden card-hover">
                    <div class="absolute -top-8 -right-8 w-24 h-24 bg-primary rounded-full opacity-10"></div>
                    <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-accent rounded-full opacity-10"></div>
                    
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-eye mr-3 text-primary"></i>
                        Visi Sekolah
                    </h3>
                    <div class="text-lg font-medium text-gray-700 mb-6 prose prose-lg max-w-none">
                        {!! $sekolah->visi ?? 'Visi sekolah belum tersedia' !!}
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8 relative overflow-hidden card-hover">
                    <div class="absolute -top-8 -right-8 w-24 h-24 bg-primary rounded-full opacity-10"></div>
                    <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-accent rounded-full opacity-10"></div>
                    
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-bullseye mr-3 text-accent"></i>
                        Misi Sekolah
                    </h3>
                    <div class="text-gray-700 prose prose-lg max-w-none">
                        {!! $sekolah->misi ?? 'Misi sekolah belum tersedia' !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Informasi Kontak</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Hubungi kami untuk informasi lebih lanjut
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-gray-50 rounded-lg p-6 flex items-start card-hover">
                    <i class="fas fa-map-marker-alt text-primary text-2xl mr-4 mt-1"></i>
                    <div>
                        <h3 class="font-bold text-lg mb-2">Alamat</h3>
                        <p class="text-gray-600">{{ $sekolah->alamat_sekolah ?? 'Belum Tersedia' }}</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6 flex items-start card-hover">
                    <i class="fas fa-phone text-accent text-2xl mr-4 mt-1"></i>
                    <div>
                        <h3 class="font-bold text-lg mb-2">Telepon</h3>
                        <p class="text-gray-600">{{ $sekolah->telepon_sekolah ?? 'Belum Tersedia' }}</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6 flex items-start card-hover">
                    <i class="fas fa-envelope text-green-500 text-2xl mr-4 mt-1"></i>
                    <div>
                        <h3 class="font-bold text-lg mb-2">Email</h3>
                        <p class="text-gray-600">{{ $sekolah->email_sekolah ?? 'Belum Tersedia' }}</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6 flex items-start card-hover">
                    <i class="fas fa-globe text-purple-500 text-2xl mr-4 mt-1"></i>
                    <div>
                        <h3 class="font-bold text-lg mb-2">Website</h3>
                        <p class="text-gray-600">{{ $sekolah->website_sekolah ?? 'Belum Tersedia' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Media -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Media Sosial</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Ikuti kami di media sosial untuk informasi terbaru
                </p>
            </div>
            
            <div class="flex justify-center space-x-6">
                @if($sekolah->facebook_sekolah)
                <a href="{{ $sekolah->facebook_sekolah }}" class="text-3xl text-blue-600 hover:text-blue-800">
                    <i class="fab fa-facebook"></i>
                </a>
                @endif
                
                @if($sekolah->instagram_sekolah)
                <a href="{{ $sekolah->instagram_sekolah }}" class="text-3xl text-pink-600 hover:text-pink-800">
                    <i class="fab fa-instagram"></i>
                </a>
                @endif
                
                @if($sekolah->youtube_sekolah)
                <a href="{{ $sekolah->youtube_sekolah }}" class="text-3xl text-red-600 hover:text-red-800">
                    <i class="fab fa-youtube"></i>
                </a>
                @endif
                
                @if($sekolah->tiktok_sekolah)
                <a href="{{ $sekolah->tiktok_sekolah }}" class="text-3xl text-gray-800 hover:text-gray-900">
                    <i class="fab fa-tiktok"></i>
                </a>
                @endif
                
                @if($sekolah->whatsapp_sekolah)
                <a href="https://wa.me/{{ $sekolah->whatsapp_sekolah }}" class="text-3xl text-green-600 hover:text-green-800">
                    <i class="fab fa-whatsapp"></i>
                </a>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0ea5e9',
                        secondary: '#075985',
                        accent: '#f97316',
                        dark: '#0f172a'
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>
     <script>
        // Simple toggle for mobile menu
        document.querySelector('button').addEventListener('click', function() {
            alert('Menu navigasi akan ditampilkan di sini pada implementasi lengkap.');
        });
    </script>
@endpush