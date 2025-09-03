@extends('layouts.web')

@section('isi')
<!-- Hero Section -->


@if (session('success'))
<div id="successAlert"
    class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 max-w-md w-full mx-auto px-4 py-3 bg-green-600 text-white font-medium rounded-xl shadow-lg flex items-center justify-between gap-4 animate-fade-in">
    <span>{{ session('success') }}</span>
    <button id="closeAlertBtn" class="text-white hover:text-gray-200 focus:outline-none" aria-label="Close alert">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const alert = document.getElementById('successAlert');
        const closeBtn = document.getElementById('closeAlertBtn');

        if (alert && closeBtn) {
            closeBtn.addEventListener('click', () => {
                alert.classList.add('animate-fade-out');
                setTimeout(() => {
                    alert.remove();
                }, 300); // Match the duration of the fade-out animation
            });

            // Auto-dismiss alert after 5 seconds
            setTimeout(() => {
                alert.classList.add('animate-fade-out');
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        }
    });
</script>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translate(-50%, -20px);
        }

        to {
            opacity: 1;
            transform: translate(-50%, 0);
        }
    }

    @keyframes fade-out {
        from {
            opacity: 1;
            transform: translate(-50%, 0);
        }

        to {
            opacity: 0;
            transform: translate(-50%, -20px);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-in-out;
    }

    .animate-fade-out {
        animation: fade-out 0.3s ease-in-out;
    }
</style>

<section id="home"
    class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 py-8 sm:py-14 flex flex-col items-center gap-8 sm:gap-16">
    <div class="w-full flex flex-col sm:flex-row items-center gap-8 sm:gap-32">
        <img src="{{ asset('favicon/' . $konf->favicon_setting) }}" alt="Profile image"
            class="w-full max-w-[300px] sm:max-w-[536px] h-auto rounded-2xl" />
        <div class="flex flex-col gap-6 sm:gap-8">
            <div class="flex flex-col gap-4 sm:gap-6">
                <div class="flex items-center gap-4 sm:gap-6">
                    <div class="w-12 sm:w-20 h-0.5 bg-yellow-400"></div>
                    <div class="text-yellow-400 text-sm sm:text-base font-semibold uppercase leading-normal">
                        {{ $konf->profile_title }}
                    </div>
                </div>
                <h1 class="text-4xl sm:text-7xl font-bold leading-tight sm:leading-[80px] max-w-full sm:max-w-[648px]">
                    Hello bro, I’m<br />{{ $konf->pimpinan_setting }}.
                </h1>
            </div>
            <p class="text-gray-500 text-lg sm:text-2xl font-normal leading-7 sm:leading-9 max-w-full sm:max-w-[648px]">
                {!! $konf->tentang_setting !!}
            </p>

            <div class="flex flex-col sm:flex-row gap-4">
                <a href="#contact" class="px-6 sm:px-8 py-3 sm:py-4 bg-yellow-400 rounded-lg flex items-center gap-3">
                    <span
                        class="text-neutral-900 text-base sm:text-lg font-semibold capitalize leading-[40px] sm:leading-[64px]">
                        Say Hello
                    </span>
                </a>

                <a href="{{ url('portfolio') }}" target="_blank"
                    class="px-6 sm:px-8 py-3 sm:py-4 bg-slate-800/60 rounded-lg outline outline-1 outline-slate-500 flex items-center gap-3">
                    <span
                        class="text-white text-base sm:text-lg font-semibold capitalize leading-[40px] sm:leading-[64px]">
                        View Portfolio
                    </span>
                    <svg class="w-5 sm:w-6 h-5 sm:h-6" fill="white" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" />
                    </svg>
                </a>
            </div>

        </div>
    </div>

    <!-- Stats Section -->
    <!-- Stats Section -->
    <div class="w-full bg-neutral-900/40 flex flex-col items-center gap-4 sm:gap-6 md:gap-8 lg:gap-11">

        <!-- Garis atas -->
        <div class="w-full h-0.5 outline outline-1 outline-neutral-900 outline-offset--1"></div>

        <!-- Grid container -->
        <div class="w-full px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 sm:gap-8">

                <!-- Item 1 -->
                <div class="flex flex-col items-center gap-2 sm:gap-3 md:gap-4 p-4 rounded-2xl">
                    <svg class="w-8 sm:w-10 md:w-12 h-8 sm:h-10 md:h-12" fill="none" stroke="yellow"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <div class="text-yellow-400 text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-center">
                        {{ $konf->years_experience }}
                    </div>
                    <div class="text-neutral-400 text-base sm:text-lg md:text-xl lg:text-2xl font-medium text-center">
                        Years Experience
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex flex-col items-center gap-2 sm:gap-3 md:gap-4 p-4 rounded-2xl">
                    <svg class="w-8 sm:w-10 md:w-12 h-8 sm:h-10 md:h-12" fill="none" stroke="yellow"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 18h-5v-2a3 3 0 015.356-1.857M7 18v-2c0-.656.126-1.283.356-1.857m-5.856 1.857A3 3 0 002 16v2m14 0v2m0 0h5m-5 0h-5m5 0v-2c0-.656-.126-1.283-.356-1.857M16 14c.083-.1.17-.198.268-.295a5.347 5.347 0 00.955-2.019A3.364 3.364 0 0017 11.579c0-1.08.738-1.979 1.678-2.279" />
                    </svg>
                    <div class="text-yellow-400 text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-center">
                        {{ $konf->followers_count }}
                    </div>
                    <div class="text-neutral-400 text-base sm:text-lg md:text-xl lg:text-2xl font-medium text-center">
                        Followers
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="flex flex-col items-center gap-2 sm:gap-3 md:gap-4 p-4 rounded-2xl">
                    <svg class="w-8 sm:w-10 md:w-12 h-8 sm:h-10 md:h-12" fill="none" stroke="yellow"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <div class="text-yellow-400 text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-center">
                        {{ $konf->project_delivered }}
                    </div>
                    <div class="text-neutral-400 text-base sm:text-lg md:text-xl lg:text-2xl font-medium text-center">
                        Projects Delivered
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="flex flex-col items-center gap-2 sm:gap-3 md:gap-4 p-4 rounded-2xl">
                    <svg class="w-8 sm:w-10 md:w-12 h-8 sm:h-10 md:h-12" fill="none" stroke="yellow"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-yellow-400 text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-center">
                        {{ $konf->cost_savings }}
                    </div>
                    <div class="text-neutral-400 text-base sm:text-lg md:text-xl lg:text-2xl font-medium text-center">
                        Cost Savings
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="flex flex-col items-center gap-2 sm:gap-3 md:gap-4 p-4 rounded-2xl">
                    <svg class="w-8 sm:w-10 md:w-12 h-8 sm:h-10 md:h-12" fill="none" stroke="yellow"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <div class="text-yellow-400 text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-center">
                        {{ $konf->success_rate }}
                    </div>
                    <div class="text-neutral-400 text-base sm:text-lg md:text-xl lg:text-2xl font-medium text-center">
                        Success Rate
                    </div>
                </div>

            </div>
        </div>

        <!-- Garis bawah -->
        <div class="w-full h-0.5 outline outline-1 outline-neutral-900 outline-offset--1"></div>
    </div>

</section>

<!-- About Section -->
<section id="about"
    class="w-full max-w-screen-2xl mx-auto px-6 py-12 flex flex-col lg:flex-row justify-between items-start gap-12">

    <!-- Left Content -->
    <div class="flex flex-col gap-8 max-w-2xl">
        <!-- Heading & Description -->
        <div class="flex flex-col gap-6">
            <h2 class="text-3xl lg:text-4xl font-bold text-white leading-snug">
                With over 15 years of experience in manufacturing and technology
            </h2>
            <p class="text-gray-400 text-lg leading-relaxed">
                I've dedicated my career to bridging the gap between traditional manufacturing and cutting-edge AI
                solutions.
                <br><br>
                From my early days as a Production Engineer to becoming an AI Generalist, I've consistently focused on
                delivering measurable business impact through innovative technology solutions.
            </p>
        </div>

        <!-- Awards -->
        <div class="flex flex-wrap gap-6">
            <div class="flex items-center gap-3">
                <span class="text-yellow-400 text-xl">🏅</span>
                <span class="text-white text-lg font-medium">Google Recognition</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-yellow-400 text-xl">🏅</span>
                <span class="text-white text-lg font-medium">UNCTAD Reward</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-yellow-400 text-xl">🏅</span>
                <span class="text-white text-lg font-medium">Alibaba Recognition</span>
            </div>
        </div>
    </div>

    <!-- Right Content (1 Big Image) -->
    <div
        class="flex items-center justify-center p-4 bg-slate-800 rounded-2xl outline outline-1 outline-slate-600 aspect-video w-full max-w-4xl mx-auto">
        <img src="{{ asset('logo/' . $konf->logo_setting) }}" alt="Big Image" class="w-full h-full object-contain" />
    </div>


</section>


<!-- Profile Section -->
<section id="profile" class="w-full max-w-screen-2xl mx-auto px-6 py-12">
    <div
        class="bg-slate-900 rounded-2xl p-6 md:p-10 flex flex-col md:flex-row items-center md:items-start gap-6 shadow-lg">

        <!-- Profile Image -->
        <div class="flex-shrink-0">
            <img src="{{ asset('favicon/' . $konf->favicon_setting) }}" alt="Profile"
                class="w-28 h-28 rounded-full object-cover border-4 border-slate-700">
        </div>

        <!-- Text Content -->
        <div class="flex-1 flex flex-col gap-4">

            <!-- Heading + Buttons sejajar -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <h3 class="text-xl md:text-2xl font-bold text-white">
                    {{ $konf->profile_title }}
                </h3>

                <!-- Buttons -->
                <div class="flex flex-col gap-4">
                    <a href="{{ $konf->primary_button_link }}" target="_blank"
                        class="inline-flex items-center justify-center bg-yellow-400 text-black font-semibold px-6 py-3 rounded-xl shadow hover:bg-yellow-300 transition">
                        {{ $konf->primary_button_title }} →
                    </a>
                    <a href="{{ $konf->secondary_button_link }}" target="_blank"
                        class="inline-flex items-center justify-center border border-slate-600 text-white px-6 py-3 rounded-xl hover:bg-slate-800 transition">
                        {{ $konf->secondary_button_title }} ⬇
                    </a>
                </div>

            </div>

            <!-- Description -->
            <p class="text-gray-400 text-base leading-relaxed max-w-2xl">
                {!! $konf->profile_content !!}
            </p>

        </div>

    </div>
</section>




<!-- Awards Section -->
<section id="awards"
    class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 py-8 flex flex-col items-center gap-8 sm:gap-14">

    <!-- Heading -->
    <div class="flex flex-col gap-3 text-center">
        <h2 class="text-yellow-400 text-4xl sm:text-6xl font-bold leading-tight sm:leading-[67.2px] tracking-tight">
            Awards & Recognition
        </h2>
        <p class="text-neutral-400 text-lg sm:text-2xl font-normal leading-6 sm:leading-7 tracking-tight">
            Innovative solutions that drive real business impact and transformation
        </p>
    </div>

    <!-- Flexbox Layout -->
    <div class="flex flex-wrap justify-center gap-6 sm:gap-8 w-full">
        @foreach ($award as $row)
        <div
            class="w-full sm:w-[48%] lg:w-[30%] p-6 sm:p-8 bg-slate-800 rounded-lg outline outline-1 outline-neutral-800 flex gap-4 sm:gap-6">

            <!-- Logo -->
            <div
                class="w-20 sm:w-24 h-20 sm:h-24 flex items-center justify-center bg-slate-900 rounded-xl outline outline-1 outline-slate-500">
                <img src="{{ asset('file/award/' . $row->gambar_award) }}" alt="{{ $row->nama_award }} logo"
                    class="max-w-full max-h-full object-contain" />
            </div>

            <!-- Text -->
            <div class="flex-1 flex flex-col gap-1.5">
                <h3 class="text-white text-lg sm:text-xl font-semibold leading-snug">
                    {{ $row->nama_award }}
                </h3>
                <p class="text-gray-400 text-sm sm:text-base font-normal leading-normal">
                    {!! $row->keterangan_award !!}
                </p>
            </div>
        </div>
        @endforeach
    </div>
</section>



<!-- Services Section -->
<section id="services"
    class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 py-8 flex flex-col items-center gap-8 sm:gap-12">
    <div class="flex flex-col gap-3 sm:gap-5">
        <h2 class="text-yellow-400 text-4xl sm:text-6xl font-bold leading-tight sm:leading-[67.2px] tracking-tight">
            Services
        </h2>
        <p class="text-neutral-400 text-lg sm:text-2xl font-normal leading-6 sm:leading-7 tracking-tight">
            Comprehensive AI and automation solutions for your business transformation
        </p>
    </div>

    <div class="flex flex-col sm:flex-row gap-8 sm:gap-16">
        <div class="w-full sm:w-[747px] flex flex-col gap-6">
            @foreach ($layanan as $row)
            <div
                onclick="showServiceImage(
                        '{{ asset('file/layanan/' . $row->gambar_layanan) }}',
                        '{{ $row->nama_layanan }}',
                        `{!! addslashes($row->keterangan_layanan) !!}`
                    )"
                class="cursor-pointer px-6 sm:px-8 py-8 sm:py-10 bg-slate-800 rounded-xl outline outline-1 outline-yellow-400 outline-offset--1 flex gap-4 sm:gap-6 hover:bg-slate-700 transition">

                <svg class="w-12 sm:w-16 h-12 sm:h-16" fill="none" stroke="yellow" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                <div class="flex-1 flex flex-col gap-3">
                    <h3 class="text-yellow-400 text-xl sm:text-3xl font-bold leading-loose tracking-tight">
                        {{ $row->nama_layanan }}
                    </h3>
                    <p class="text-white text-base font-normal leading-tight tracking-tight">
                        {!! $row->keterangan_layanan !!}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex-1 flex flex-col gap-6 sm:gap-8">
            <!-- Gambar dinamis -->
            <img id="serviceImage"
                src="{{ asset('file/layanan/' . ($layanan[0]->gambar_layanan ?? 'default.jpg')) }}"
                alt="{{ $layanan[0]->nama_layanan ?? 'Service image' }}"
                class="w-full h-auto rounded-xl object-cover transition-all duration-500" />

            <!-- Deskripsi dinamis -->
            <p id="serviceDesc"
                class="text-neutral-400 text-base sm:text-xl font-normal leading-normal tracking-tight">
                {!! $layanan[0]->keterangan_layanan ?? 'Pilih layanan untuk melihat detailnya.' !!}
            </p>

            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ $konf->primary_button_link ?? '#' }}"
                    class="w-full px-6 sm:px-8 py-3 sm:py-4 bg-yellow-400 rounded-lg flex justify-center items-center gap-3">
                    <span
                        class="text-neutral-900 text-base sm:text-lg font-semibold capitalize leading-[40px] sm:leading-[64px]">
                        {{ $konf->primary_button_title ?? 'Request Quote' }}
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    function showServiceImage(src, alt, desc) {
        const img = document.getElementById('serviceImage');
        const p = document.getElementById('serviceDesc');
        img.src = src;
        img.alt = alt;
        p.innerHTML = desc; // update deskripsi
    }
