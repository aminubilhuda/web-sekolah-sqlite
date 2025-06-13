<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }

        .action-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0d6efd;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 0.9em;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Pendaftaran PPDB Baru</h2>
    </div>

    <div class="content">
        <p>Halo Admin,</p>

        <p>Ada pendaftaran PPDB baru yang memerlukan verifikasi:</p>

        <p><strong>Detail Pendaftar:</strong></p>
        <ul>
            <li>Nomor Registrasi: {{ $ppdb->nomor_registrasi }}</li>
            <li>Nama: {{ $ppdb->nama_lengkap }}</li>
            <li>NISN: {{ $ppdb->nisn }}</li>
            <li>NIK: {{ $ppdb->nik }}</li>
            <li>Email: {{ $ppdb->email }}</li>
            <li>Telepon: {{ $ppdb->telepon }}</li>
            <li>Jurusan: {{ $ppdb->jurusan->nama_jurusan }}</li>
            <li>Jalur: {{ $ppdb->jalur }}</li>
            <li>Gelombang: {{ $ppdb->gelombang }}</li>
            <li>Sekolah Asal: {{ $ppdb->sekolah_asal }}</li>
        </ul>

        <p>Silakan login ke panel admin untuk memverifikasi pendaftaran ini.</p>

        <a href="{{ route('filament.admin.auth.login') }}" class="action-button">
            Buka Panel Admin
        </a>
    </div>

    <div class="footer">
        <p>Email ini dikirim secara otomatis oleh sistem PPDB {{ config('app.name') }}.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>

</html>
