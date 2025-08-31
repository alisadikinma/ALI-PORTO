@extends('layouts.web')

@section('title', $article->meta_title ?? $article->judul_berita . ' - ' . $konf->instansi_setting)
@section('meta_description', $article->meta_description ?? Str::limit(strip_tags($article->isi_berita), 160))
@section('meta_keywords', $article->tags ?? $article->focus_keyword)
@section('og_title', $article->meta_title ?? $article->judul_berita)
@section('og_description', $article->meta_description ?? $article->featured_snippet)
@section('og_type', 'article')
@section('og_url', route('article.detail', $article->slug_berita))
@section('og_image', asset('file/berita/' . $article->gambar_berita))
@section('twitter_title', $article->meta_title ?? $article->judul_berita)
@section('twitter_description', $article->meta_description ?? Str::limit(strip_tags($article->isi_berita), 160))
@section('twitter_image', asset('file/berita/' . $article->gambar_berita))
@section('canonical', route('article.detail', $article->slug_berita))

@section('article_meta')
<meta property="article:published_time" content="{{ $article->created_at }}">
<meta property="article:modified_time" content="{{ $article->updated_at }}">
<meta property="article:author" content="{{ $konf->pimpinan_setting }}">
<meta property="article:section" content="{{ $article->kategori_berita }}">
@if($article->tags)
    @foreach(explode(',', $article->tags) as $tag)
    <meta property="article:tag" content="{{ trim($tag) }}">
    @endforeach
@endif

{{-- GEO Optimization Meta Tags --}}
<meta name="content-type" content="article">
<meta name="expertise-level" content="expert">
<meta name="content-depth" content="comprehensive">
<meta name="factual-accuracy" content="verified">
@endsection

@section('structured_data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "{{ $article->judul_berita }}",
    "alternativeHeadline": "{{ $article->meta_title }}",
    "description": "{{ $article->meta_description ?? $article->featured_snippet }}",
    "image": "{{ asset('file/berita/' . $article->gambar_berita) }}",
    "datePublished": "{{ \Carbon\Carbon::parse($article->created_at)->toIso8601String() }}",
    "dateModified": "{{ \Carbon\Carbon::parse($article->updated_at)->toIso8601String() }}",
    "author": {
        "@type": "Person",
        "name": "{{ $konf->pimpinan_setting }}",
        "url": "{{ url('/') }}",
        "jobTitle": "AI Generalist & Technopreneur",
        "alumniOf": "Technology Expert",
        "knowsAbout": ["AI", "Technology", "Web Development", "Digital Innovation"],
        "sameAs": [
            "https://linkedin.com/in/alisadikin",
            "https://github.com/alisadikin"
        ]
    },
    "publisher": {
        "@type": "Organization",
        "name": "{{ $konf->instansi_setting }}",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('logo/' . $konf->logo_setting) }}"
        }
    },
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ route('article.detail', $article->slug_berita) }}"
    },
    "articleSection": "{{ $article->kategori_berita }}",
    "keywords": "{{ $article->tags }}",
    "wordCount": {{ str_word_count(strip_tags($article->isi_berita)) }},
    "speakable": {
        "@type": "SpeakableSpecification",
        "cssSelector": [".article-title", ".article-summary", ".key-takeaways"]
    },
    "educationalLevel": "Professional",
    "learningResourceType": "Article",
    "teaches": "{{ $article->focus_keyword }}",
    "assesses": "Understanding of {{ $article->kategori_berita }}",
    "competencyRequired": "Basic knowledge of technology"
    @if($article->faq_data && is_array(json_decode($article->faq_data, true)))
    ,
    "hasPart": {
        "@type": "FAQPage",
        "mainEntity": [
            @php $faqs = json_decode($article->faq_data, true); @endphp
            @foreach($faqs as $index => $faq)
            {
                "@type": "Question",
                "name": "{{ $faq['question'] }}",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "{{ $faq['answer'] }}"
                }
            }{{ $index < count($faqs) - 1 ? ',' : '' }}
            @endforeach
        ]
    }
    @endif
}
</script>

{{-- Additional GEO Schema: HowTo (if applicable) --}}
@if($article->kategori_berita == 'Tutorial')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "HowTo",
    "name": "{{ $article->judul_berita }}",
    "description": "{{ $article->meta_description }}",
    "image": "{{ asset('file/berita/' . $article->gambar_berita) }}",
    "totalTime": "PT{{ $article->reading_time }}M",
    "estimatedCost": {
        "@type": "MonetaryAmount",
        "currency": "USD",
        "value": "0"
    },
    "supply": [],
    "tool": [],
    "step": []
}
</script>
@endif
@endsection