</script>



<!-- Testimonials Section -->
<section class="testimonials-section" id="testimonials">
    <div class="content-wrapper">
        <h2 class="testimonials-title">Testimonials</h2>
        <p class="about-content">
            Real stories from clients who transformed their business with AI and automation.
        </p>

        <div class="testimonials-wrapper relative overflow-hidden">
            <!-- Wrapper untuk item -->
            <div class="testimonials-grid flex transition-transform duration-500 ease-in-out" id="testimonialSlider">
                @foreach ($testimonial as $row)
                <div class="testimonial-item flex-shrink-0 w-full sm:w-1/2 lg:w-1/3 px-4 text-center">
                    <img src="{{ $row->image ?? asset('file/testimonial/' . $row->gambar_testimonial) }}"
                        alt="{{ $row->author ?? 'Testimonial Image' }}"
                        class="testimonial-image mx-auto rounded-full w-20 h-20 object-cover border-4 border-yellow-400">
                    <div class="testimonial-text mt-4 text-white">"{!! $row->deskripsi_testimonial !!}"</div>
                    <div class="testimonial-author mt-2 font-semibold text-yellow-400">
                        {{ $row->judul_testimonial ?? 'Savannah Nguyen' }}
                    </div>
                    <p class="text-gray-400 text-sm">{{ $row->jabatan }}</p>
                </div>
                @endforeach
            </div>

            <!-- Dots (kosong, akan diisi via JS) -->
            <div class="flex justify-center mt-6 gap-2" id="testimonialDots"></div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slider = document.getElementById("testimonialSlider");
        const dotsContainer = document.getElementById("testimonialDots");
        let currentIndex = 0;
        let slideInterval;

        // Hitung total halaman (berapa layar penuh)
        function getTotalPages() {
            const itemsPerPage = window.innerWidth >= 1024 ? 3 : window.innerWidth >= 640 ? 2 : 1;
            return Math.ceil(slider.children.length / itemsPerPage);
        }

        // Render dots sesuai jumlah halaman
        function renderDots() {
            dotsContainer.innerHTML = "";
            const totalPages = getTotalPages();
            for (let i = 0; i < totalPages; i++) {
                const dot = document.createElement("span");
                dot.className =
                    "dot w-3 h-3 rounded-full bg-gray-500 inline-block cursor-pointer transition";
                dot.addEventListener("click", () => {
                    showSlide(i);
                    stopAutoSlide();
                    startAutoSlide();
                });
                dotsContainer.appendChild(dot);
            }
        }

        // Tampilkan slide tertentu
        function showSlide(index) {
            const wrapper = slider.parentElement;
            const wrapperWidth = wrapper.offsetWidth;
            const totalPages = getTotalPages();

            if (index < 0) index = totalPages - 1;
            if (index >= totalPages) index = 0;

            currentIndex = index;
            const offset = -index * wrapperWidth;
            slider.style.transform = `translateX(${offset}px)`;

            // Update dots
            const dots = dotsContainer.querySelectorAll(".dot");
            dots.forEach((dot, i) => {
                dot.classList.toggle("bg-yellow-400", i === index);
                dot.classList.toggle("bg-gray-500", i !== index);
            });
        }

        // Auto slide
        function startAutoSlide() {
            if (getTotalPages() > 1) {
                slideInterval = setInterval(() => {
                    showSlide(currentIndex + 1);
                }, 5000);
            }
        }

        function stopAutoSlide() {
            if (slideInterval) {
                clearInterval(slideInterval);
            }
        }

        // Init
        renderDots();
        showSlide(0);
        startAutoSlide();

        // Update saat resize
        window.addEventListener("resize", () => {
            renderDots();
            showSlide(currentIndex);
        });
    });
