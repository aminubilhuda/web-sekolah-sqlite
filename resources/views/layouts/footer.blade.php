    <footer class="bg-gray-900 text-white pt-12 pb-6 mt-16" data-animation="fade-in-up" data-animation-duration="1s"
        data-animation-delay="300">
        <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-4 gap-8">
            <!-- Identitas -->
            <div>
                <div class="flex items-center space-x-2 mb-2">
                    @if($sekolah_aktif && $sekolah_aktif->logo_sekolah)
                    <img src="{{ asset('storage/' . $sekolah_aktif->logo_sekolah) }}" alt="Logo Sekolah" class="w-8 h-8 rounded-full">
                    @else
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center">
                        <div class="w-4 h-4 bg-white rounded-full"></div>
                    </div>
                    @endif
                    <span class="text-lg font-bold">{{ $sekolah_aktif ? $sekolah_aktif->nama_sekolah : 'Sekolah' }}</span>
                </div>
                <p class="text-sm text-gray-300 mb-2">
                    {{ $sekolah_aktif ? $sekolah_aktif->alamat_sekolah : 'Alamat Sekolah' }}
                    @if($sekolah_aktif && $sekolah_aktif->desa_kelurahan)
                    , {{ $sekolah_aktif->desa_kelurahan }}
                    @endif
                    @if($sekolah_aktif && $sekolah_aktif->kecamatan)
                    , {{ $sekolah_aktif->kecamatan }}
                    @endif
                    @if($sekolah_aktif && $sekolah_aktif->kabupaten_kota)
                    , {{ $sekolah_aktif->kabupaten_kota }}
                    @endif
                    @if($sekolah_aktif && $sekolah_aktif->provinsi)
                    , {{ $sekolah_aktif->provinsi }}
                    @endif
                    @if($sekolah_aktif && $sekolah_aktif->kode_pos)
                    {{ $sekolah_aktif->kode_pos }}
                    @endif
                </p>
                @if($sekolah_aktif && $sekolah_aktif->telepon_sekolah)
                <p class="text-sm text-gray-300">Telp: {{ $sekolah_aktif->telepon_sekolah }}</p>
                @endif
                @if($sekolah_aktif && $sekolah_aktif->email_sekolah)
                <p class="text-sm text-gray-300">Email: {{ $sekolah_aktif->email_sekolah }}</p>
                @endif
                <p class="text-xs text-gray-400 mt-2">Senin - Jumat: 07.00 - 16.00 WIB</p>
            </div>
            <!-- Navigasi -->
            <div>
                <h4 class="font-semibold mb-3">Navigasi</h4>
                <ul class="grid grid-cols-2 gap-x-6 gap-y-2 text-sm">
                    <li><a href="#" class="hover:text-blue-400">Beranda</a></li>
                    <li><a href="#" class="hover:text-blue-400">Profile Sekolah</a></li>
                    <li><a href="#" class="hover:text-blue-400">Jurusan</a></li>
                    <li><a href="#" class="hover:text-blue-400">Berita</a></li>
                    <li><a href="#" class="hover:text-blue-400">Galeri</a></li>
                    <li><a href="#" class="hover:text-blue-400">Infaq</a></li>
                    <li><a href="#" class="hover:text-blue-400">Alumni</a></li>
                    <li><a href="#" class="hover:text-blue-400">Kontak</a></li>
                </ul>
            </div>
            <!-- Sosial Media -->
            <div>
                <h4 class="font-semibold mb-3">Sosial Media</h4>
                <div class="flex space-x-4">
                    @if($sekolah_aktif && $sekolah_aktif->facebook_sekolah)
                    <a href="{{ $sekolah_aktif->facebook_sekolah }}" target="_blank" class="hover:text-blue-400"><i data-lucide="facebook" class="w-5 h-5"></i></a>
                    @endif
                    @if($sekolah_aktif && $sekolah_aktif->instagram_sekolah)
                    <a href="{{ $sekolah_aktif->instagram_sekolah }}" target="_blank" class="hover:text-pink-400"><i data-lucide="instagram" class="w-5 h-5"></i></a>
                    @endif
                    @if($sekolah_aktif && $sekolah_aktif->youtube_sekolah)
                    <a href="{{ $sekolah_aktif->youtube_sekolah }}" target="_blank" class="hover:text-red-400"><i data-lucide="youtube" class="w-5 h-5"></i></a>
                    @endif
                    @if($sekolah_aktif && $sekolah_aktif->tiktok_sekolah)
                    <a href="{{ $sekolah_aktif->tiktok_sekolah }}" target="_blank" class="hover:text-gray-400"><i data-lucide="music" class="w-5 h-5"></i></a>
                    @endif
                    @if($sekolah_aktif && $sekolah_aktif->whatsapp_sekolah)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sekolah_aktif->whatsapp_sekolah) }}" target="_blank" class="hover:text-green-400"><i data-lucide="message-circle" class="w-5 h-5"></i></a>
                    @endif
                </div>
            </div>
            <!-- Peta Lokasi -->
            <div>
                <h4 class="font-semibold mb-3">Lokasi</h4>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1764.3902966645885!2d112.04691782078015!3d-6.899988206443602!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7797f23ec3d287%3A0xd59e2eb8ccdf57d3!2sSMK%20Abdi%20Negara%20Tuban!5e0!3m2!1sid!2sid!4v1749376571482!5m2!1sid!2sid"
                    width="100%" height="120" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        <div class="text-center text-xs text-gray-400 mt-8">
            &copy;  {{ $sekolah_aktif ? $sekolah_aktif->nama_sekolah : 'Sekolah' }} {{ date('Y') }}
        </div>
    </footer>