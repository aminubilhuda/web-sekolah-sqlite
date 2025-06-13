@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-8 text-center">
                    <div class="mb-6">
                        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-3xl text-green-500"></i>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Pendaftaran Berhasil!</h2>

                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <p class="text-gray-600 mb-2">Nomor Registrasi Anda:</p>
                        <p class="text-2xl font-bold text-blue-600">{{ session('success') }}</p>
                    </div>

                    <div class="text-gray-600 mb-8">
                        <p>Simpan nomor registrasi Anda untuk keperluan pengecekan status pendaftaran.</p>
                        <p class="mt-2">Tim kami akan memverifikasi data pendaftaran Anda dalam 2-3 hari kerja.</p>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('ppdb.index') }}"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                        </a>
                        <a href="{{ route('ppdb.status') }}"
                            class="bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
                            <i class="fas fa-search mr-2"></i>Cek Status
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