</script>



<!-- Gallery Section -->
<section id="gallery"
    class="w-full max-w-screen-xl mx-auto px-3 sm:px-4 py-6 flex flex-col items-center gap-6 sm:gap-10">
    <div class="flex flex-col gap-2 text-center">
        <h2 class="text-yellow-400 text-3xl sm:text-5xl font-bold leading-tight tracking-tight">
            Gallery
        </h2>
        <p class="text-neutral-400 text-base sm:text-lg font-normal leading-6 tracking-tight">
            Explore the visual journey of my work, from concept to impactful solutions
        </p>
    </div>

    <!-- Grid Gallery -->
    <div id="galleryGrid" class="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 w-full">
        @foreach ($galeri as $index => $row)
        <div>
            <div
                class="relative group rounded-lg bg-slate-900 outline outline-1 outline-slate-500 overflow-hidden transition-transform duration-300 hover:scale-105 hover:shadow-md">

                <!-- Klik gambar untuk buka modal -->
                <img src="{{ asset('file/galeri/' . $row->gambar_galeri) }}"
                    alt="{{ $row->nama_galeri ?? 'Gallery image' }}"
                    class="w-full h-auto rounded-lg aspect-square object-cover cursor-pointer gallery-image"
                    data-index="{{ $index }}"
                    data-gambar="{{ asset('file/galeri/' . $row->gambar_galeri) }}"
                    data-gambar1="{{ $row->gambar_galeri1 ? asset('file/galeri/' . $row->gambar_galeri1) : '' }}"
                    data-gambar2="{{ $row->gambar_galeri2 ? asset('file/galeri/' . $row->gambar_galeri2) : '' }}"
                    data-gambar3="{{ $row->gambar_galeri3 ? asset('file/galeri/' . $row->gambar_galeri3) : '' }}"
                    data-video="{{ $row->video_galeri ? asset('file/galeri/' . $row->video_galeri) : '' }}"
                    data-caption="{{ $row->nama_galeri ?? 'Gallery' }}" />

                <!-- Overlay -->
                <div
                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-opacity duration-300 flex items-end pointer-events-none">
                    <p
                        class="w-full text-center text-white text-xs sm:text-sm font-semibold p-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        {{ $row->nama_galeri ?? 'Gallery' }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>


