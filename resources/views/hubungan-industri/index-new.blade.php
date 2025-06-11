@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section
        class="hero-pattern bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% text-white py-16 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-4">Hubungan Industri</h1>
            <p class="text-lg md:text-xl max-w-3xl mx-auto mb-8">
                Membangun jaringan kerjasama antara SMK Abdi Negara Tuban dengan dunia industri untuk meningkatkan
                kompetensi siswa dan memenuhi kebutuhan tenaga kerja terampil.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <button
                    class="bg-blue-900 hover:bg-orange-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300">
                    Ajukan Kerjasama
                </button>
                <button
                    class="bg-white hover:bg-green-100 text-blue-500 font-medium py-3 px-6 rounded-lg transition duration-300">
                    Lihat Lowongan Magang
                </button>
            </div>
        </div>
    </section>

    <!-- Partner Companies -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Mitra Industri Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Kami bekerja sama dengan berbagai perusahaan terkemuka untuk memberikan pengalaman magang dan peluang
                    kerja terbaik bagi siswa kami.
                </p>
            </div>

            @if ($hubins->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($hubins as $hubin)
                        <div class="bg-gray-50 rounded-xl p-6 card-hover border border-gray-200">
                            <div class="flex items-center mb-4">
                                @if ($hubin->logo)
                                    <img src="{{ asset('storage/' . $hubin->logo) }}" alt="{{ $hubin->nama_perusahaan }}"
                                        class="w-12 h-12 rounded-lg mr-4">
                                @else
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-building text-blue-600 text-xl"></i>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-bold text-lg text-gray-800">{{ $hubin->nama_perusahaan }}</h3>
                                    <p class="text-sm text-gray-500">{{ $hubin->bidang_usaha }}</p>
                                </div>
                            </div>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt w-4 mr-2"></i>
                                    <span>{{ $hubin->alamat }}</span>
                                </div>
                                @if ($hubin->telepon)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-phone w-4 mr-2"></i>
                                        <span>{{ $hubin->telepon }}</span>
                                    </div>
                                @endif
                                @if ($hubin->website)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-globe w-4 mr-2"></i>
                                        <a href="{{ $hubin->website }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-800">{{ $hubin->website }}</a>
                                    </div>
                                @endif
                            </div>

                            @if ($hubin->deskripsi)
                                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($hubin->deskripsi, 120) }}</p>
                            @endif

                            <div class="border-t pt-4">
                                <p class="text-sm text-gray-500 mb-1">Person in Charge:</p>
                                <p class="font-medium text-gray-800">{{ $hubin->nama_pic }}</p>
                                <p class="text-sm text-gray-600">{{ $hubin->jabatan_pic }}</p>
                                @if ($hubin->email_pic)
                                    <p class="text-sm text-blue-600">{{ $hubin->email_pic }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-handshake text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Mitra Industri</h3>
                    <p class="text-gray-500">Data mitra industri akan segera ditampilkan di sini.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Programs & Benefits -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Program Kerjasama</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Kami menawarkan berbagai program kerjasama yang saling menguntungkan bagi sekolah dan mitra industri.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Program 1 -->
                <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                        <i class="fas fa-user-graduate text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Magang Industri</h3>
                    <p class="text-gray-600">
                        Siswa mendapatkan pengalaman kerja langsung di perusahaan mitra selama 3-6 bulan.
                    </p>
                </div>

                <!-- Program 2 -->
                <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                    <div class="w-14 h-14 rounded-full bg-orange-100 flex items-center justify-center mb-4">
                        <i class="fas fa-chalkboard-teacher text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Guru Tamu</h3>
                    <p class="text-gray-600">
                        Praktisi industri memberikan pelatihan dan berbagi pengalaman kepada siswa.
                    </p>
                </div>

                <!-- Program 3 -->
                <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                    <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center mb-4">
                        <i class="fas fa-tools text-green-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Sumbangan Peralatan</h3>
                    <p class="text-gray-600">
                        Perusahaan menyumbangkan peralatan untuk mendukung praktik siswa di sekolah.
                    </p>
                </div>

                <!-- Program 4 -->
                <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                    <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center mb-4">
                        <i class="fas fa-briefcase text-purple-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Penyerapan Lulusan</h3>
                    <p class="text-gray-600">
                        Prioritas penerimaan lulusan terbaik kami untuk bekerja di perusahaan mitra.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Job Listings -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Lowongan Magang Terbaru</h2>
                    <p class="text-gray-600">Tersedia untuk siswa kelas XI dan XII</p>
                </div>
                <button
                    class="mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-300">
                    Lihat Semua Lowongan
                </button>
            </div>

            @if ($hubins->isNotEmpty())
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach ($hubins->take(4) as $hubin)
                        <div class="bg-gray-50 rounded-lg p-6 job-card card-hover">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center">
                                    @if ($hubin->logo)
                                        <img src="{{ asset('storage/' . $hubin->logo) }}"
                                            alt="{{ $hubin->nama_perusahaan }}" class="w-12 h-12 rounded-lg mr-4">
                                    @else
                                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-building text-blue-600"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-800">Program Magang</h3>
                                        <p class="text-gray-600">{{ $hubin->nama_perusahaan }}</p>
                                        <p class="text-sm text-gray-500">{{ $hubin->bidang_usaha }}</p>
                                    </div>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                    Aktif
                                </span>
                            </div>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt w-4 mr-2"></i>
                                    <span>{{ $hubin->alamat }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-clock w-4 mr-2"></i>
                                    <span>3-6 bulan</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-users w-4 mr-2"></i>
                                    <span>5-10 peserta</span>
                                </div>
                            </div>

                            @if ($hubin->deskripsi)
                                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($hubin->deskripsi, 100) }}</p>
                            @endif

                            <div class="flex items-center justify-between">
                                <div class="text-sm">
                                    <p class="text-gray-500">Kontak:</p>
                                    <p class="font-medium text-gray-800">{{ $hubin->nama_pic }}</p>
                                    @if ($hubin->email_pic)
                                        <p class="text-blue-600">{{ $hubin->email_pic }}</p>
                                    @endif
                                </div>
                                <button
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-300">
                                    Lamar Sekarang
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-briefcase text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Lowongan Magang</h3>
                    <p class="text-gray-500">Lowongan magang akan segera tersedia. Pantau terus halaman ini!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Testimonial</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Apa kata mitra industri dan alumni tentang program hubungan industri kami
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-gray-300 mr-4"></div>
                        <div>
                            <h4 class="font-semibold">Budi Santoso</h4>
                            <p class="text-sm text-gray-500">HR Manager, PT. Teknologi Nusantara</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "Siswa magang dari SMK Abdi Negara Tuban memiliki keterampilan teknis yang sangat baik dan etos
                        kerja yang tinggi. Kami sangat puas dengan kerjasama ini."
                    </p>
                    <div class="flex text-yellow-400 mt-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-gray-300 mr-4"></div>
                        <div>
                            <h4 class="font-semibold">Siti Rahayu</h4>
                            <p class="text-sm text-gray-500">Recruitment Supervisor, PT. Maju Jaya Industries</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "Kami sangat terkesan dengan kemampuan adaptasi dan keterampilan teknis siswa. Mereka cepat belajar
                        dan siap berkontribusi dalam tim kerja kami."
                    </p>
                    <div class="flex text-yellow-400 mt-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-gray-300 mr-4"></div>
                        <div>
                            <h4 class="font-semibold">Ahmad Firdaus</h4>
                            <p class="text-sm text-gray-500">L&D Manager, Bank Digital Indonesia</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "Program magang ini sangat membantu kami dalam mengidentifikasi talenta muda yang berkualitas.
                        Beberapa peserta magang kini menjadi karyawan tetap kami."
                    </p>
                    <div class="flex text-yellow-400 mt-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Jadilah Mitra Industri Kami</h2>
            <p class="text-white text-lg max-w-2xl mx-auto mb-8">
                Dapatkan akses ke calon tenaga kerja terampil yang siap berkontribusi untuk perusahaan Anda.
            </p>
            <button
                class="bg-white hover:bg-gray-100 text-blue-600 font-bold py-3 px-8 rounded-lg text-lg transition duration-300">
                Ajukan Kerjasama Sekarang
            </button>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0ea5e9',
                        secondary: '#075985',
                        accent: '#f97316',
                        dark: '#0f172a'
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>
@endpush

@push('styles')
    <style>
        .hero-pattern {
            background: linear-gradient(to right, rgba(7, 89, 133, 0.9), rgba(14, 165, 233, 0.7)),
                url('https://images.unsplash.com/photo-1543269865-cbf427effbad?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .job-card {
            border-left: 4px solid #0ea5e9;
        }
    </style>
@endpush
