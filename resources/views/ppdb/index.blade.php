@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .category-card {
            transition: all 0.3s ease;
            border-left: 4px solid;
            overflow: hidden;
            position: relative;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: currentColor;
            opacity: 0.2;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .key-value-grid div:nth-child(4n+1),
        .key-value-grid div:nth-child(4n+2) {
            background-color: #F8FAFC;
        }

        .key-value-grid div:nth-child(4n+3),
        .key-value-grid div:nth-child(4n+4) {
            background-color: #F1F5F9;
        }

        .info-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 0.75rem;
            padding: 2px 8px;
            border-radius: 12px;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
        <div class="container mx-auto px-4 py-8">
            <!-- Call to Action -->
            <div
                class="max-w-7xl mx-auto mt-2 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-8 text-center text-white">
                <h2 class="text-2xl md:text-3xl font-bold mb-4">Siap Mendaftar?</h2>
                <p class="text-blue-100 max-w-2xl mx-auto mb-6">Daftarkan putra/putri Anda sekarang dan dapatkan kesempatan
                    belajar di lingkungan pendidikan terbaik.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4"> <a href="{{ route('ppdb.create') }}"
                        class="bg-white text-blue-600 font-semibold py-3 px-8 rounded-lg hover:bg-gray-100 transition duration-300 shadow-md">
                        <i class="fas fa-file-alt mr-2"></i>Daftar Sekarang
                    </a>
                    <a href="#"
                        class="bg-transparent border-2 border-white text-white font-semibold py-3 px-8 rounded-lg hover:bg-white/10 transition duration-300">
                        <i class="fas fa-download mr-2"></i>Download Brosur
                    </a>
                    <a href="/ppdb/status"
                        class="bg-transparent border-2 border-white text-white font-semibold py-3 px-8 rounded-lg hover:bg-white/10 transition duration-300">
                        <i class="fas fa-check mr-2"></i>Cek Status Pendaftaran
                    </a>
                </div>
            </div>

            <!-- Header Section -->
            <div class="max-w-7xl mt-4 mx-auto mb-12 text-center">
                <h1 class="text-3xl md:text-4xl font-bold mb-3 text-gray-900">Informasi Penerimaan Peserta Didik Baru</h1>
                <p class="text-gray-600 max-w-3xl mx-auto">Selamat datang di portal informasi PPDB. Temukan semua informasi
                    penting terkait pendaftaran peserta didik baru di sini.</p>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center">
                        <div class="mr-4 bg-blue-50 p-3 rounded-lg">
                            <i class="fas fa-calendar-day text-blue-500 text-xl"></i>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Periode Pendaftaran</div>
                            <div class="font-semibold text-gray-900">1 Juni - 15 Juli {{ date('Y') }}</div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center">
                        <div class="mr-4 bg-green-50 p-3 rounded-lg">
                            <i class="fas fa-users text-green-500 text-xl"></i>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Target Penerimaan</div>
                            <div class="font-semibold text-gray-900">250 Siswa</div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center">
                        <div class="mr-4 bg-purple-50 p-3 rounded-lg">
                            <i class="fas fa-graduation-cap text-purple-500 text-xl"></i>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Program Keahlian</div>
                            <div class="font-semibold text-gray-900">6 Jurusan</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
                @foreach ($infos->sortKeys() as $kategori => $items)
                    @php
                        $colors = [
                            'syarat' => [
                                'border' => 'border-l-emerald-500',
                                'icon-bg' => 'bg-emerald-100',
                                'icon' => 'text-emerald-500',
                                'badge' => 'bg-emerald-500',
                            ],
                            'gelombang' => [
                                'border' => 'border-l-blue-500',
                                'icon-bg' => 'bg-blue-100',
                                'icon' => 'text-blue-500',
                                'badge' => 'bg-blue-500',
                            ],
                            'jadwal' => [
                                'border' => 'border-l-purple-500',
                                'icon-bg' => 'bg-purple-100',
                                'icon' => 'text-purple-500',
                                'badge' => 'bg-purple-500',
                            ],
                            'biaya' => [
                                'border' => 'border-l-amber-500',
                                'icon-bg' => 'bg-amber-100',
                                'icon' => 'text-amber-500',
                                'badge' => 'bg-amber-500',
                            ],
                            'seragam' => [
                                'border' => 'border-l-rose-500',
                                'icon-bg' => 'bg-rose-100',
                                'icon' => 'text-rose-500',
                                'badge' => 'bg-rose-500',
                            ],
                            'spp' => [
                                'border' => 'border-l-cyan-500',
                                'icon-bg' => 'bg-cyan-100',
                                'icon' => 'text-cyan-500',
                                'badge' => 'bg-cyan-500',
                            ],
                        ];
                        $icons = [
                            'syarat' => 'fa-file-alt',
                            'gelombang' => 'fa-wave-square',
                            'jadwal' => 'fa-calendar-alt',
                            'biaya' => 'fa-money-bill-wave',
                            'seragam' => 'fa-tshirt',
                            'spp' => 'fa-credit-card',
                        ];
                        $categoryColor = $colors[$kategori] ?? $colors['syarat'];
                        $icon = $icons[$kategori] ?? 'fa-file-alt';
                    @endphp

                    <div class="category-card bg-white rounded-xl shadow-sm {{ $categoryColor['border'] }} fade-in">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="mr-3 {{ $categoryColor['icon-bg'] }} p-2 rounded-lg">
                                    <i class="fas {{ $icon }} {{ $categoryColor['icon'] }} text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">{{ ucwords(str_replace('_', ' ', $kategori)) }}
                                </h3>
                                @if ($loop->first)
                                    <span class="info-badge {{ $categoryColor['badge'] }} text-white"></span>
                                @endif
                            </div>

                            @foreach ($items as $info)
                                <div class="space-y-4">
                                    <h4 class="text-lg font-semibold text-gray-800 pb-2 border-b border-gray-200">
                                        {{ $info->judul }}
                                    </h4>

                                    @if ($kategori === 'spp')
                                        @php
                                            $konten = is_string($info->konten)
                                                ? json_decode($info->konten, true)
                                                : $info->konten;
                                        @endphp
                                        <div class="space-y-3 bg-gray-50 rounded-xl p-5">
                                            <div class="key-value-grid">
                                                <div class="grid grid-cols-2 gap-4 items-center p-3">
                                                    <div class="text-gray-700 font-medium">SPP</div>
                                                    <div class="text-right text-gray-900 font-semibold">
                                                        Rp {{ number_format($konten['spp'], 0, ',', '.') }}
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 items-center p-3">
                                                    <div class="text-gray-700 font-medium">Uang Makan</div>
                                                    <div class="text-right text-gray-900 font-semibold">
                                                        Rp {{ number_format($konten['makan'], 0, ',', '.') }}
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 items-center p-3">
                                                    <div class="text-gray-700 font-medium">Ekstrakurikuler</div>
                                                    <div class="text-right text-gray-900 font-semibold">
                                                        Rp {{ number_format($konten['ekstrakurikuler'], 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="bg-gradient-to-r from-cyan-500 to-cyan-600 text-white rounded-lg p-4 mt-4">
                                                <div class="flex justify-between items-center">
                                                    <div class="font-bold">Total Bulanan</div>
                                                    <div class="font-bold text-xl">
                                                        Rp {{ number_format($konten['total'], 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif(is_array($info->konten))
                                        @if (array_keys($info->konten) !== range(0, count($info->konten) - 1))
                                            <div class="space-y-3 bg-gray-50 rounded-xl p-5">
                                                @foreach ($info->konten as $key => $value)
                                                    <div
                                                        class="grid grid-cols-2 gap-4 items-center p-3 hover:bg-white/80 rounded-lg transition-colors duration-200">
                                                        <div class="text-gray-700 font-medium">{{ $key }}</div>
                                                        <div class="text-right text-gray-900 font-semibold">
                                                            {{ $value }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="bg-gray-50 rounded-xl p-5">
                                                <ul class="space-y-3">
                                                    @foreach ($info->konten as $item)
                                                        <li class="flex items-start">
                                                            <i
                                                                class="fas fa-check-circle {{ $categoryColor['icon'] }} mt-1 mr-2"></i>
                                                            <span class="text-gray-700">{{ $item }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @else
                                        <div class="bg-gray-50 rounded-xl p-5">
                                            <p class="text-gray-700">{{ $info->konten }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const cards = document.querySelectorAll('.fade-in');
                cards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.1}s`;
                });
            });
        </script>
    @endpush
@endsection
