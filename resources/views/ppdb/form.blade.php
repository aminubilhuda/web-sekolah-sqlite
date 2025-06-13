@extends('layouts.app')
@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Formulir Pendaftaran PPDB</h2>
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
        @endif
        <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <label for="nama_lengkap" class="block text-gray-700 font-bold mb-2">Nama Lengkap *</label>
                        <input type="text" name="nama_lengkap"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_lengkap') border-red-500 @enderror"
                            value="{{ old('nama_lengkap') }}">
                        @error('nama_lengkap')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="nisn" class="block text-gray-700 font-bold mb-2">NISN *</label>
                        <input type="text" name="nisn"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nisn') border-red-500 @enderror"
                            value="{{ old('nisn') }}">
                        @error('nisn')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="nik" class="block text-gray-700 font-bold mb-2">NIK *</label>
                        <input type="text" name="nik"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nik') border-red-500 @enderror"
                            value="{{ old('nik') }}">
                        @error('nik')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="jenis_kelamin" class="block text-gray-700 font-bold mb-2">Jenis Kelamin *</label>
                        <select name="jenis_kelamin"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('jenis_kelamin') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="tempat_lahir" class="block text-gray-700 font-bold mb-2">Tempat Lahir *</label>
                        <input type="text" name="tempat_lahir"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tempat_lahir') border-red-500 @enderror"
                            value="{{ old('tempat_lahir') }}">
                        @error('tempat_lahir')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="tanggal_lahir" class="block text-gray-700 font-bold mb-2">Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tanggal_lahir') border-red-500 @enderror"
                            value="{{ old('tanggal_lahir') }}">
                        @error('tanggal_lahir')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="agama" class="block text-gray-700 font-bold mb-2">Agama *</label>
                        <input type="text" name="agama"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('agama') border-red-500 @enderror"
                            value="{{ old('agama') }}">
                        @error('agama')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="alamat" class="block text-gray-700 font-bold mb-2">Alamat *</label>
                        <textarea name="alamat"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="kode_pos" class="block text-gray-700 font-bold mb-2">Kode Pos</label>
                        <input type="text" name="kode_pos"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('kode_pos') border-red-500 @enderror"
                            value="{{ old('kode_pos') }}">
                        @error('kode_pos')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="telepon" class="block text-gray-700 font-bold mb-2">Telepon</label>
                        <input type="text" name="telepon"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('telepon') border-red-500 @enderror"
                            value="{{ old('telepon') }}">
                        @error('telepon')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                        <input type="email" name="email"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                            value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <div class="mb-4">
                        <label for="nama_ayah" class="block text-gray-700 font-bold mb-2">Nama Ayah *</label>
                        <input type="text" name="nama_ayah"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_ayah') border-red-500 @enderror"
                            value="{{ old('nama_ayah') }}">
                        @error('nama_ayah')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="pekerjaan_ayah" class="block text-gray-700 font-bold mb-2">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('pekerjaan_ayah') border-red-500 @enderror"
                            value="{{ old('pekerjaan_ayah') }}">
                        @error('pekerjaan_ayah')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="telepon_ayah" class="block text-gray-700 font-bold mb-2">Telepon Ayah</label>
                        <input type="text" name="telepon_ayah"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('telepon_ayah') border-red-500 @enderror"
                            value="{{ old('telepon_ayah') }}">
                        @error('telepon_ayah')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="nama_ibu" class="block text-gray-700 font-bold mb-2">Nama Ibu *</label>
                        <input type="text" name="nama_ibu"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_ibu') border-red-500 @enderror"
                            value="{{ old('nama_ibu') }}">
                        @error('nama_ibu')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="pekerjaan_ibu" class="block text-gray-700 font-bold mb-2">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('pekerjaan_ibu') border-red-500 @enderror"
                            value="{{ old('pekerjaan_ibu') }}">
                        @error('pekerjaan_ibu')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="telepon_ibu" class="block text-gray-700 font-bold mb-2">Telepon Ibu</label>
                        <input type="text" name="telepon_ibu"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('telepon_ibu') border-red-500 @enderror"
                            value="{{ old('telepon_ibu') }}">
                        @error('telepon_ibu')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="sekolah_asal" class="block text-gray-700 font-bold mb-2">Sekolah Asal *</label>
                        <input type="text" name="sekolah_asal"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('sekolah_asal') border-red-500 @enderror"
                            value="{{ old('sekolah_asal') }}">
                        @error('sekolah_asal')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="id_jurusan" class="block text-gray-700 font-bold mb-2">Jurusan *</label>
                        <select name="id_jurusan"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('id_jurusan') border-red-500 @enderror">
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach ($jurusans as $jurusan)
                                <option value="{{ $jurusan->id_jurusan }}"
                                    {{ old('id_jurusan') == $jurusan->id_jurusan ? 'selected' : '' }}>
                                    {{ $jurusan->nama_jurusan }}</option>
                            @endforeach
                        </select>
                        @error('id_jurusan')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="gelombang" class="block text-gray-700 font-bold mb-2">Gelombang *</label>
                        <select name="gelombang"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('gelombang') border-red-500 @enderror">
                            <option value="">-- Pilih Gelombang --</option>
                            <option value="1" {{ old('gelombang') == '1' ? 'selected' : '' }}>1</option>
                            <option value="2" {{ old('gelombang') == '2' ? 'selected' : '' }}>2</option>
                            <option value="3" {{ old('gelombang') == '3' ? 'selected' : '' }}>3</option>
                        </select>
                        @error('gelombang')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="jalur" class="block text-gray-700 font-bold mb-2">Jalur *</label>
                        <select name="jalur"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('jalur') border-red-500 @enderror">
                            <option value="">-- Pilih Jalur --</option>
                            <option value="Reguler" {{ old('jalur') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                            <option value="Prestasi" {{ old('jalur') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                            <option value="Tidak Mampu" {{ old('jalur') == 'Tidak Mampu' ? 'selected' : '' }}>Tidak Mampu
                            </option>
                        </select>
                        @error('jalur')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="prestasi" class="block text-gray-700 font-bold mb-2">Prestasi</label>
                        <textarea name="prestasi"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('prestasi') border-red-500 @enderror">{{ old('prestasi') }}</textarea>
                        @error('prestasi')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="foto" class="block text-gray-700 font-bold mb-2">Foto (jpg/png, max 2MB) *</label>
                    <label
                        class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue-600 rounded-lg shadow-lg tracking-wide border border-blue-500 cursor-pointer hover:bg-blue-50 transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        <span class="mt-2 text-base leading-normal">Pilih file</span>
                        <input type="file" name="foto" class="hidden @error('foto') border-red-500 @enderror">
                    </label>
                    @error('foto')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="ijazah" class="block text-gray-700 font-bold mb-2">Ijazah (pdf/jpg/png, max 2MB)
                        *</label>
                    <label
                        class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue-600 rounded-lg shadow-lg tracking-wide border border-blue-500 cursor-pointer hover:bg-blue-50 transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        <span class="mt-2 text-base leading-normal">Pilih file</span>
                        <input type="file" name="ijazah" class="hidden @error('ijazah') border-red-500 @enderror">
                    </label>
                    @error('ijazah')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="skhun" class="block text-gray-700 font-bold mb-2">SKHUN (pdf/jpg/png, max 2MB)
                        *</label>
                    <label
                        class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue-600 rounded-lg shadow-lg tracking-wide border border-blue-500 cursor-pointer hover:bg-blue-50 transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        <span class="mt-2 text-base leading-normal">Pilih file</span>
                        <input type="file" name="skhun" class="hidden @error('skhun') border-red-500 @enderror">
                    </label>
                    @error('skhun')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="kartu_keluarga" class="block text-gray-700 font-bold mb-2">Kartu Keluarga (pdf/jpg/png,
                        max 2MB) *</label>
                    <label
                        class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue-600 rounded-lg shadow-lg tracking-wide border border-blue-500 cursor-pointer hover:bg-blue-50 transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        <span class="mt-2 text-base leading-normal">Pilih file</span>
                        <input type="file" name="kartu_keluarga"
                            class="hidden @error('kartu_keluarga') border-red-500 @enderror">
                    </label>
                    @error('kartu_keluarga')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="akta_kelahiran" class="block text-gray-700 font-bold mb-2">Akta Kelahiran (pdf/jpg/png,
                        max 2MB) *</label>
                    <label
                        class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue-600 rounded-lg shadow-lg tracking-wide border border-blue-500 cursor-pointer hover:bg-blue-50 transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        <span class="mt-2 text-base leading-normal">Pilih file</span>
                        <input type="file" name="akta_kelahiran"
                            class="hidden @error('akta_kelahiran') border-red-500 @enderror">
                    </label>
                    @error('akta_kelahiran')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="surat_prestasi" class="block text-gray-700 font-bold mb-2">Surat Prestasi (pdf/jpg/png,
                        max 2MB)</label>
                    <label
                        class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue-600 rounded-lg shadow-lg tracking-wide border border-blue-500 cursor-pointer hover:bg-blue-50 transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        <span class="mt-2 text-base leading-normal">Pilih file</span>
                        <input type="file" name="surat_prestasi"
                            class="hidden @error('surat_prestasi') border-red-500 @enderror">
                    </label>
                    @error('surat_prestasi')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="surat_tidak_mampu" class="block text-gray-700 font-bold mb-2">Surat Tidak Mampu
                        (pdf/jpg/png, max 2MB)</label>
                    <label
                        class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue-600 rounded-lg shadow-lg tracking-wide border border-blue-500 cursor-pointer hover:bg-blue-50 transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        <span class="mt-2 text-base leading-normal">Pilih file</span>
                        <input type="file" name="surat_tidak_mampu"
                            class="hidden @error('surat_tidak_mampu') border-red-500 @enderror">
                    </label>
                    @error('surat_tidak_mampu')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-8 text-center">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded focus:outline-none focus:shadow-outline">Daftar</button>
            </div>
        </form>
    </div>
@endsection