<!-- Modal -->
<div id="imageModal"
    class="fixed inset-0 bg-black bg-opacity-90 hidden justify-center items-center z-50 p-4 overflow-y-auto">
    <div class="relative max-w-6xl w-full flex flex-col items-center">

        <!-- Tombol close -->
        <button id="closeModalBtn"
            class="absolute -top-3 -right-3 bg-white text-black rounded-full p-2 shadow-lg hover:bg-gray-200 z-50">
            ✕
        </button>

        <!-- Tombol Prev & Next -->
        <button id="prevGalleryBtn"
            class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-black p-3 rounded-full shadow z-50">
            ◀
        </button>
        <button id="nextGalleryBtn"
            class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-black p-3 rounded-full shadow z-50">
            ▶
        </button>

        <!-- Grid Media -->
        <div id="modalMediaContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full mt-12 z-40">
        </div>

        <!-- Caption -->
        <p id="modalCaption" class="text-center text-white text-lg font-medium mt-6"></p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const imgs = document.querySelectorAll('#galleryGrid img.gallery-image');
        const modal = document.getElementById('imageModal');
        const modalContainer = document.getElementById('modalMediaContainer');
        const modalCaption = document.getElementById('modalCaption');
        const closeBtn = document.getElementById('closeModalBtn');
        const prevBtn = document.getElementById('prevGalleryBtn');
        const nextBtn = document.getElementById('nextGalleryBtn');

        let currentIndex = 0;

        const galleryData = Array.from(imgs).map((img) => ({
            caption: img.dataset.caption,
            sources: [
                img.dataset.gambar,
                img.dataset.gambar1,
                img.dataset.gambar2,
                img.dataset.gambar3
            ].filter(src => src !== ""),
            video: img.dataset.video
        }));

        function renderModal(index) {
            modalContainer.innerHTML = "";
            const data = galleryData[index];

            const mediaItems = [...data.sources];
            if (data.video) mediaItems.push(data.video);

            mediaItems.forEach(src => {
                const wrapper = document.createElement('div');
                wrapper.className = "bg-slate-900 rounded-lg overflow-hidden shadow-lg flex flex-col";

                if (src.endsWith('.mp4') || src.endsWith('.webm')) {
                    const videoEl = document.createElement('video');
                    videoEl.src = src;
                    videoEl.controls = true;
                    videoEl.className = "w-full aspect-video object-contain max-h-screen";
                    wrapper.appendChild(videoEl);
                } else {
                    const imgEl = document.createElement('img');
                    imgEl.src = src;
                    imgEl.className = "w-full h-auto object-contain max-h-screen";
                    wrapper.appendChild(imgEl);
                }

                modalContainer.appendChild(wrapper);
            });

            modalCaption.innerText = data.caption;
        }

        function openModalFromElement(index) {
            currentIndex = index;
            renderModal(currentIndex);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        imgs.forEach((img, index) => {
            img.addEventListener('click', () => openModalFromElement(index));
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modalContainer.innerHTML = "";
        });

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % galleryData.length;
            renderModal(currentIndex);
        });

        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + galleryData.length) % galleryData.length;
            renderModal(currentIndex);
        });

        modal.addEventListener('click', (e) => {
            if (e.target === e.currentTarget) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modalContainer.innerHTML = "";
            }
        });
    });
