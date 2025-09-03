@extends('layouts.web')

@section('title', 'Articles - Ali Sadikin')

@push('styles')
<style>
    /* CSS khusus articles */
    .outline-offset--1 { outline-offset: -1px; }
</style>
@endpush

@section('isi')
<section id="articles" class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 py-8 pt-24 flex flex-col items-center gap-8 sm:gap-14">
    <div class="flex flex-col gap-3 text-center">
        <h2 class="text-yellow-400 text-3xl sm:text-5xl font-extrabold leading-tight sm:leading-[56px]">
            All Articles
        </h2>
        <p class="text-neutral-400 text-lg sm:text-2xl font-normal leading-6 sm:leading-7 tracking-tight">
            Explore our collection of insights on AI, technology, and innovation
        </p>
    </div>

    <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @foreach ($articles as $article)
            <div class="p-6 sm:p-9 bg-slate-800 rounded-xl outline outline-1 outline-blue-950 outline-offset--1 flex flex-col gap-4 sm:gap-6">
                <img src="{{ !empty($article->gambar_berita) ? asset('file/berita/' . $article->gambar_berita) : asset('file/berita/placeholder.png') }}"
                     alt="{{ $article->judul_berita }} thumbnail"
                     class="w-full h-auto rounded-xl object-cover aspect-[4/3]" />
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <span class="text-slate-600 text-sm sm:text-base font-medium leading-normal">
                                {{ \Carbon\Carbon::parse($article->tanggal_berita)->format('M d, Y') }}
                            </span>
                            <div class="px-2 sm:px-3 py-1 sm:py-2 bg-yellow-400/10 rounded-sm">
                                <span class="text-yellow-400 text-xs font-medium font-['Fira_Sans'] uppercase leading-3">
                                    {{ $article->kategori_berita ?? 'AI & Tech' }}
                                </span>
                            </div>
                        </div>
                        <h3 class="text-white text-base sm:text-xl font-bold leading-6 sm:leading-7">
                            {{ $article->judul_berita }}
                        </h3>
                    </div>
                    <p class="text-slate-500 text-sm sm:text-base font-medium leading-normal">
                        {!! \Illuminate\Support\Str::limit(strip_tags($article->isi_berita), 150, '...') !!}
                        @if (strlen(strip_tags($article->isi_berita)) > 150)
                            <a href="{{ route('article.detail', $article->slug_berita) }}"
                               class="text-yellow-400 hover:text-yellow-500 font-medium">Read More</a>
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="flex items-center gap-4 sm:gap-8">
        {{-- Prev Button --}}
        @if ($articles->onFirstPage())
            <button class="px-4 sm:px-6 py-3 rounded-xl outline outline-1 outline-neutral-700 opacity-50 cursor-not-allowed"
                    disabled>
                Prev
            </button>
        @else
            <a href="{{ $articles->previousPageUrl() }}" class="px-4 sm:px-6 py-3 rounded-xl outline outline-1 outline-neutral-700">
                Prev
            </a>
        @endif

        {{-- Page Info --}}
        <div class="flex items-center gap-2">
            <span class="text-slate-400">{{ $articles->currentPage() }}</span>
            /
            <span class="text-slate-400">{{ $articles->lastPage() }}</span>
        </div>

        {{-- Next Button --}}
        @if ($articles->hasMorePages())
            <a href="{{ $articles->nextPageUrl() }}" class="px-4 sm:px-6 py-3 rounded-xl outline outline-1 outline-yellow-400 text-yellow-400">
                Next
            </a>
        @else
            <button class="px-4 sm:px-6 py-3 rounded-xl outline outline-1 outline-yellow-400 opacity-50 cursor-not-allowed"
                    disabled>
                Next
            </button>
        @endif
    </div>
</section>
@endsection