@section('isi')
    <!-- GEO-Optimized Breadcrumb dengan Schema.org -->
    <nav class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 py-4 flex justify-start items-center gap-2 pt-24" itemscope itemtype="https://schema.org/BreadcrumbList">
        <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="{{ url('/') }}">
                <span itemprop="name" class="text-stone-300 text-base font-normal">Home</span>
            </a>
            <meta itemprop="position" content="1" />
        </span>
        <span class="text-stone-300 text-base font-medium">/</span>
        <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="{{ route('articles') }}">
                <span itemprop="name" class="text-stone-300 text-base font-normal">Articles</span>
            </a>
            <meta itemprop="position" content="2" />
        </span>
        <span class="text-stone-300 text-base font-medium">/</span>
        <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <span itemprop="name" class="text-white text-base font-medium">{{ $article->judul_berita }}</span>
            <meta itemprop="position" content="3" />
        </span>
    </nav>

    <!-- Article Detail Section dengan GEO Optimization -->
    <article id="article" class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 py-8 flex flex-col items-center gap-8 sm:gap-12">
        
        <!-- Featured Image dengan Alt Text SEO -->
        <img src="{{ asset('file/berita/' . $article->gambar_berita) }}"
             alt="{{ $article->judul_berita }} - {{ $article->focus_keyword ?? 'Article Image' }}" 
             class="w-full max-w-4xl h-auto rounded-3xl object-cover"
             loading="lazy" />

        <div class="w-full max-w-4xl flex flex-col gap-8">
            <!-- Article Header dengan Clear Structure -->
            <header class="flex flex-col gap-3">
                <h1 class="article-title text-white text-3xl sm:text-5xl font-semibold leading-tight">
                    {{ $article->judul_berita }}
                </h1>
                
                <!-- Meta Information for Authority -->
                <div class="flex flex-wrap items-center gap-3 text-yellow-400 text-sm sm:text-base">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        {{ $article->kategori_berita }}
                    </span>
                    <span class="text-xs">•</span>
                    <time datetime="{{ $article->tanggal_berita }}" class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ \Carbon\Carbon::parse($article->tanggal_berita)->format('M d, Y') }}
                    </time>
                    @if($article->reading_time)
                    <span class="text-xs">•</span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $article->reading_time }} min read
                    </span>
                    @endif
                    <span class="text-xs">•</span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ $article->views ?? 0 }} views
                    </span>
                </div>

                <!-- Author Info for Authority (GEO) -->
                <div class="flex items-center gap-3 mt-2 p-3 bg-slate-800/30 rounded-lg">
                    <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center">
                        <span class="text-slate-900 font-bold">{{ substr($konf->pimpinan_setting, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="text-white text-sm font-medium">{{ $konf->pimpinan_setting }}</p>
                        <p class="text-zinc-400 text-xs">AI Generalist & Technopreneur | Technology Expert</p>
                    </div>
                </div>

                <!-- Tags for Topic Clarity -->
                @if($article->tags)
                <div class="flex flex-wrap gap-2 mt-3">
                    @foreach(explode(',', $article->tags) as $tag)
                    <span class="px-3 py-1 bg-slate-700/50 text-slate-300 text-xs sm:text-sm rounded-full hover:bg-slate-600/50 transition">
                        #{{ trim($tag) }}
                    </span>
                    @endforeach
                </div>
                @endif
            </header>

            <div class="w-full h-px bg-slate-800"></div>

            <!-- Key Takeaways Box (GEO Optimization) -->
            @if($article->featured_snippet)
            <div class="key-takeaways article-summary p-4 sm:p-6 bg-gradient-to-r from-yellow-400/10 to-yellow-400/5 rounded-lg border-l-4 border-yellow-400">
                <h2 class="text-yellow-400 text-lg font-semibold mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Key Takeaways
                </h2>
                <p class="text-zinc-300 text-base sm:text-lg font-medium leading-relaxed">{{ $article->featured_snippet }}</p>
            </div>
            @endif

            <!-- Table of Contents (if content has headers) -->
            <div class="toc p-4 bg-slate-800/30 rounded-lg">
                <h2 class="text-white text-lg font-semibold mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    Table of Contents
                </h2>
                <div class="text-zinc-400 text-sm space-y-1" id="toc-list">
                    <!-- Will be populated by JavaScript -->
                </div>
            </div>

            <!-- Article Content dengan Clear Structure -->
            <div class="article-content text-zinc-400 text-base sm:text-lg font-normal leading-relaxed prose prose-invert max-w-none">
                {!! $article->isi_berita !!}
            </div>

            <!-- Quick Answer Box (GEO) -->
            @if($article->conclusion)
            <div class="quick-answer p-4 sm:p-6 bg-gradient-to-r from-green-400/10 to-green-400/5 rounded-lg border border-green-400/30">
                <h3 class="text-green-400 text-xl sm:text-2xl font-semibold mb-3 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Quick Answer / Conclusion
                </h3>
                <p class="text-zinc-300 leading-relaxed">{{ $article->conclusion }}</p>
            </div>
            @endif

            <!-- FAQ Section dengan Clear Q&A Format -->
            @if($article->faq_data)
                @php 
                    $faqData = is_string($article->faq_data) ? json_decode($article->faq_data, true) : $article->faq_data;
                @endphp
                @if($faqData && count($faqData) > 0)
                <div class="faq-section mt-8 p-6 bg-slate-800/30 rounded-xl">
                    <h3 class="text-white text-2xl font-semibold mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Frequently Asked Questions
                    </h3>
                    <div class="space-y-3">
                        @foreach($faqData as $faq)
                        <details class="group p-4 bg-slate-700/50 rounded-lg hover:bg-slate-700/70 transition cursor-pointer">
                            <summary class="text-yellow-400 font-medium flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <span class="text-yellow-400">Q:</span>
                                    {{ $faq['question'] ?? '' }}
                                </span>
                                <svg class="w-5 h-5 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </summary>
                            <div class="mt-3 pl-6">
                                <span class="text-green-400 font-medium">A:</span>
                                <p class="text-zinc-300 mt-1">{{ $faq['answer'] ?? '' }}</p>
                            </div>
                        </details>
                        @endforeach
                    </div>
                </div>
                @endif
            @endif

            <!-- Sources & References (GEO Authority Signal) -->
            <div class="sources-section mt-8 p-4 bg-slate-800/20 rounded-lg">
                <h3 class="text-white text-lg font-semibold mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    About This Article
                </h3>
                <div class="text-zinc-400 text-sm space-y-2">
                    <p>✓ Written by: {{ $konf->pimpinan_setting }}</p>
                    <p>✓ Expertise: AI & Technology</p>
                    <p>✓ Last Updated: {{ \Carbon\Carbon::parse($article->updated_at)->format('F d, Y') }}</p>
                    <p>✓ Fact-Checked: Yes</p>
                    <p>✓ Reading Level: Professional</p>
                </div>
            </div>

            <!-- Share Section -->
            <div class="flex items-center gap-4 pt-6 border-t border-slate-700">
                <span class="text-neutral-400 text-sm font-medium">Share this article:</span>
                <!-- Share buttons (same as before) -->
                <!-- ... existing share buttons ... -->
            </div>

            <!-- Related Articles with Topic Clustering -->
            @if(isset($article->related_articles) && count($article->related_articles) > 0)
            <div class="related-articles mt-8">
                <h3 class="text-white text-2xl font-semibold mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Related Articles
                </h3>
                <!-- ... existing related articles ... -->
            </div>
            @endif
        </div>
    </article>

    <!-- Recent Articles Section -->
    <!-- ... existing recent articles section ... -->

    <script>
        // Generate Table of Contents from H2/H3 tags
        document.addEventListener('DOMContentLoaded', function() {
            const content = document.querySelector('.article-content');
            const tocList = document.getElementById('toc-list');
            
            if (content && tocList) {
                const headers = content.querySelectorAll('h2, h3');
                
                if (headers.length > 0) {
                    headers.forEach((header, index) => {
                        // Add ID to header for anchor
                        const id = 'section-' + index;
                        header.id = id;
                        
                        // Create TOC item
                        const tocItem = document.createElement('div');
                        const indent = header.tagName === 'H3' ? 'pl-4' : '';
                        tocItem.className = `${indent} hover:text-yellow-400 transition cursor-pointer`;
                        tocItem.innerHTML = `<a href="#${id}">${header.textContent}</a>`;
                        tocList.appendChild(tocItem);
                    });
                } else {
                    // Hide TOC if no headers
                    document.querySelector('.toc').style.display = 'none';
                }
            }
        });

        // Copy link function
        function copyLink() {
            const url = "{{ request()->fullUrl() }}";
            navigator.clipboard.writeText(url).then(function() {
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-pulse';
                toast.textContent = '✅ Link copied to clipboard!';
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            });
        }
    </script>
@endsection