</script>



<!-- Portfolio Section -->
<section id="portfolio"
    class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 py-8 flex flex-col items-center gap-8 sm:gap-10">

    <!-- Heading -->
    <div class="flex flex-col gap-3 text-center">
        <h2 class="text-yellow-400 text-4xl sm:text-6xl font-bold leading-tight sm:leading-[67.2px] tracking-tight">
            Portfolio
        </h2>
        <p class="text-neutral-400 text-lg sm:text-2xl font-normal leading-6 sm:leading-7 tracking-tight">
            AI Technopreneur with 16+ years of expertise in driving innovation and digital transformation across
        </p>
    </div>

    <!-- Filter Buttons -->
    <div class="w-full max-w-full sm:max-w-5xl flex flex-wrap justify-center gap-4 sm:gap-6" id="portfolio-filters">
        <button
            class="filter-btn px-6 sm:px-8 py-3 bg-yellow-400 rounded-lg outline outline-[1.5px] outline-yellow-400 flex items-center gap-3 transition-all duration-300 ease-in-out"
            data-filter="all">
            <span class="text-neutral-900 text-base sm:text-lg font-semibold leading-[64px]">All</span>
        </button>
        @foreach ($jenis_projects as $jenis)
        <button
            class="filter-btn px-6 sm:px-8 py-3 bg-slate-800/60 rounded-lg outline outline-[0.5px] outline-slate-500 flex items-center gap-3 transition-all duration-300 ease-in-out"
            data-filter="{{ $jenis }}">
            <span
                class="text-white text-base sm:text-lg font-semibold capitalize leading-[64px]">{{ $jenis }}</span>
        </button>
        @endforeach
    </div>

    <!-- Grid -->
    <div class="w-full max-w-full sm:max-w-5xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8"
        id="portfolio-grid">
        @foreach ($projects as $project)
        <div class="portfolio-item p-6 sm:p-8 bg-slate-800/60 rounded-2xl outline outline-1 {{ $loop->iteration == 3 ? 'outline-yellow-400' : 'outline-neutral-900/40' }} backdrop-blur-xl flex flex-col gap-6 transition-opacity duration-300 ease-in-out"
            data-jenis="{{ $project->jenis_project }}">
            <a href="{{ route('portfolio.detail', $project->slug_project) }}">
                <img class="w-full max-w-[300px] sm:max-w-[400px] h-auto rounded-2xl aspect-[5/4] object-cover"
                    src="{{ asset('file/project/' . $project->gambar_project) }}"
                    alt="{{ $project->nama_project }}" />
            </a>
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-3">
                    <div class="flex gap-2">
                        <span
                            class="text-gray-500 text-xs font-normal leading-none">{{ $project->jenis_project }}</span>
                    </div>
                    <h3
                        class="{{ $loop->iteration == 3 ? 'text-yellow-400' : 'text-white' }} text-xl sm:text-3xl font-bold leading-loose tracking-tight">
                        {{ $project->nama_project }}
                    </h3>
                    <p class="text-neutral-400 text-base font-normal leading-normal max-w-full sm:max-w-[400px]">
                        {!! Str::limit(strip_tags($project->keterangan_project), 120) !!}
                    </p>

                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('portfolio.detail', $project->slug_project) }}"
                        class="px-4 py-2 bg-yellow-400 rounded-lg text-neutral-900 text-base font-semibold leading-normal tracking-tight transition-all duration-300 ease-in-out hover:bg-yellow-500">Read
                        More</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Script Filter -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const filterBtns = document.querySelectorAll(".filter-btn");
        const items = document.querySelectorAll(".portfolio-item");

        filterBtns.forEach(btn => {
            btn.addEventListener("click", () => {
                // Reset active button
                filterBtns.forEach(b => b.classList.remove("bg-yellow-400",
                    "outline-yellow-400"));
                filterBtns.forEach(b => b.querySelector("span").classList.remove(
                    "text-neutral-900"));
                filterBtns.forEach(b => b.classList.add("bg-slate-800/60",
                    "outline-slate-500"));
                filterBtns.forEach(b => b.querySelector("span").classList.add("text-white"));

                // Set active button
                btn.classList.remove("bg-slate-800/60", "outline-slate-500");
                btn.classList.add("bg-yellow-400", "outline-yellow-400");
                btn.querySelector("span").classList.remove("text-white");
                btn.querySelector("span").classList.add("text-neutral-900");

                const filter = btn.getAttribute("data-filter");

                items.forEach(item => {
                    if (filter === "all" || item.getAttribute("data-jenis") ===
                        filter) {
                        item.classList.remove("hidden");
                        item.classList.add("flex");
                    } else {
                        item.classList.add("hidden");
                        item.classList.remove("flex");
                    }
                });
            });
        });
    });
