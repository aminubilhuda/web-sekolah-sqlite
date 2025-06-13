@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-100 via-white to-indigo-100 py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto">
                <!-- Form Cek Status -->
                <div class="bg-white rounded-2xl shadow-lg mb-10 border border-blue-100">
                    <div class="p-8">
                        <h2 class="text-3xl font-extrabold text-blue-800 mb-8 text-center tracking-tight">Cek Status
                            Pendaftaran
                        </h2>
                        @if ($errors->any())
                            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('ppdb.check-status') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-base font-semibold text-gray-700 mb-2">Nomor Registrasi</label>
                                <input type="text" name="nomor_registrasi" value="{{ old('nomor_registrasi') }}" required
                                    placeholder="Contoh: PPDB-2025-0001"
                                    class="w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 px-4 py-3 text-lg">
                            </div>
                            <div class="flex justify-center">
                                <button type="submit"
                                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3 rounded-lg font-semibold shadow hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                                    </svg>
                                    Cek Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Hasil Pencarian -->
                @if (isset($ppdb))
                    <div class="bg-white rounded-2xl shadow-lg border border-blue-100">
                        <div class="p-8">
                            <h3 class="text-2xl font-bold text-blue-800 mb-8 text-center">Informasi Pendaftaran</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <p class="text-sm text-gray-500">Nomor Registrasi</p>
                                    <p class="font-semibold text-lg text-gray-800">{{ $ppdb->nomor_registrasi }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Nama Lengkap</p>
                                    <p class="font-semibold text-lg text-gray-800">{{ $ppdb->nama_lengkap }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">NISN</p>
                                    <p class="font-semibold text-lg text-gray-800">{{ $ppdb->nisn }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Jurusan</p>
                                    <p class="font-semibold text-lg text-gray-800">{{ $ppdb->jurusan->nama_jurusan }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Gelombang</p>
                                    <p class="font-semibold text-lg text-gray-800">Gelombang {{ $ppdb->gelombang }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <div class="mt-1">
                                        @php
                                            $statusColor = match ($ppdb->status) {
                                                'Menunggu' => 'bg-yellow-100 text-yellow-800',
                                                'Diterima' => 'bg-green-100 text-green-800',
                                                'Ditolak' => 'bg-red-100 text-red-800',
                                                'Cadangan' => 'bg-blue-100 text-blue-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-base font-medium {{ $statusColor }}">
                                            {{ $ppdb->status_lengkap }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @if ($ppdb->status === 'Diterima')
                                <div class="mt-8 p-4 bg-green-50 rounded-lg flex items-center gap-3">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                    </svg>
                                    <span class="text-green-800 font-medium">Selamat! Anda diterima. Silakan melakukan
                                        daftar ulang sesuai jadwal yang telah ditentukan.
                                    </span>
                                </div>
                            @elseif($ppdb->status === 'Cadangan')
                                <div class="mt-8 p-4 bg-blue-50 rounded-lg flex items-center gap-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                    </svg>
                                    <span class="text-blue-800 font-medium">Anda masuk daftar cadangan. Silakan menunggu
                                        informasi lebih lanjut.
                                    </span>
                                </div>
                            @elseif($ppdb->status === 'Ditolak')
                                <div class="mt-8 p-4 bg-red-50 rounded-lg flex items-center gap-3">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                    </svg>
                                    <span class="text-red-800 font-medium">Mohon maaf, Anda tidak diterima. Tetap
                                        semangat!</span>
                                </div>
                            @else
                                <div class="mt-8 p-4 bg-yellow-50 rounded-lg flex items-center gap-3">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                    </svg>
                                    <span class="text-yellow-800 font-medium">Pendaftaran Anda sedang dalam proses
                                        verifikasi. Silakan cek kembali dalam 2-3 hari kerja.
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
