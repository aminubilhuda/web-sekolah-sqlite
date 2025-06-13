@extends('layouts.app')

@push('styles')
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatAnimation {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .hover-float:hover {
            animation: floatAnimation 2s ease-in-out infinite;
        }

        .card-gradient {
            background: linear-gradient(145deg, #ffffff 0%, #f3f4f6 100%);
        }

        .custom-shadow {
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.1),
                0 5px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .hover-shadow {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.15),
                0 10px 20px -3px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .card-border {
            border: 1px solid rgba(229, 231, 235, 0.7);
            position: relative;
        }

        .card-border::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 1rem;
            padding: 2px;
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.2), rgba(99, 102, 241, 0.2));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-blue-50">
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12 animate-fade-in-up">
                    <h2
                        class="text-3xl md:text-4xl font-bold mb-4 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Informasi PPDB
                    </h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Informasi lengkap mengenai Penerimaan Peserta Didik Baru untuk tahun ajaran
                        {{ date('Y') }}/{{ date('Y') + 1 }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($infos->sortKeys() as $kategori => $items)
                        <div class="group card-gradient rounded-2xl custom-shadow hover-shadow card-border backdrop-blur-sm p-6 animate-fade-in-up"
                            style="animation-delay: {{ $loop->index * 150 }}ms">
                            <div class="flex items-center mb-6">
                                @php
                                    $colors = [
                                        'syarat' => [
                                            'icon' => 'text-emerald-500 group-hover:text-emerald-600',
                                            'hover' => 'group-hover:text-emerald-600',
                                            'bg' => 'bg-emerald-50',
                                        ],
                                        'gelombang' => [
                                            'icon' => 'text-blue-500 group-hover:text-blue-600',
                                            'hover' => 'group-hover:text-blue-600',
                                            'bg' => 'bg-blue-50',
                                        ],
                                        'jadwal' => [
                                            'icon' => 'text-purple-500 group-hover:text-purple-600',
                                            'hover' => 'group-hover:text-purple-600',
                                            'bg' => 'bg-purple-50',
                                        ],
                                        'biaya' => [
                                            'icon' => 'text-amber-500 group-hover:text-amber-600',
                                            'hover' => 'group-hover:text-amber-600',
                                            'bg' => 'bg-amber-50',
                                        ],
                                        'seragam' => [
                                            'icon' => 'text-rose-500 group-hover:text-rose-600',
                                            'hover' => 'group-hover:text-rose-600',
                                            'bg' => 'bg-rose-50',
                                        ],
                                        'spp' => [
                                            'icon' => 'text-cyan-500 group-hover:text-cyan-600',
                                            'hover' => 'group-hover:text-cyan-600',
                                            'bg' => 'bg-cyan-50',
                                        ],
                                    ];
                                    $icons = [
                                        'syarat' =>
                                            '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>',
                                        'gelombang' =>
                                            '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
                                        'jadwal' =>
                                            '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                        'biaya' =>
                                            '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                        'seragam' =>
                                            '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>',
                                        'spp' =>
                                            '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
                                    ];
                                    $categoryColor = $colors[$kategori] ?? $colors['syarat'];
                                @endphp
                                <div
                                    class="mr-3 {{ $categoryColor['icon'] }} transition-all duration-300 transform group-hover:scale-110 p-2 rounded-lg {{ $categoryColor['bg'] }}">
                                    {!! $icons[$kategori] ?? $icons['syarat'] !!}
                                </div>
                                <h3
                                    class="text-xl font-semibold text-gray-900 {{ $categoryColor['hover'] }} transition-colors duration-300">
                                    {{ ucwords(str_replace('_', ' ', $kategori)) }}
                                </h3>
                            </div>

                            @foreach ($items as $info)
                                <div class="mb-8 last:mb-0">
                                    <h4
                                        class="text-lg font-medium mb-4 text-gray-800 border-b border-gray-200 pb-2 relative overflow-hidden">
                                        <span class="relative z-10">{{ $info->judul }}</span>
                                        <div
                                            class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r {{ str_replace('text', 'bg', $categoryColor['icon']) }} transform origin-left transition-transform duration-300 scale-x-0 group-hover:scale-x-100">
                                        </div>
                                    </h4>

                                    @if ($kategori === 'spp')
                                        @php
                                            $konten = is_string($info->konten)
                                                ? json_decode($info->konten, true)
                                                : $info->konten;
                                        @endphp
                                        <div
                                            class="space-y-3 rounded-xl p-5 {{ $categoryColor['bg'] }}/30 shadow-inner transition-all duration-300 transform group-hover:scale-[1.02]">
                                            <div
                                                class="grid grid-cols-2 gap-4 items-center hover:bg-white/60 p-3 rounded-lg transition-colors duration-200">
                                                <div class="text-gray-700 font-medium">SPP</div>
                                                <div class="text-right text-gray-900 font-semibold">
                                                    Rp {{ number_format($konten['spp'], 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <div
                                                class="grid grid-cols-2 gap-4 items-center hover:bg-white/60 p-3 rounded-lg transition-colors duration-200">
                                                <div class="text-gray-700 font-medium">Uang Makan</div>
                                                <div class="text-right text-gray-900 font-semibold">
                                                    Rp {{ number_format($konten['makan'], 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <div
                                                class="grid grid-cols-2 gap-4 items-center hover:bg-white/60 p-3 rounded-lg transition-colors duration-200">
                                                <div class="text-gray-700 font-medium">Ekstrakurikuler</div>
                                                <div class="text-right text-gray-900 font-semibold">
                                                    Rp {{ number_format($konten['ekstrakurikuler'], 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <div
                                                class="grid grid-cols-2 gap-4 items-center border-t border-gray-200/50 pt-4 mt-4 bg-white/60 p-3 rounded-lg">
                                                <div class="text-gray-900 font-bold">Total</div>
                                                <div class="text-right {{ $categoryColor['icon'] }} font-bold text-lg">
                                                    Rp {{ number_format($konten['total'], 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>
                                    @elseif(is_array($info->konten))
                                        @if (array_keys($info->konten) !== range(0, count($info->konten) - 1))
                                            {{-- Associative array --}}
                                            <div
                                                class="space-y-3 rounded-xl p-5 {{ $categoryColor['bg'] }}/30 shadow-inner transition-all duration-300 transform group-hover:scale-[1.02]">
                                                @foreach ($info->konten as $key => $value)
                                                    <div
                                                        class="grid grid-cols-2 gap-4 items-center hover:bg-white/60 p-3 rounded-lg transition-colors duration-200">
                                                        <div class="text-gray-700 font-medium">{{ $key }}</div>
                                                        <div class="text-right text-gray-900 font-semibold">
                                                            {{ $value }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            {{-- Sequential array --}}
                                            <ul
                                                class="space-y-2 rounded-xl p-5 {{ $categoryColor['bg'] }}/30 shadow-inner transition-all duration-300 transform group-hover:scale-[1.02]">
                                                @foreach ($info->konten as $item)
                                                    <li
                                                        class="flex items-start p-3 hover:bg-white/60 rounded-lg transition-colors duration-200">
                                                        <span
                                                            class="{{ $categoryColor['icon'] }} mr-3 flex-shrink-0">•</span>
                                                        <span class="text-gray-700">{{ $item }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @else
                                        <p
                                            class="text-gray-700 rounded-xl p-5 {{ $categoryColor['bg'] }}/30 shadow-inner transition-all duration-300 transform group-hover:scale-[1.02] hover:bg-white/60">
                                            {{ $info->konten }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