</script>


<!-- Modal for full-size project images -->
<div id="projectModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden"
    role="dialog" aria-modal="true" aria-labelledby="projectModalLabel">
    <div class="relative max-w-4xl w-full mx-4 sm:mx-8">
        <button
            class="absolute top-2 right-2 text-white text-2xl font-bold bg-slate-900 rounded-full w-10 h-10 flex items-center justify-center hover:bg-slate-700 transition-colors"
            onclick="closeProjectModal()" aria-label="Close modal">
            &times;
        </button>
        <button
            class="absolute left-2 top-1/2 transform -translate-y-1/2 text-white text-2xl bg-slate-900 rounded-full w-10 h-10 flex items-center justify-center hover:bg-slate-700"
            onclick="navigateProjectImage('prev')" aria-label="Previous image">
            &larr;
        </button>
        <button
            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-white text-2xl bg-slate-900 rounded-full w-10 h-10 flex items-center justify-center hover:bg-slate-700"
            onclick="navigateProjectImage('next')" aria-label="Next image">
            &rarr;
        </button>
        <img id="projectModalImage" src="" alt=""
            class="w-full h-auto rounded-xl max-h-[80vh] object-contain" />
        <p id="projectModalCaption" class="text-white text-center mt-2 text-sm sm:text-base"></p>
        <span id="projectModalLabel" class="sr-only"></span>
    </div>
</div>

<!-- Articles Section -->
<section id="articles"
    class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 py-8 flex flex-col items-center gap-8 sm:gap-14">
    <div class="flex flex-col gap-3 text-center">
        <h2 class="text-yellow-400 text-3xl sm:text-5xl font-extrabold leading-tight sm:leading-[56px]">
            Latest Article
        </h2>
        <p class="text-neutral-400 text-lg sm:text-2xl font-normal leading-6 sm:leading-7 tracking-tight">
            Weekly insights on AI, technology, and innovation
        </p>
    </div>
    <div class="flex flex-col sm:flex-row gap-6 sm:gap-8">
        <div class="flex flex-col gap-6 sm:gap-8">
            @foreach ($article->take(3) as $row)
            <div
                class="p-6 sm:p-9 bg-slate-800 rounded-xl outline outline-1 outline-blue-950 outline-offset--1 flex flex-col sm:flex-row gap-4 sm:gap-8">
                <img src="{{ !empty($row->gambar_berita) ? asset('file/berita/' . $row->gambar_berita) : asset('file/berita/placeholder.png') }}"
                    alt="{{ $row->judul_berita }} thumbnail"
                    class="w-full sm:w-48 h-auto sm:h-32 object-cover rounded-xl" />
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <span class="text-slate-600 text-sm sm:text-base font-medium leading-normal">
                                {{ \Carbon\Carbon::parse($row->tanggal_berita)->format('M d, Y') }}
                            </span>
                            <div class="px-2 sm:px-3 py-1 sm:py-2 bg-yellow-400/10 rounded-sm">
                                <span
                                    class="text-yellow-400 text-xs font-medium font-['Fira_Sans'] uppercase leading-3">
                                    {{ $row->kategori_berita ?? 'AI & Tech' }}
                                </span>
                            </div>
                        </div>
                        <h3
                            class="text-white text-base sm:text-xl font-bold leading-6 sm:leading-7 max-w-full sm:max-w-96">
                            {{ $row->judul_berita }}
                        </h3>
                    </div>
                    <p
                        class="text-slate-500 text-sm sm:text-base font-medium leading-normal max-w-full sm:max-w-96">
                        {!! \Illuminate\Support\Str::limit(strip_tags($row->isi_berita), 150, '...') !!}
                        <a href="{{ route('article.detail', $row->slug_berita) }}"
                            class="text-yellow-400 hover:text-yellow-500 font-medium">Read More</a>
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        @if ($article->count() > 0)
        @php
        $featuredArticle = $article->first();
        @endphp
        <div
            class="p-6 sm:p-12 bg-slate-800 rounded-xl outline outline-1 outline-blue-950 outline-offset--1 flex flex-col gap-6 sm:gap-8">
            <img src="{{ !empty($featuredArticle->gambar_berita) ? asset('file/berita/' . $featuredArticle->gambar_berita) : asset('file/berita/placeholder.png') }}"
                alt="{{ $featuredArticle->judul_berita }} featured thumbnail"
                class="w-full max-w-[640px] h-auto rounded-xl object-cover" />
            <div class="flex flex-col gap-6 sm:gap-8">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <span class="text-slate-600 text-sm sm:text-base font-medium leading-normal">
                                {{ \Carbon\Carbon::parse($featuredArticle->tanggal_berita)->format('M d, Y') }}
                            </span>
                            <div class="px-2 sm:px-3 py-1 sm:py-2 bg-yellow-400/10 rounded-sm">
                                <span
                                    class="text-yellow-400 text-xs font-medium font-['Fira_Sans'] uppercase leading-3">
                                    {{ $featuredArticle->kategori_berita ?? 'AI & Tech' }}
                                </span>
                            </div>
                        </div>
                        <h3
                            class="text-white text-xl sm:text-2xl font-bold leading-loose max-w-full sm:max-w-[641px]">
                            {{ $featuredArticle->judul_berita }}
                        </h3>
                    </div>
                    <p
                        class="text-slate-500 text-sm sm:text-base font-medium leading-normal max-w-full sm:max-w-[641px]">
                        {!! \Illuminate\Support\Str::limit(strip_tags($featuredArticle->isi_berita), 150, '...') !!}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('article.detail', $featuredArticle->slug_berita) }}"
                        class="text-yellow-400 text-base sm:text-xl font-semibold leading-normal tracking-tight hover:text-yellow-500">
                        Read More
                    </a>
                    <svg class="w-5 sm:w-6 h-5 sm:h-6" fill="none" stroke="yellow" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </div>
        @endif
    </div>
    <a href="{{ url('articles') }}"
        class="px-6 sm:px-8 py-3 sm:py-4 rounded-xl outline outline-1 outline-yellow-400 outline-offset--1 backdrop-blur-[2px] flex items-center gap-2.5">
        <span class="text-yellow-400 text-base font-semibold leading-tight tracking-tight">See More</span>
        <svg class="w-5 sm:w-6 h-5 sm:h-6" fill="none" stroke="yellow" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
        </svg>
    </a>
