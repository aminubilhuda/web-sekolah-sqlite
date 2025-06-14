@extends('layouts.app')

@section('title', 'Galeri')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" />
<style>
    .galeri-card {
        background: linear-gradient(135deg, #f8fafc 60%, #e0e7ff 100%);
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        transition: box-shadow 0.3s, transform 0.3s;
        overflow: hidden;
        border: 1.5px solid #e0e7ff;
    }
    .galeri-card:hover {
        box-shadow: 0 16px 40px 0 rgba(99, 102, 241, 0.18);
        transform: translateY(-6px) scale(1.03);
    }
    .galeri-img-frame {
        background: linear-gradient(120deg, #6366f1 0%, #a5b4fc 100%);
        padding: 8px;
        border-radius: 1rem;
        margin-bottom: 0.5rem;
        box-shadow: 0 2px 12px 0 rgba(99, 102, 241, 0.10);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .galeri-img {
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px 0 rgba(99, 102, 241, 0.10);
        transition: transform 0.3s;
        object-fit: cover;
        aspect-ratio: 1/1;
        width: 100%;
        height: 220px;
        background: #f3f4f6;
    }
    .galeri-img:hover {
        transform: scale(1.07) rotate(-1deg);
    }
    .galeri-badge {
        background: linear-gradient(90deg, #6366f1 60%, #818cf8 100%);
        color: #fff;
        font-weight: 600;
        border-radius: 9999px;
        padding: 0.25rem 1rem;
        font-size: 0.8rem;
        letter-spacing: 0.05em;
        box-shadow: 0 1px 4px 0 rgba(99, 102, 241, 0.10);
    }
</style>
<div class="container py-8">
    <h1 class="text-4xl font-extrabold mb-10 text-center text-indigo-700 tracking-tight drop-shadow-lg">Galeri Sekolah</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
        @foreach($galeris as $galeri)
            <div class="galeri-card">
                @if($galeri->kategori === 'foto')
                    <div class="flex flex-wrap gap-2 justify-center p-3">
                        @if(is_array($galeri->gambar))
                            @foreach($galeri->gambar as $img)
                                <div class="galeri-img-frame w-full">
                                    <a href="{{ asset('storage/' . $img) }}" data-lightbox="galeri-{{ $galeri->id_galeri }}" data-title="{{ $galeri->judul }}">
                                        <img src="{{ asset('storage/' . $img) }}" alt="{{ $galeri->judul }}" class="galeri-img" />
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="galeri-img-frame w-full">
                                <a href="{{ asset('storage/' . $galeri->gambar) }}" data-lightbox="galeri-{{ $galeri->id_galeri }}" data-title="{{ $galeri->judul }}">
                                    <img src="{{ asset('storage/' . $galeri->gambar) }}" alt="{{ $galeri->judul }}" class="galeri-img" />
                                </a>
                            </div>
                        @endif
                    </div>
                @elseif($galeri->kategori === 'video' && $galeri->url_video)
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe src="{{ $galeri->url_video }}" frameborder="0" allowfullscreen class="w-full h-48 rounded-xl shadow"></iframe>
                    </div>
                @endif
                <div class="p-5 pb-6">
                    <h2 class="text-xl font-bold text-indigo-800 mb-2 leading-tight">{{ $galeri->judul }}</h2>
                    <p class="text-gray-600 mb-3 text-sm">{{ $galeri->deskripsi }}</p>
                    <span class="galeri-badge">{{ ucfirst($galeri->kategori) }}</span>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-10 flex justify-center">
        {{ $galeris->links() }}
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
@endsection
