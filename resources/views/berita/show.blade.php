@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Header Section -->
    <header class="relative">
        @if($berita->gambar)
            <div class="relative h-[60vh] w-full">
                <img src="{{ asset('storage/' . $berita->gambar) }}" 
                    alt="{{ $berita->judul }}"
                    class="w-full h-full object-cover" />
                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/30 to-transparent"></div>
            </div>
        @endif
        <div class="absolute bottom-0 left-0 right-0 p-8">
            <div class="max-w-4xl mx-auto">
                <div class="inline-block bg-white/90 backdrop-blur-sm px-4 py-2 rounded-lg mb-4">
                    <span class="text-sm font-medium text-gray-900">{{ $berita->kategori }}</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
                    {{ $berita->judul }}
                </h1>
                <div class="flex items-center space-x-6 text-white/90">
                    <div class="flex items-center space-x-2">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                        <span class="text-sm">{{ \Carbon\Carbon::parse($berita->tanggal_publish)->format('d F Y') }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span class="text-sm">{{ $berita->penulis }}</span>
                    </div>
                    @if($berita->headline == 'Yes')
                    <div class="flex items-center space-x-2">
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400"></i>
                        <span class="text-sm">Headline</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Content Section -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <article class="prose prose-lg max-w-none [&>h1]:text-4xl [&>h1]:font-bold [&>h1]:mb-6 [&>h2]:text-3xl [&>h2]:font-bold [&>h2]:mt-8 [&>h2]:mb-4 [&>h3]:text-2xl [&>h3]:font-bold [&>h3]:mt-6 [&>h3]:mb-3 [&>p]:text-lg [&>p]:text-gray-700 [&>p]:mb-4 [&>ul]:list-disc [&>ul]:pl-6 [&>ul]:mb-4 [&>ul>li]:text-lg [&>ul>li]:text-gray-700 [&>strong]:font-bold [&>strong]:text-gray-900 [&>em]:italic [&>em]:text-gray-700">
            {!! $berita->isi !!}
        </article>

        <!-- Share Section -->
        <div class="mt-16 border-t border-gray-100 pt-8">
            <div class="flex flex-col items-center">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Bagikan Berita Ini</h3>
                <div class="flex items-center space-x-4">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                       target="_blank"
                       class="group relative">
                        <div class="w-12 h-12 bg-[#1877F2] rounded-full flex items-center justify-center transition-transform group-hover:scale-110">
                            <i data-lucide="facebook" class="w-6 h-6 text-white"></i>
                        </div>
                        <span class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-xs text-gray-500 opacity-0 group-hover:opacity-100 transition-opacity">Facebook</span>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}" 
                       target="_blank"
                       class="group relative">
                        <div class="w-12 h-12 bg-[#1DA1F2] rounded-full flex items-center justify-center transition-transform group-hover:scale-110">
                            <i data-lucide="twitter" class="w-6 h-6 text-white"></i>
                        </div>
                        <span class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-xs text-gray-500 opacity-0 group-hover:opacity-100 transition-opacity">Twitter</span>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . request()->url()) }}" 
                       target="_blank"
                       class="group relative">
                        <div class="w-12 h-12 bg-[#25D366] rounded-full flex items-center justify-center transition-transform group-hover:scale-110">
                            <i data-lucide="whatsapp" class="w-6 h-6 text-white"></i>
                        </div>
                        <span class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-xs text-gray-500 opacity-0 group-hover:opacity-100 transition-opacity">WhatsApp</span>
                    </a>
                    <button onclick="copyToClipboard('{{ request()->url() }}')" 
                            class="group relative">
                        <div class="w-12 h-12 bg-gray-900 rounded-full flex items-center justify-center transition-transform group-hover:scale-110">
                            <i data-lucide="link" class="w-6 h-6 text-white"></i>
                        </div>
                        <span class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-xs text-gray-500 opacity-0 group-hover:opacity-100 transition-opacity">Copy Link</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Related News -->
        <div class="mt-16 border-t border-gray-100 pt-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Berita Terkait</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($relatedNews as $related)
                <a href="{{ route('berita.show', $related->slug) }}" class="group">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                        @if($related->gambar)
                        <div class="relative h-48">
                            <img src="{{ asset('storage/' . $related->gambar) }}" 
                                alt="{{ $related->judul }}"
                                class="w-full h-full object-cover" />
                        </div>
                        @endif
                        <div class="p-4">
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="text-sm font-medium text-blue-600">{{ $related->kategori }}</span>
                                <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($related->tanggal_publish)->format('d M Y') }}</span>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                {{ $related->judul }}
                            </h4>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Navigation -->
        <div class="mt-16 flex items-center justify-between">
            @if($previousNews)
            <a href="{{ route('berita.show', $previousNews->slug) }}"
                class="group inline-flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors">
                <div class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center group-hover:border-gray-300 transition-colors">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </div>
                <div class="text-right">
                    <span class="text-sm text-gray-500">Berita Sebelumnya</span>
                    <p class="font-medium">{{ Str::limit($previousNews->judul, 30) }}</p>
                </div>
            </a>
            @else
            <div></div>
            @endif

            @if($nextNews)
            <a href="{{ route('berita.show', $nextNews->slug) }}" 
                class="group inline-flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors">
                <div class="text-left">
                    <span class="text-sm text-gray-500">Berita Selanjutnya</span>
                    <p class="font-medium">{{ Str::limit($nextNews->judul, 30) }}</p>
                </div>
                <div class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center group-hover:border-gray-300 transition-colors">
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </div>
            </a>
            @endif
        </div>
    </main>
</div>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transform transition-all duration-300 translate-y-0 opacity-100';
        toast.textContent = 'Link berhasil disalin!';
        document.body.appendChild(toast);

        // Remove toast after 3 seconds
        setTimeout(() => {
            toast.classList.add('translate-y-2', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    });
}
</script>
@endpush
@endsection 