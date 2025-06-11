@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white mb-4">Program Keahlian</h1>
                <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                    Pilih program keahlian yang sesuai dengan minat dan bakat Anda untuk masa depan yang cerah
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
                $icons = [
                    'calculator', 'shopping-cart', 'hotel', 'microscope', 'music',
                    'book', 'briefcase', 'flask', 'pencil', 'ruler', 'tools'
                ];
            @endphp

            @foreach($jurusans as $index => $jurusan)
                @php
                    $colorIndex = $index % count($colors);
                    $colorKey = array_keys($colors)[$colorIndex];
                    $color = $colors[$colorKey];
                    $icon = $icons[$index % count($icons)];
                @endphp
                <div class="group bg-gradient-to-br {{ $color[0] }} {{ $color[1] }} rounded-2xl p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 cursor-pointer relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/10 rounded-full translate-y-8 -translate-x-8"></div>
                    <div class="relative space-y-4">
                        <div class="w-14 h-14 bg-gradient-to-br {{ $color[2] }} {{ $color[3] }} rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 shadow-lg">
                            <i data-lucide="{{ $icon }}" class="w-7 h-7 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                {{ $jurusan->nama_jurusan }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                                {{ Str::limit($jurusan->deskripsi_singkat, 150) }}
                            </p>
                            <a href="{{ route('jurusan.show', $jurusan->slug) }}"
                                class="inline-flex items-center space-x-2 text-blue-600 hover:text-blue-700 font-medium transition-colors group-hover:space-x-3 duration-200">
                                <span>Pelajari Program</span>
                                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Call to Action -->
        {{-- <div class="text-center mt-12">
            <a href="{{ route('pendaftaran.create') }}"
                class="inline-flex items-center space-x-2 bg-blue-600 text-white px-8 py-4 rounded-full font-medium hover:bg-blue-700 transition-all duration-200 transform hover:scale-105">
                <span>Daftar Sekarang</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div> --}}
    </div>
</div>
@endsection 