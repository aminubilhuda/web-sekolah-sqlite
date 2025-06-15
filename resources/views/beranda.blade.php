@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="py-12 lg:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-8">
                    <div class="space-y-6">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight"
                            data-animation="fade-in-up" data-animation-duration="0.8s">
                            Temukan
                            <span class="inline-flex items-center">
                                <span
                                    class="w-12 h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center mr-3">
                                    @if ($sekolah_aktif && $sekolah_aktif->logo_sekolah)
                                        <img src="{{ asset('storage/' . $sekolah_aktif->logo_sekolah) }}" alt="Logo Sekolah"
                                            class="w-8 h-8 rounded-full">
                                    @else
                                        <div
                                            class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center">
                                            <div class="w-4 h-4 bg-white rounded-full"></div>
                                        </div>
                                    @endif
                                </span>
                            </span>
                            <br />
                            <span class="text-blue-600">Keajaiban Belajar</span>
                            <br />
                            Di Sekolah Kami
                        </h1>

                        <p class="text-lg text-gray-600 max-w-md" data-animation="fade-in-up" data-animation-delay="200"
                            data-animation-duration="0.8s">
                            Bergabunglah dengan komunitas pembelajaran yang menginspirasi dan membentuk masa depan
                            cerah.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4" data-animation="fade-in-up" data-animation-delay="400"
                        data-animation-duration="0.8s">
                        <a href="/ppdb"
                            class="bg-blue-600 text-white px-8 py-4 rounded-full font-medium hover:bg-blue-700 transition-all duration-200 transform hover:scale-105 flex items-center justify-center space-x-2 group">
                            <span>Daftar Sekarang</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                        </a>

                        <button id="tontonAcaraBtn"
                            class="flex items-center space-x-3 text-gray-700 hover:text-blue-600 transition-colors group">
                            <div
                                class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center group-hover:bg-yellow-500 transition-colors">
                                <i data-lucide="play" class="w-4 h-4 text-white ml-1"></i>
                            </div>
                            <span class="font-medium">Tonton Acara</span>
                        </button>
                    </div>
                </div>

                <!-- Right Content - Image Slider -->
                <div class="relative" data-animation="fade-in-right" data-animation-delay="300"
                    data-animation-duration="1s">
                    <div class="relative bg-gradient-to-br from-blue-100 to-purple-100 rounded-3xl overflow-hidden">
                        <!-- Enhanced Swiper Container for Full Image Display -->
                        <div class="hero-image-container">
                            <div class="swiper heroSwiper h-full">
                                <div class="swiper-wrapper">
                                    @foreach(\App\Models\Slider::where('status', 'Aktif')->orderBy('urutan')->get() as $slider)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/' . $slider->gambar) }}" 
                                            alt="{{ $slider->judul }}" 
                                            class="w-full h-full object-cover" />
                                        <!-- Overlay Content -->
                                        <div class="absolute bottom-6 left-6 right-6 z-10">
                                            <div class="bg-black/20 backdrop-blur-sm rounded-2xl p-4 text-white">
                                                <h3 class="text-lg font-semibold mb-2">{{ $slider->judul }}</h3>
                                                <p class="text-sm leading-relaxed">
                                                    {{ $slider->deskripsi }}
                                                </p>
                                                @if($slider->link)
                                                <a href="{{ $slider->link }}" class="inline-block mt-3 text-sm font-medium text-white hover:text-blue-200">
                                                    Selengkapnya →
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="swiper-button-prev hero-prev">
                                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                </div>
                                <div class="swiper-button-next hero-next">
                                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                </div>

                                <!-- Pagination -->
                                <div class="swiper-pagination hero-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Continue with rest of content... -->
    <!-- Features Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-blue-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-8 lg:p-12 shadow-2xl">
                <div class="grid lg:grid-cols-4 gap-8 items-center">
                    <!-- Left Content -->
                    <div class="lg:col-span-1 space-y-4" data-animation="fade-in-left" data-animation-duration="0.8s">
                        <div class="flex items-center space-x-2">
                            <h2 class="text-2xl lg:text-3xl font-bold text-gray-900">Keunggulan Kami</h2>
                            <div class="w-8 h-1 bg-yellow-400 rounded-full"></div>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Fasilitas dan program unggulan yang mendukung
                            perkembangan optimal setiap siswa.
                        </p>
                    </div>

                    <!-- Feature Cards -->
                    <div class="lg:col-span-3 grid md:grid-cols-3 gap-6 stagger-container" data-animation-delay="200">
                        <div class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 cursor-pointer relative card-hover stagger-item"
                            data-animation="pop-in" data-animation-duration="0.6s">
                            <div class="space-y-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 icon-bounce">
                                    <i data-lucide="lightbulb" class="w-6 h-6 text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                        Kurikulum Inovatif
                                    </h3>
                                    <button
                                        class="flex items-center space-x-2 text-sm text-blue-600 hover:text-blue-700 transition-colors group-hover:space-x-3 duration-200">
                                        <span>Pelajari Lebih Lanjut</span>
                                        <i data-lucide="arrow-right"
                                            class="w-3 h-3 group-hover:translate-x-1 transition-transform"></i>
                                    </button>
                                </div>
                            </div>
                            <div
                                class="absolute top-4 right-4 w-2 h-2 bg-yellow-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            </div>
                        </div>

                        <div class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 cursor-pointer relative card-hover stagger-item"
                            data-animation="pop-in" data-animation-duration="0.6s">
                            <div class="space-y-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 icon-bounce">
                                    <i data-lucide="book-open" class="w-6 h-6 text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                        Tenaga Pengajar Berpengalaman
                                    </h3>
                                    <button
                                        class="flex items-center space-x-2 text-sm text-blue-600 hover:text-blue-700 transition-colors group-hover:space-x-3 duration-200">
                                        <span>Pelajari Lebih Lanjut</span>
                                        <i data-lucide="arrow-right"
                                            class="w-3 h-3 group-hover:translate-x-1 transition-transform"></i>
                                    </button>
                                </div>
                            </div>
                            <div
                                class="absolute top-4 right-4 w-2 h-2 bg-yellow-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            </div>
                        </div>

                        <div class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 cursor-pointer relative card-hover stagger-item"
                            data-animation="pop-in" data-animation-duration="0.6s">
                            <div class="space-y-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-green-400 to-teal-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 icon-bounce">
                                    <i data-lucide="puzzle" class="w-6 h-6 text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                        Pengembangan Holistik
                                    </h3>
                                    <button
                                        class="flex items-center space-x-2 text-sm text-blue-600 hover:text-blue-700 transition-colors group-hover:space-x-3 duration-200">
                                        <span>Pelajari Lebih Lanjut</span>
                                        <i data-lucide="arrow-right"
                                            class="w-3 h-3 group-hover:translate-x-1 transition-transform"></i>
                                    </button>
                                </div>
                            </div>
                            <div
                                class="absolute top-4 right-4 w-2 h-2 bg-yellow-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Principal Message Section -->
    <section class="py-16 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content - Principal Photo -->
                <div class="relative" data-animation="fade-in-left" data-animation-duration="1s">
                    <div class="relative bg-gradient-to-br from-blue-100 to-purple-100 rounded-3xl overflow-hidden">
                        @if ($sekolah_aktif && $sekolah_aktif->foto_kepala_sekolah)
                            <img src="{{ asset('storage/' . $sekolah_aktif->foto_kepala_sekolah) }}"
                                alt="Kepala Sekolah" class="w-full h-[400px] object-cover" />
                        @else
                        <img src="https://images.pexels.com/photos/5212345/pexels-photo-5212345.jpeg?auto=compress&cs=tinysrgb&w=600"
                            alt="Kepala Sekolah" class="w-full h-[400px] object-cover" />
                        @endif
                        <div
                            class="absolute top-6 right-6 w-16 h-16 bg-yellow-400 rounded-full flex items-center justify-center">
                            <i data-lucide="quote" class="w-6 h-6 text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Message -->
                <div class="space-y-6" data-animation="fade-in-right" data-animation-delay="200"
                    data-animation-duration="1s">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">Sambutan Kepala Sekolah</h2>
                            <div class="w-8 h-1 bg-blue-600 rounded-full"></div>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-blue-600">
                            <i data-lucide="quote" class="w-8 h-8 text-blue-600 mb-4"></i>
                            <p class="text-gray-700 leading-relaxed mb-4">
                                {!! $sekolah_aktif ? $sekolah_aktif->sambutan_kepala_sekolah : 'Sambutan Kepala Sekolah belum tersedia' !!}
                            </p>
                            <p class="text-gray-700 leading-relaxed mb-6"> </p>

                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center">
                                    @if ($sekolah_aktif && $sekolah_aktif->foto_kepala_sekolah)
                                        <img src="{{ asset('storage/' . $sekolah_aktif->foto_kepala_sekolah) }}"
                                            alt="Foto Kepala Sekolah" class="w-12 h-12 rounded-full object-cover">
                                    @else
                                        <i data-lucide="user" class="w-5 h-5 text-white"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Kepala Sekolah</h4>
                                    <p class="text-sm text-gray-600">Kepala Sekolah</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-animation="fade-in-up" data-animation-duration="0.8s">
                <div class="flex items-center justify-center space-x-2 mb-4">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">Program Keahlian</h2>
                    <div class="w-8 h-1 bg-yellow-400 rounded-full"></div>
                </div>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Pilih program keahlian yang sesuai dengan minat dan bakat Anda untuk masa depan yang cerah
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($jurusans as $jurusan)
                    <a href="{{ route('jurusan.show', $jurusan->slug) }}" class="group">
                        <div
                            class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                            <div class="relative h-48 overflow-hidden">
                                @if ($jurusan->gambar)
                                    <img src="{{ asset('storage/' . $jurusan->gambar) }}"
                                        alt="{{ $jurusan->nama_jurusan }}"
                                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                        <i data-lucide="book-open" class="w-16 h-16 text-white opacity-50"></i>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6">
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $jurusan->nama_jurusan }}</h3>
                                    <p class="text-white/90 text-sm">
                                        {{ Str::limit($jurusan->deskripsi_singkat, 150) }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <i data-lucide="users" class="w-5 h-5 text-blue-600"></i>
                                        <span class="text-sm text-gray-600">{{ $jurusan->jumlah_siswa }} Siswa</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i data-lucide="book" class="w-5 h-5 text-blue-600"></i>
                                        <span class="text-sm text-gray-600">{{ $jurusan->jumlah_guru }} Guru</span>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-sm text-gray-600">{{ $jurusan->kepala_jurusan }}</span>
                                    <div
                                        class="inline-flex items-center space-x-2 text-sm font-medium text-blue-600 group-hover:space-x-3 transition-all duration-200">
                                        <span>Pelajari Program</span>
                                        <i data-lucide="arrow-right"
                                            class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Call to Action -->
            <div class="text-center mt-12" data-animation="fade-in-up" data-animation-delay="400">
                <a href="{{ route('jurusan.index') }}"
                    class="inline-block bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-4 rounded-full font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    Lihat Semua Program
                </a>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="py-16 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-animation="fade-in-up" data-animation-duration="0.8s">
                <div class="flex items-center justify-center space-x-2 mb-4">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">Berita & Pengumuman</h2>
                    <div class="w-8 h-1 bg-yellow-400 rounded-full"></div>
                </div>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Ikuti perkembangan terbaru dan informasi penting dari sekolah kami
                </p>
            </div>

            <!-- Headline News -->
            @if ($beritas->where('headline', 'Yes')->first())
                <div class="mb-12">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                        <div class="md:flex">
                            <div class="md:w-5/12">
                                @if ($beritas->where('headline', 'Yes')->first()->gambar)
                                    <img src="{{ asset('storage/' . $beritas->where('headline', 'Yes')->first()->gambar) }}"
                                        alt="{{ $beritas->where('headline', 'Yes')->first()->judul }}"
                                        class="w-full h-64 object-cover">
                                @else
                                    <div
                                        class="w-full h-64 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
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
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-8 stagger-container" data-animation-delay="200">
                @foreach ($beritas->where('headline', 'No')->take(3) as $berita)
                    <article
                        class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 cursor-pointer card-hover stagger-item"
                        data-animation="fade-in-up" data-animation-duration="0.7s">
                        <div class="relative overflow-hidden">
                            @if ($berita->gambar)
                                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}"
                                    class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300" />
                            @else
                                <div
                                    class="w-full h-48 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                                    <i data-lucide="newspaper" class="w-12 h-12 text-gray-400"></i>
                                </div>
                            @endif
                            <div
                                class="absolute top-4 left-4 bg-gradient-to-r from-yellow-500 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-medium flex items-center space-x-1">
                                <i data-lucide="tag" class="w-3 h-3"></i>
                                <span>{{ $berita->kategori }}</span>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <div class="flex items-center space-x-1">
                                    <i data-lucide="calendar" class="w-3 h-3"></i>
                                    <span>{{ \Carbon\Carbon::parse($berita->tanggal_publish)->format('d F Y') }}</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i data-lucide="user" class="w-3 h-3"></i>
                                    <span>{{ $berita->penulis }}</span>
                                </div>
                            </div>
                            <h3
                                class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors leading-tight">
                                {{ $berita->judul }}
                            </h3>
                            <p class="text-gray-600 leading-relaxed">
                                {{ Str::limit(strip_tags($berita->isi), 150) }}
                            </p>
                            <a href="{{ route('berita.show', $berita->slug) }}"
                                class="flex items-center space-x-2 text-blue-600 hover:text-blue-700 font-medium transition-colors group-hover:space-x-3 duration-200">
                                <span>Baca Selengkapnya</span>
                                <i data-lucide="arrow-right"
                                    class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- View All News Button -->
            <div class="text-center mt-12" data-animation="fade-in-up" data-animation-delay="400">
                <a href="{{ route('berita.index') }}"
                    class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-4 rounded-full font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-200 transform hover:scale-105 shadow-lg flex items-center space-x-2 mx-auto inline-block">
                    <span>Lihat Semua Berita</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Modal YouTube -->
    <div id="modalYoutube" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-4 max-w-lg w-full relative">
            <button id="closeModalYoutube" class="absolute top-2 right-2 text-gray-500 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="aspect-w-16 aspect-h-9">
                @if ($sekolah_aktif && $sekolah_aktif->logo_sekolah)
                <iframe id="youtubeFrame" width="100%" height="315" src="https://www.youtube.com/embed/{{ $sekolah_aktif->youtube_id }}?autoplay=1" title="YouTube video player" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                @else
                <iframe id="youtubeFrame" width="100%" height="315" src="https://www.youtube.com/embed/GQL4Bx6mjhA?autoplay=1" title="YouTube video player" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('tontonAcaraBtn').addEventListener('click', function() {
            document.getElementById('modalYoutube').classList.remove('hidden');
        });
        document.getElementById('closeModalYoutube').addEventListener('click', function() {
            document.getElementById('modalYoutube').classList.add('hidden');
            // Stop video
            document.getElementById('youtubeFrame').src = document.getElementById('youtubeFrame').src;
        });
    </script>
    @endpush
@endsection
