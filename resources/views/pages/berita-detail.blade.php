@extends('layouts.auth')

@section('title', $berita['title'] . ' - FocusOneX Archery')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Breadcrumb -->
    <div class="bg-white border-b mt-20">
        <div class="container mx-auto px-4 py-4">
            <nav>
                <ol class="flex items-center gap-2 text-sm text-gray-600">
                    <li><a href="{{ url('/') }}" class="hover:text-blue-600">Beranda</a></li>
                    <li>/</li>
                    <li><a href="{{ url('/galeri') }}" class="hover:text-blue-600">Galeri</a></li>
                    <li>/</li>
                    <li class="text-gray-800 font-medium">Berita</li>
                </ol>
            </nav>
        </div>
    </div>

<!-- Content Section -->
<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <article class="prose prose-lg max-w-none">
            <!-- Article Header -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                    {{ $berita['title'] }}
                </h1>
                
                <!-- Meta Information -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 pb-6 border-b">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>{{ $berita['author'] }}</span>
                    </div>
                    <span class="text-gray-400">•</span>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $berita['date'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            <img 
                src="{{ $berita['image'] }}" 
                alt="{{ $berita['title'] }}"
                class="w-full h-96 object-cover rounded-2xl shadow-lg mb-8"
            >

            <!-- Content -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                {!! $berita['content'] !!}
            </div>

            <!-- Share Buttons -->
            <div class="bg-gray-50 rounded-2xl p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Bagikan Berita Ini</h4>
                <div class="flex flex-wrap gap-3">
                    <button onclick="shareToFacebook()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center gap-2 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </button>
                </div>
            </div>
        </article>

        <!-- Back Button -->
        <div class="mt-12 text-center">
            <a href="{{ url('/galeri') }}" class="inline-flex items-center gap-2 border border-gray-300 text-gray-700 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Galeri
            </a>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-6xl w-full">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="modalImage" src="" alt="Full size image" class="w-full h-auto rounded-lg">
    </div>
</div>

<script>
// Share Functions
function shareToFacebook() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
}

function shareToTwitter() {
    const title = encodeURIComponent("{{ $berita['title'] }}");
    const url = encodeURIComponent(window.location.href);
    window.open(`https://twitter.com/intent/tweet?text=${title}&url=${url}`, '_blank');
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        alert('Link berhasil disalin!');
    });
}

// Image Modal Functions
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}
</script>
@endsection
