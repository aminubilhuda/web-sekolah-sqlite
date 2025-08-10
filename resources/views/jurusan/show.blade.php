@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="relative">
        @if($jurusan->gambar)
            <div class="h-[50vh] w-full">
                <img src="{{ asset('storage/' . $jurusan->gambar) }}" 
                    alt="{{ $jurusan->nama_jurusan }}"
                    class="w-full h-full object-cover" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
            </div>
        @else
            <div class="h-[50vh] w-full bg-gradient-to-r from-blue-600 to-indigo-700"></div>
        @endif
        <div class="absolute bottom-0 left-0 right-0 p-8">
            <div class="max-w-4xl mx-auto">
                <a href="{{ route('jurusan.index') }}" class="inline-flex items-center space-x-2 text-white/80 hover:text-white mb-4">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Kembali ke Semua Jurusan</span>
                </a>
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2 tracking-tight">
                    {{ $jurusan->nama_jurusan }}
                </h1>
                <p class="text-xl text-white/90 max-w-2xl">
                    {{ $jurusan->deskripsi_singkat }}
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12 -mt-16">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Jurusan Detail -->
            <div class="w-full lg:w-8/12">
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Deskripsi Jurusan</h2>
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {!! $jurusan->deskripsi !!}
                        </div>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Prospek Karir</h2>
                        <div class="flex flex-wrap gap-3">
                            <span class="bg-gray-100 text-gray-800 px-4 py-2 rounded-full font-medium">Programmer</span>
                            <span class="bg-gray-100 text-gray-800 px-4 py-2 rounded-full font-medium">Web Developer</span>
                            <span class="bg-gray-100 text-gray-800 px-4 py-2 rounded-full font-medium">Database Administrator</span>
                            <span class="bg-gray-100 text-gray-800 px-4 py-2 rounded-full font-medium">IT Support</span>
                            <span class="bg-gray-100 text-gray-800 px-4 py-2 rounded-full font-medium">Game Developer</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-4/12">
                <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 sticky top-24">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Informasi Jurusan</h2>
                    <div class="space-y-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="user-check" class="w-6 h-6 text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Kepala Jurusan</p>
                                <p class="font-semibold text-gray-800">{{ $jurusan->kepala_jurusan }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="users" class="w-6 h-6 text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jumlah Siswa</p>
                                <p class="font-semibold text-gray-800">{{ $jurusan->jumlah_siswa }} Siswa</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="award" class="w-6 h-6 text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <p class="font-semibold text-gray-800">{{ $jurusan->status }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <a href="{{ route('ppdb.create') }}" class="w-full text-center bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300 block">
                            Daftar ke Jurusan Ini
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 mt-8 sticky top-[calc(24rem+2rem)]">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-3">Jurusan Lainnya</h2>
                    <div class="space-y-3">
                        @foreach(\App\Models\Jurusan::where('id_jurusan', '!=', $jurusan->id_jurusan)->where('status', 'Aktif')->take(4)->get() as $jurusanLain)
                        <a href="{{ route('jurusan.show', $jurusanLain->slug) }}" class="group flex items-center p-3 bg-gray-50 hover:bg-blue-50 rounded-lg transition-colors">
                            <div class="w-10 h-10 bg-blue-100 rounded-md flex items-center justify-center mr-4">
                                <i data-lucide="book-open" class="w-5 h-5 text-blue-600"></i>
                            </div>
                            <div class="flex-grow">
                                <h4 class="font-semibold text-gray-800 group-hover:text-blue-700 transition-colors">{{ $jurusanLain->nama_jurusan }}</h4>
                                <p class="text-xs text-gray-500">{{ $jurusanLain->kode_jurusan }}</p>
                            </div>
                            <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-transform group-hover:translate-x-1"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection