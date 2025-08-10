@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold text-white mb-4 tracking-tight">Program Keahlian</h1>
                <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                    Temukan program keahlian yang dirancang untuk membekali Anda dengan keterampilan relevan untuk masa depan yang sukses.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $colors = [
                    'blue' => ['from-blue-50', 'to-blue-100', 'from-blue-500', 'to-blue-600'],
                    'purple' => ['from-purple-50', 'to-purple-100', 'from-purple-500', 'to-purple-600'],
                    'green' => ['from-green-50', 'to-green-100', 'from-green-500', 'to-green-600'],
                    'orange' => ['from-orange-50', 'to-orange-100', 'from-orange-500', 'to-orange-600'],
                    'teal' => ['from-teal-50', 'to-teal-100', 'from-teal-500', 'to-teal-600'],
                    'pink' => ['from-pink-50', 'to-pink-100', 'from-pink-500', 'to-pink-600'],
                ];
                $iconMap = [
                    'akuntansi' => 'calculator',
                    'pemasaran' => 'shopping-cart',
                    'perhotelan' => 'hotel',
                    'kimia' => 'flask-round',
                    'musik' => 'music',
                    'komputer' => 'laptop',
                    'jaringan' => 'wifi',
                    'multimedia' => 'camera',
                    'otomotif' => 'car',
                    'mesin' => 'cog',
                    'listrik' => 'zap',
                    'bangunan' => 'home',
                    'broadcasting' => 'radio',
                    'perkantoran' => 'briefcase',
                ];
                $defaultIcon = 'book-open';
            @endphp

            @foreach($jurusans as $index => $jurusan)
                @php
                    $colorIndex = $index % count($colors);
                    $colorKey = array_keys($colors)[$colorIndex];
                    $color = $colors[$colorKey];

                    $selectedIcon = $defaultIcon;
                    foreach ($iconMap as $keyword => $iconName) {
                        if (str_contains(strtolower($jurusan->nama_jurusan), $keyword)) {
                            $selectedIcon = $iconName;
                            break;
                        }
                    }
                @endphp
                <div class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 cursor-pointer relative overflow-hidden border-t-4 border-blue-500">
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="w-16 h-16 bg-gradient-to-br {{ $color[2] }} {{ $color[3] }} rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg mb-4">
                            <i data-lucide="{{ $selectedIcon }}" class="w-8 h-8 text-white"></i>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                {{ $jurusan->nama_jurusan }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                                {{ Str::limit($jurusan->deskripsi_singkat, 150) }}
                            </p>
                        </div>
                        <div class="mt-auto">
                            <div class="pt-4 border-t border-gray-200/80 flex justify-between text-sm text-gray-500 mb-4">
                                <span class="flex items-center"><i data-lucide="users" class="w-4 h-4 mr-1.5 text-gray-400"></i>{{ $jurusan->jumlah_siswa }} Siswa</span>
                                <span class="flex items-center"><i data-lucide="user-check" class="w-4 h-4 mr-1.5 text-gray-400"></i>{{ $jurusan->jumlah_guru }} Guru</span>
                            </div>
                            <a href="{{ route('jurusan.show', $jurusan->slug) }}"
                                class="inline-flex items-center space-x-2 text-blue-600 hover:text-blue-700 font-semibold transition-colors group-hover:space-x-3 duration-200">
                                <span>Pelajari Program</span>
                                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-16 bg-gray-100 rounded-2xl p-10">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Siap Memulai Karir Anda?</h3>
            <p class="text-gray-600 mb-6 max-w-xl mx-auto">Pendaftaran siswa baru telah dibuka. Amankan posisi Anda di jurusan impian dan mulailah langkah pertama menuju kesuksesan.</p>
            <a href="{{ route('ppdb.create') }}"
                class="inline-flex items-center space-x-2 bg-blue-600 text-white px-8 py-3 rounded-full font-medium hover:bg-blue-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                <span>Daftar Sekarang</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>
    </div>
</div>
@endsection