</section>

<!-- Contact Section -->
<section id="contact"
    class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 bg-slate-800 rounded-3xl border border-slate-700 -m-1 flex flex-col lg:flex-row gap-8 lg:gap-12">
    <div class="flex flex-col gap-6 sm:gap-8 max-w-full lg:max-w-md">
        <div class="flex flex-col gap-4">
            <h2 class="text-white text-xl sm:text-2xl font-semibold leading-loose">
                Have a project or question in mind? Just send me a message.
            </h2>
            <p class="text-gray-400 text-sm sm:text-base font-light leading-normal">
                Let's discuss how AI and automation can drive innovation and efficiency in your organization.
            </p>
        </div>
        <div class="flex flex-col gap-5">
            <!-- Call me now -->
            <div class="flex items-center gap-4 p-4 bg-slate-900 rounded-xl hover:bg-slate-700 transition-all duration-300">
                <div class="flex-shrink-0 w-12 h-12 p-3 bg-yellow-400 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="black" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <div class="flex flex-col gap-1 min-w-0 flex-1">
                    <span class="text-gray-400 text-sm font-light leading-tight">Call me now</span>
                    <a href="tel:{{ $konf->no_hp_setting }}"
                        class="text-white text-base font-normal leading-normal hover:text-yellow-400 transition-colors truncate">{{ $konf->no_hp_setting }}</a>
                </div>
            </div>
            <!-- Chat with me -->
            <div class="flex items-center gap-4 p-4 bg-slate-900 rounded-xl hover:bg-slate-700 transition-all duration-300">
                <div class="flex-shrink-0 w-12 h-12 p-3 bg-yellow-400 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="black" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="flex flex-col gap-1 min-w-0 flex-1">
                    <span class="text-gray-400 text-sm font-light leading-tight">Chat with me</span>
                    <a href="mailto:{{ $konf->email_setting }}"
                        class="text-white text-base font-normal leading-normal hover:text-yellow-400 transition-colors truncate">{{ $konf->email_setting }}</a>
                </div>
            </div>
            <!-- Location -->
            <div class="flex items-center gap-4 p-4 bg-slate-900 rounded-xl hover:bg-slate-700 transition-all duration-300">
                <div class="flex-shrink-0 w-12 h-12 p-3 bg-yellow-400 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="black" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="flex flex-col gap-1 min-w-0 flex-1">
                    <span class="text-gray-400 text-sm font-light leading-tight">Location</span>
                    <span class="text-white text-base font-normal leading-normal">{{ $konf->alamat_setting }}</span>
                </div>
            </div>
        </div>
        <div
            class="p-6 sm:p-7 bg-slate-900 rounded-2xl flex flex-col gap-4 hover:bg-slate-700 transition-all duration-300">
            <span class="text-white text-base font-normal leading-normal">Follow me on social media</span>
            <div class="flex gap-3 justify-center">
                <a href="https://www.instagram.com/{{ $konf->instagram_setting }}" target="_blank"
                    class="p-3 bg-slate-800 rounded-full hover:bg-yellow-400 hover:text-black transition-all duration-300">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm10 2c1.654 0 3 1.346 3 3v10c0 1.654-1.346 3-3 3H7c-1.654 0-3-1.346-3-3V7c0-1.654 1.346-3 3-3h10zm-5 3a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6zm4.5-2a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
                    </svg>
                </a>
                <a href="https://www.facebook.com/{{ $konf->facebook_setting }}" target="_blank"
                    class="p-3 bg-slate-800 rounded-full hover:bg-yellow-400 hover:text-black transition-all duration-300">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M22 12a10 10 0 10-11.5 9.9v-7h-2v-3h2v-2c0-2 1.2-3.1 3-3.1.9 0 1.8.2 1.8.2v2h-1c-1 0-1.3.6-1.3 1.2v1.7h2.5l-.4 3h-2.1v7A10 10 0 0022 12z" />
                    </svg>
                </a>
                <a href="https://wa.me/{{ $konf->no_hp_setting }}" target="_blank"
                    class="p-3 bg-slate-800 rounded-full hover:bg-yellow-400 hover:text-black transition-all duration-300">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M20 3.5A10.5 10.5 0 003.5 20L2 22l2.2-.6A10.5 10.5 0 1019.5 3.5h.5zM12 20a8 8 0 01-4.1-1.1l-.3-.2-2.4.6.6-2.3-.2-.3A8 8 0 1112 20zm4.3-5.5c-.2-.1-1.2-.6-1.4-.7s-.3-.1-.5.1-.6.7-.8.8-.3.2-.5.1c-.2-.1-.9-.3-1.7-.9-.6-.5-1-1.1-1.1-1.3-.1-.2 0-.3.1-.4s.2-.2.3-.3c.1-.1.2-.2.3-.3.1-.1.2-.2.2-.4s0-.3-.1-.4c-.1-.1-.5-1.1-.7-1.5-.2-.4-.4-.3-.5-.3h-.4c-.1 0-.4.1-.7.3-.2.2-.9.9-.9 2.1s1 2.5 1.1 2.6c.1.2 2 3.1 4.9 4.3.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.6-.1 1.2-.6 1.3-1.1.2-.5.2-1 .1-1.1-.1-.1-.2-.1-.4-.2z" />
                    </svg>
                </a>
                <a href="mailto:{{ $konf->email_setting }}"
                    class="p-3 bg-slate-800 rounded-full hover:bg-yellow-400 hover:text-black transition-all duration-300">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zm0 2v.01L12 13 20 6.01V6H4zm0 12h16V8l-8 7-8-7v10z" />
                    </svg>
                </a>
                <a href="https://www.youtube.com/{{ $konf->youtube_setting }}" target="_blank"
                    class="p-3 bg-slate-800 rounded-full hover:bg-yellow-400 hover:text-black transition-all duration-300">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M21.8 8s-.2-1.4-.8-2c-.7-.8-1.5-.8-1.9-.9C16.7 4.8 12 4.8 12 4.8h-.1s-4.7 0-7.1.3c-.4 0-1.2.1-1.9.9-.6.6-.8 2-.8 2S2 9.6 2 11.3v1.3c0 1.7.2 3.3.2 3.3s.2 1.4.8 2c.7.8 1.7.7 2.1.8 1.6.2 6.9.3 6.9.3s4.7 0 7.1-.3c.4 0 1.2-.1 1.9-.9.6-.6.8-2 .8-2s.2-1.6.2-3.3v-1.3c0-1.7-.2-3.3-.2-3.3zM10 14.6V9.4l5.2 2.6-5.2 2.6z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <form action="{{ route('contact.store') }}" method="POST" class="flex flex-col gap-6 sm:gap-8 flex-1">
        @csrf
        <h2 class="text-white text-xl sm:text-2xl font-semibold leading-loose">Just say 👋 Hi</h2>
        <div class="flex flex-col gap-4">
            <div class="flex flex-col sm:flex-row gap-4">
                <input type="text" name="full_name" placeholder="Full Name" required
                    class="w-full sm:w-1/2 h-12 bg-slate-800 rounded-md border ..." />
                <input type="email" name="email" placeholder="Email Address" required
                    class="w-full sm:w-1/2 h-12 bg-slate-800 rounded-md border ..." />
            </div>
            <input type="text" name="subject" placeholder="Subject"
                class="w-full h-12 bg-slate-800 rounded-md border ..." />
            <div class="flex flex-col sm:flex-row gap-4">
                <select name="service" class="w-full sm:w-1/2 h-12 bg-slate-800 rounded-md border ...">
                    <option value="">Select Service</option>
                    <option value="ai">AI Development</option>
                    <option value="automation">Automation</option>
                </select>
                <select name="budget" class="w-full sm:w-1/2 h-12 bg-slate-800 rounded-md border ...">
                    <option value="">Select Budget</option>
                    <option value="low">$0 - $500</option>
                    <option value="medium">$500 - $2000</option>
                    <option value="high">$2000+</option>
                </select>
            </div>
            <textarea name="message" placeholder="Message" class="w-full h-32 bg-slate-800 rounded-md border ..."></textarea>
            <button type="submit"
                class="w-full sm:w-auto px-6 py-3 bg-yellow-400 rounded-xl flex items-center gap-3 hover:bg-yellow-500 transition-all duration-300 shadow-lg hover:shadow-xl">
                <span class="text-neutral-900 text-base font-semibold capitalize leading-[40px] sm:leading-[72px]">
                    Send Message
                </span>
                <svg class="w-5 sm:w-6 h-5 sm:h-6" fill="none" stroke="black" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </form>

</section>
@endsection
