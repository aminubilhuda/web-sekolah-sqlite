@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-pattern bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% text-white py-16 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-4">Hubungan Industri</h1>
            <p class="text-lg md:text-xl max-w-3xl mx-auto mb-8">
                Membangun jaringan kerjasama antara SMK Teknologi Maju dengan dunia industri untuk meningkatkan kompetensi siswa dan memenuhi kebutuhan tenaga kerja terampil.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <button class="bg-accent bg-blue-900 hover:bg-orange-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300">
                    Ajukan Kerjasama
                </button>
                <button class="bg-white hover:bg-green-100 text-blue-500 font-medium py-3 px-6 rounded-lg transition duration-300">
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
                    Kami bekerja sama dengan berbagai perusahaan terkemuka untuk memberikan pengalaman magang dan peluang kerja terbaik bagi siswa kami.
                </p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8">
                <!-- Partner Logo 1 -->
                <div class="bg-gray-100 rounded-lg p-4 flex items-center justify-center h-32 partner-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Telkom_Indonesia_2013.svg/2560px-Telkom_Indonesia_2013.svg.png" alt="Telkom" class="max-h-16">
                </div>
                
                <!-- Partner Logo 2 -->
                <div class="bg-gray-100 rounded-lg p-4 flex items-center justify-center h-32 partner-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Google_2015_logo.svg/800px-Google_2015_logo.svg.png" alt="Google" class="max-h-12">
                </div>
                
                <!-- Partner Logo 3 -->
                <div class="bg-gray-100 rounded-lg p-4 flex items-center justify-center h-32 partner-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Microsoft.svg/2048px-Microsoft.svg.png" alt="Microsoft" class="max-h-12">
                </div>
                
                <!-- Partner Logo 4 -->
                <div class="bg-gray-100 rounded-lg p-4 flex items-center justify-center h-32 partner-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/BMW.svg/2048px-BMW.svg.png" alt="BMW" class="max-h-16">
                </div>
                
                <!-- Partner Logo 5 -->
                <div class="bg-gray-100 rounded-lg p-4 flex items-center justify-center h-32 partner-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/69/Airbnb_Logo_B%C3%A9lo.svg/2560px-Airbnb_Logo_B%C3%A9lo.svg.png" alt="Airbnb" class="max-h-12">
                </div>
                
                <!-- Partner Logo 6 -->
                <div class="bg-gray-100 rounded-lg p-4 flex items-center justify-center h-32 partner-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/96/Samsung_Logo.svg/2560px-Samsung_Logo.svg.png" alt="Samsung" class="max-h-14">
                </div>
            </div>
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
                        <i class="fas fa-user-graduate text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Magang Industri</h3>
                    <p class="text-gray-600">
                        Siswa mendapatkan pengalaman kerja langsung di perusahaan mitra selama 3-6 bulan.
                    </p>
                </div>
                
                <!-- Program 2 -->
                <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                    <div class="w-14 h-14 rounded-full bg-orange-100 flex items-center justify-center mb-4">
                        <i class="fas fa-chalkboard-teacher text-accent text-2xl"></i>
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
                <button class="mt-4 md:mt-0 bg-primary hover:bg-secondary text-white font-medium py-2 px-6 rounded-lg transition duration-300">
                    Lihat Semua Lowongan
                </button>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Job 1 -->
                <div class="bg-gray-50 rounded-lg p-6 job-card card-hover">
                    <div class="flex items-start">
                        <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center mr-4">
                            <i class="fas fa-laptop-code text-primary text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">Frontend Developer</h3>
                            <p class="text-gray-600">PT. Digital Nusantara</p>
                            <div class="flex flex-wrap gap-2 mt-3">
                                <span class="bg-blue-100 text-primary text-sm px-3 py-1 rounded-full">Teknik Komputer</span>
                                <span class="bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full">Magang 6 Bulan</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mt-6">
                        <div>
                            <p class="text-gray-500 text-sm">Pendaftaran ditutup:</p>
                            <p class="font-medium">15 Juli 2023</p>
                        </div>
                        <button class="text-primary hover:text-secondary font-medium">
                            Lamar Sekarang <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Job 2 -->
                <div class="bg-gray-50 rounded-lg p-6 job-card card-hover">
                    <div class="flex items-start">
                        <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center mr-4">
                            <i class="fas fa-car text-accent text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">Mekanik Otomotif</h3>
                            <p class="text-gray-600">PT. Astra Internasional</p>
                            <div class="flex flex-wrap gap-2 mt-3">
                                <span class="bg-blue-100 text-primary text-sm px-3 py-1 rounded-full">Teknik Otomotif</span>
                                <span class="bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full">Magang 3 Bulan</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mt-6">
                        <div>
                            <p class="text-gray-500 text-sm">Pendaftaran ditutup:</p>
                            <p class="font-medium">20 Juli 2023</p>
                        </div>
                        <button class="text-primary hover:text-secondary font-medium">
                            Lamar Sekarang <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>
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
                            <p class="text-sm text-gray-500">HR Manager, PT. Digital Nusantara</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "Siswa magang dari SMK Teknologi Maju memiliki keterampilan teknis yang sangat baik dan etos kerja yang tinggi. Kami sangat puas dengan kerjasama ini."
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
                        <div class="w-12 h-12 rounded-full bg-gray-300 mr-4"></i></div>
                        <div>
                            <h4 class="font-semibold">Siti Rahayu</h4>
                            <p class="text-sm text-gray-500">Alumni, Teknik Komputer</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "Program magang di perusahaan mitra membantu saya mendapatkan pekerjaan segera setelah lulus. Pengalaman praktis sangat berharga!"
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
                            <h4 class="font-semibold">Dewi Anggraini</h4>
                            <p class="text-sm text-gray-500">Direktur, CV. Teknik Jaya</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "Kami telah merekrut beberapa lulusan SMK Teknologi Maju dan mereka langsung bisa berkontribusi tanpa perlu pelatihan panjang. Kompetensi mereka sangat baik."
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
            <button class="bg-white hover:bg-gray-100 text-primary font-bold py-3 px-8 rounded-lg text-lg transition duration-300">
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
        
        .partner-logo {
            filter: grayscale(100%);
            transition: filter 0.3s ease;
        }
        
        .partner-logo:hover {
            filter: grayscale(0%);
        }
        
        .job-card {
            border-left: 4px solid #0ea5e9;
        }
    </style>
@endpush

