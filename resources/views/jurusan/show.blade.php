@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="relative">
        @if($jurusan->gambar)
            <div class="h-[40vh] w-full">
                <img src="{{ asset('storage/' . $jurusan->gambar) }}" 
                    alt="{{ $jurusan->nama_jurusan }}"
                    class="w-full h-full object-cover" />
                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/30 to-transparent"></div>
            </div>
        @else
            <div class="h-[40vh] w-full bg-gradient-to-r from-blue-600 to-blue-800"></div>
        @endif
        <div class="absolute bottom-0 left-0 right-0 p-8">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    {{ $jurusan->nama_jurusan }}
                </h1>
                <p class="text-xl text-white/90">
                    {{ $jurusan->deskripsi_singkat }}
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Jurusan Detail -->
            <div class="w-full lg:w-8/12">
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <div class="flex flex-col md:flex-row items-start md:items-center mb-6">
                        <div class="w-24 h-24 bg-blue-100 rounded-xl flex items-center justify-center mr-6 mb-4 md:mb-0">
                            <i class="fas fa-graduation-cap text-4xl text-blue-600"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $jurusan->nama_jurusan }}</h1>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">{{ $jurusan->kode_jurusan }}</span>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">{{ $jurusan->status }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Deskripsi Jurusan</h2>
                        <div class="prose prose-lg max-w-none mb-6">
                            {!! $jurusan->deskripsi !!}
                        </div>

                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Statistik Jurusan</h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <div class="text-2xl font-bold text-blue-700">{{ $jurusan->jumlah_siswa }}+</div>
                                <div class="text-sm text-gray-600">Siswa Aktif</div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-4 text-center">
                                <div class="text-2xl font-bold text-green-700">{{ $jurusan->jumlah_guru }}</div>
                                <div class="text-sm text-gray-600">Guru & Pengajar</div>
                            </div>
                            <div class="bg-yellow-50 rounded-lg p-4 text-center">
                                <div class="text-2xl font-bold text-yellow-700">100%</div>
                                <div class="text-sm text-gray-600">Fasilitas Lengkap</div>
                            </div>
                            <div class="bg-purple-50 rounded-lg p-4 text-center">
                                <div class="text-2xl font-bold text-purple-700">{{ $jurusan->status }}</div>
                                <div class="text-sm text-gray-600">Status Jurusan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-4/12">
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Jurusan</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-medium text-gray-700 mb-1">Kode Jurusan</h3>
                            <p class="text-gray-600">{{ $jurusan->kode_jurusan }}</p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-700 mb-1">Kepala Jurusan</h3>
                            <p class="text-gray-600">{{ $jurusan->kepala_jurusan }}</p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-700 mb-1">Status</h3>
                            <p class="text-gray-600">{{ $jurusan->status }}</p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-700 mb-1">Jumlah Guru</h3>
                            <p class="text-gray-600">{{ $jurusan->jumlah_guru }} orang</p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-700 mb-1">Jumlah Siswa</h3>
                            <p class="text-gray-600">{{ $jurusan->jumlah_siswa }} siswa</p>
                        </div>
                    </div>
                </div>

                @if($jurusan->gambar)
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Galeri Jurusan</h2>
                    <div class="aspect-video bg-gray-200 rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $jurusan->gambar) }}" 
                            alt="{{ $jurusan->nama_jurusan }}"
                            class="w-full h-full object-cover" />
                    </div>
                </div>
                @endif

                <div class="bg-white rounded-xl shadow-md p-6 mt-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Jurusan Lainnya</h2>
                    <div class="space-y-4">
                        @foreach(\App\Models\Jurusan::where('id_jurusan', '!=', $jurusan->id_jurusan)
                            ->where('status', 'Aktif')
                            ->take(4)
                            ->get() as $jurusanLain)
                        <a href="{{ route('jurusan.show', $jurusanLain->slug) }}" class="block jurusan-card bg-gray-50 hover:bg-blue-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-graduation-cap text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $jurusanLain->nama_jurusan }}</h3>
                                    <p class="text-sm text-gray-600">{{ $jurusanLain->kode_jurusan }}</p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 