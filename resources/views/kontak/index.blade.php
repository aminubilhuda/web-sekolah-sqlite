@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-blue-800 mb-4">Hubungi Kami</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Kami siap membantu Anda. Silakan hubungi kami melalui formulir di bawah ini atau melalui informasi kontak yang tersedia.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-envelope text-xl text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Kirim Pesan</h2>
                        <p class="text-gray-600">Kami akan membalas pesan Anda secepatnya</p>
                    </div>
                </div>
                
                @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-xl text-green-600"></i>
                        </div>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-xl text-red-600"></i>
                        </div>
                        <div>
                            <p class="text-red-700 font-medium">Terjadi kesalahan:</p>
                            <ul class="mt-2 list-disc list-inside text-red-600">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('kontak.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('nama') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap">
                            </div>
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-500 @enderror"
                                    placeholder="Masukkan email aktif">
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="subjek" class="block text-sm font-medium text-gray-700">Subjek</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-gray-400"></i>
                            </div>
                            <input type="text" name="subjek" id="subjek" value="{{ old('subjek') }}" required
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('subjek') border-red-500 @enderror"
                                placeholder="Masukkan subjek pesan">
                        </div>
                        @error('subjek')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="pesan" class="block text-sm font-medium text-gray-700">Pesan</label>
                        <div class="relative">
                            <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                <i class="fas fa-comment text-gray-400"></i>
                            </div>
                            <textarea name="pesan" id="pesan" rows="4" required
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none @error('pesan') border-red-500 @enderror"
                                placeholder="Tulis pesan Anda di sini...">{{ old('pesan') }}</textarea>
                        </div>
                        @error('pesan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex items-center justify-center space-x-2 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-paper-plane"></i>
                            <span>Kirim Pesan</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    <div class="flex items-center space-x-3 mb-8">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-info-circle text-xl text-blue-600"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Informasi Kontak</h2>
                            <p class="text-gray-600">Hubungi kami melalui informasi di bawah ini</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-start space-x-4 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-xl text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Alamat</h3>
                                <p class="mt-1 text-gray-600">{{ $sekolah->alamat_sekolah }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-phone text-xl text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Telepon</h3>
                                <p class="mt-1 text-gray-600">{{ $sekolah->telepon_sekolah }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-envelope text-xl text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Email</h3>
                                <p class="mt-1 text-gray-600">{{ $sekolah->email_sekolah }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Lokasi Kami</h3>
                    </div>
                    <iframe 
                        src="{{ $sekolah->google_maps ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.6666666666665!2d106.66666666666666!3d-6.166666666666666!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTAnMDAuMCJTIDEwNsKwNDAnMDAuMCJF!5e0!3m2!1sid!2sid!4v1234567890' }}"
                        width="100%" 
                        height="300" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush
@endsection 