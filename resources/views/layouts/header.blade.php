<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="/">
                <div class="flex items-center space-x-2">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center"
                        data-animation="zoom-in" data-animation-delay="100">
                        @if ($sekolah_aktif && $sekolah_aktif->icon_sekolah)
                            <img src="{{ asset('storage/' . $sekolah_aktif->logo_sekolah) }}" alt="Logo Sekolah"
                                class="w-8 h-8 rounded-full">
                        @else
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center">
                                <div class="w-4 h-4 bg-white rounded-full"></div>
                            </div>
                        @endif
                    </div>
                    <span class="text-xl font-bold text-gray-900" data-animation="fade-in-left"
                        data-animation-delay="200">{{ $sekolah_aktif ? $sekolah_aktif->nama_sekolah : 'Sekolah' }}</span>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-4">
                <a href="/"
                    class="{{ request()->is('/') ? 'text-blue-600 font-medium' : 'text-gray-600' }} hover:text-blue-600 transition-colors">Beranda</a>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center {{ request()->is('profile*') ? 'text-blue-600 font-medium' : 'text-gray-600' }} hover:text-blue-600 transition-colors focus:outline-none">
                        Profile
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute left-0 mt-2 w-48 bg-white rounded shadow-lg z-10" x-cloak>
                        <a href="/profile"
                            class="block px-4 py-2 {{ request()->is('profile/sekolah*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-blue-50' }}">Profile
                            Sekolah</a>
                        <a href="/hubungan-industri"
                            class="block px-4 py-2 {{ request()->is('profile/hubungan-industri*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-blue-50' }}">Hubungan
                            Industri</a>
                    </div>
                </div>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center {{ request()->is('jurusan*', 'berita*', 'galeri*', 'infaq*') ? 'text-blue-600 font-medium' : 'text-gray-600' }} hover:text-blue-600 transition-colors focus:outline-none">
                        Informasi
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute left-0 mt-2 w-48 bg-white rounded shadow-lg z-10" x-cloak>
                        <a href="/jurusan"
                            class="block px-4 py-2 {{ request()->is('jurusan*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-blue-50' }}">Jurusan</a>
                        <a href="/berita"
                            class="block px-4 py-2 {{ request()->is('berita*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-blue-50' }}">Berita</a>
                        <a href="/ppdb"
                            class="block px-4 py-2 {{ request()->is('ppdb*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-blue-50' }}"> <b>PPDB (Siswa Baru)</b></a>
                        <a href="/galeri"
                            class="block px-4 py-2 {{ request()->is('galeri*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-blue-50' }}">Galeri</a>
                        <a href="/infaq"
                            class="block px-4 py-2 {{ request()->is('infaq*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-blue-50' }}">Infaq</a>
                    </div>
                </div>
                <a href="/alumni"
                    class="{{ request()->is('alumni*') ? 'text-blue-600 font-medium' : 'text-gray-600' }} hover:text-blue-600 transition-colors">Alumni</a>
                <a href="/kontak"
                    class="{{ request()->is('kontak*') ? 'text-blue-600 font-medium' : 'text-gray-600' }} hover:text-blue-600 transition-colors">Kontak</a>
            </nav>

            <!-- Desktop Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="/admin" class="flex items-center space-x-2 text-gray-600 justify-center py-2">
                    <i data-lucide="user" class="w-4 h-4"></i>
                    <span>Masuk</span>
                </a>
                <a href="/ppdb"
                    class="flex items-center space-x-2 bg-blue-600 text-white px-4 py-2 rounded-full justify-center">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    <span><b>PPDB (Siswa Baru)</b></span>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden p-2">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden py-4 border-t border-gray-200 hidden">
            <nav class="flex flex-col space-y-4">
                <a href="/" class="text-blue-600 font-medium">Beranda</a>
                <a href="/ppdb" class="text-gray-600">PPDB</a>
                <a href="/profile" class="text-gray-600">Profile Sekolah</a>
                <a href="/jurusan" class="text-gray-600">Jurusan</a>
                <a href="/berita" class="text-gray-600">Berita</a>
                <a href="/galeri" class="text-gray-600">Galeri</a>
                <a href="/infaq" class="text-gray-600">Infaq</a>
                <a href="/alumni" class="text-gray-600">Alumni</a>
                <a href="/kontak" class="text-gray-600">Kontak</a>
                <div class="flex flex-col space-y-2 pt-4 border-t border-gray-200">
                    <a href="/admin" class="flex items-center space-x-2 text-gray-600 justify-center py-2">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span>Masuk</span>
                    </a>
                    <a href="/ppdb"
                        class="flex items-center space-x-2 bg-blue-600 text-white px-4 py-2 rounded-full justify-center">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>PPDB</span>
                    </a>
                </div>
            </nav>
        </div>
    </div>
</header>
