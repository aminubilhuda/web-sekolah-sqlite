@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Informasi PPDB</h1>
        <p class="text-lg text-gray-600">Tahun Ajaran 2024/2025</p>
    </div>

    <!-- Syarat Pendaftaran -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Syarat Pendaftaran</h2>
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($infos['syarat'] ?? [] as $syarat)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ $syarat->judul }}</h3>
                <ul class="space-y-2">
                    @foreach(json_decode($syarat->konten) as $item)
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-600">{{ $item }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Gelombang Pendaftaran -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Gelombang Pendaftaran</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($infos['gelombang'] ?? [] as $gelombang)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ $gelombang->judul }}</h3>
                @php $data = json_decode($gelombang->konten, true); @endphp
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Periode:</span>
                        <span class="font-medium">{{ $data['periode'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Kuota:</span>
                        <span class="font-medium">{{ $data['kuota'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Diskon:</span>
                        <span class="font-medium text-green-600">{{ $data['diskon'] }}</span>
                    </div>
                    <div class="mt-4">
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                            @if($data['status'] == 'Aktif') bg-green-100 text-green-800
                            @elseif($data['status'] == 'Berakhir') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ $data['status'] }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Jadwal -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Jadwal Pendaftaran</h2>
        <div class="bg-white rounded-lg shadow-md p-6">
            @foreach($infos['jadwal'] ?? [] as $jadwal)
            @php $data = json_decode($jadwal->konten, true); @endphp
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($data as $hari => $waktu)
                <div class="text-center p-4 border rounded-lg">
                    <h3 class="font-semibold text-gray-800 mb-2">{{ $hari }}</h3>
                    <p class="text-gray-600">{{ $waktu }}</p>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>

    <!-- Biaya -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Biaya</h2>
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($infos['biaya'] ?? [] as $biaya)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ $biaya->judul }}</h3>
                @php $data = json_decode($biaya->konten, true); @endphp
                <div class="space-y-3">
                    @foreach($data as $item => $harga)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">{{ $item }}</span>
                        <span class="font-medium">{{ $harga }}</span>
                    </div>
                    @if(!$loop->last)
                    <hr class="border-gray-200">
                    @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Seragam -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Seragam</h2>
        <div class="bg-white rounded-lg shadow-md p-6">
            @foreach($infos['seragam'] ?? [] as $seragam)
            @php $data = json_decode($seragam->konten, true); @endphp
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Seragam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($data as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['nama'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $item['jumlah'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $item['harga'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection 