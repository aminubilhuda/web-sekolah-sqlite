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

        .registration-number {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
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
        <h2>Pendaftaran PPDB Berhasil</h2>
    </div>

    <div class="content">
        <p>Yth. {{ $ppdb->nama_lengkap }},</p>

        <p>Terima kasih telah mendaftar di {{ config('app.name') }}. Pendaftaran Anda telah berhasil diproses.</p>

        <div class="registration-number">
            <strong>Nomor Registrasi:</strong><br>
            {{ $ppdb->nomor_registrasi }}
        </div>

        <p><strong>Detail Pendaftaran:</strong></p>
        <ul>
            <li>Nama: {{ $ppdb->nama_lengkap }}</li>
            <li>NISN: {{ $ppdb->nisn }}</li>
            <li>Jurusan: {{ $ppdb->jurusan->nama_jurusan }}</li>
            <li>Jalur: {{ $ppdb->jalur }}</li>
            <li>Gelombang: {{ $ppdb->gelombang }}</li>
        </ul>

        <p>Langkah selanjutnya:</p>
        <ol>
            <li>Simpan nomor registrasi Anda</li>
            <li>Pantau status pendaftaran Anda melalui website kami</li>
            <li>Tunggu informasi selanjutnya dalam 2-3 hari kerja</li>
        </ol>
    </div>

    <div class="footer">
        <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>

</html>
