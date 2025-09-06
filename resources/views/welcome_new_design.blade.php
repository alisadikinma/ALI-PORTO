@extends('layouts.web')

@section('isi')
<!-- New Hero Section with exact design -->
<section class="hero-container">
    <div class="content-wrapper">
        <img src="{{ asset('favicon/' . $konf->favicon_setting) }}" alt="Profile" class="profile-image">
        
        <div class="content-section">
            <h1 class="main-title">{{ $konf->profile_title }}</h1>
            <p class="description">
                {!! $konf->tentang_setting !!}
            </p>
        </div>
        
        <div class="button-section">
            <a href="{{ $konf->primary_button_link ?? '#contact' }}" class="request-quote-btn">
                {{ $konf->primary_button_title ?? 'Request Quote' }} <span class="arrow-icon">→</span>
            </a>
            <a href="{{ $konf->secondary_button_link ?? '#' }}" class="download-btn">
                {{ $konf->secondary_button_title ?? 'Download Rate Card' }} <span class="download-icon">⬇</span>
            </a>
        </div>
    </div>
</section>

<style>
.hero-container {
    background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
    min-height: 280px;
    display: flex;
    align-items: center;
    padding: 40px 60px;
    position: relative;
    overflow: hidden;
    margin-bottom: 2rem;
}

.hero-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(30, 58, 95, 0.95) 0%, rgba(44, 82, 130, 0.9) 100%);
    pointer-events: none;
}

.content-wrapper {
    display: flex;
    align-items: center;
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
    gap: 40px;
}

.profile-image {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    flex-shrink: 0;
}

.content-section {
    flex: 1;
    color: white;
}

.main-title {
    font-size: 42px;
    font-weight: 300;
    margin-bottom: 24px;
    line-height: 1.2;
    letter-spacing: -0.5px;
}

.description {
    font-size: 18px;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.85);
    font-weight: 400;
    margin-bottom: 0;
    max-width: 600px;
}

.button-section {
    display: flex;
    flex-direction: column;
    gap: 16px;
    flex-shrink: 0;
}

.request-quote-btn {
    background: #fbbf24;
    color: #1f2937;
    padding: 16px 32px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-width: 200px;
    box-shadow: 0 4px 16px rgba(251, 191, 36, 0.3);
    text-decoration: none;
}

.request-quote-btn:hover {
    background: #f59e0b;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(251, 191, 36, 0.4);
}

.download-btn {
    background: transparent;
    color: white;
    padding: 16px 32px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-width: 200px;
    text-decoration: none;
}

.download-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-2px);
}

.arrow-icon {
    font-size: 18px;
    font-weight: bold;
}

.download-icon {
    font-size: 16px;
}

@media (max-width: 1024px) {
    .hero-container {
        padding: 30px 40px;
        min-height: 240px;
    }
    
    .content-wrapper {
        gap: 30px;
    }
    
    .profile-image {
        width: 150px;
        height: 150px;
    }
    
    .main-title {
        font-size: 36px;
    }
    
    .description {
        font-size: 16px;
    }
}

@media (max-width: 768px) {
    .hero-container {
        padding: 20px;
        min-height: auto;
    }
    
    .content-wrapper {
        flex-direction: column;
        text-align: center;
        gap: 24px;
    }
    
    .profile-image {
        width: 120px;
        height: 120px;
    }
    
    .main-title {
        font-size: 28px;
        margin-bottom: 16px;
    }
    
    .description {
        font-size: 15px;
        max-width: 100%;
    }
    
    .button-section {
        width: 100%;
        max-width: 300px;
    }
}
</style>

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
                }, 300);
            });

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

<!-- Stats Section -->
<div class="w-full bg-neutral-900/40 flex flex-col items-center gap-4 sm:gap-6 md:gap-8 lg:gap-11">
    <div class="w-full h-0.5 outline outline-1 outline-neutral-900 outline-offset--1"></div>
    <div class="w-full px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 sm:gap-8">
            <div class="flex flex-col items-center gap-2 sm:gap-3 md:gap-4 p-4 rounded-2xl">
                <svg class="w-8 sm:w-10 md:w-12 h-8 sm:h-10 md:h-12" fill="none" stroke="yellow" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <div class="text-yellow-400 text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-center">
                    {{ $konf->years_experience }}
                </div>
                <div class="text-neutral-400 text-base sm:text-lg md:text-xl lg:text-2xl font-medium text-center">
                    Years Experience
                </div>
            </div>
            <div class="flex flex-col items-center gap-2 sm:gap-3 md:gap-4 p-4 rounded-2xl">
                <svg class="w-8 sm:w-10 md:w-12 h-8 sm:h-10 md:h-12" fill="none" stroke="yellow" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 18h-5v-2a3 3 0 015.356-1.857M7 18v-2c0-.656.126-1.283.356-1.857m-5.856 1.857A3 3 0 002 16v2m14 0v2m0 0h5m-5 0h-5m5 0v-2c0-.656-.126-1.283-.356-1.857M16 14c.083-.1.17-.198.268-.295a5.347 5.347 0 00.955-2.019A3.364 3.364 0 0017 11.579c0-1.08.738-1.979 1.678-2.279" />
                </svg>
                <div class="text-yellow-400 text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-center">
                    {{ $konf->followers_count }}
                </div>
                <div class="text-neutral-400 text-base sm:text-lg md:text-xl lg:text-2xl font-medium text-center">
                    Followers
                </div>
            </div>
            <div class="flex flex-col items-center gap-2 sm:gap-3 md:gap-4 p-4 rounded-2xl">
                <svg class="w-8 sm:w-10 md:w-12 h-8 sm:h-10 md:h-12" fill="none" stroke="yellow" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <div class="text-yellow-400 text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-center">
                    {{ $konf->project_delivered }}
                </div>
                <div class="text-neutral-400 text-base sm:text-lg md:text-xl lg:text-2xl font-medium text-center">
                    Projects Delivered
                </div>
            </div>
            <div class="flex flex-col items-center gap-2 sm:gap-3 md:gap-4 p-4 rounded-2xl">
                <svg class="w-8 sm:w-10 md:w-12 h-8 sm:h-10 md:h-12" fill="none" stroke="yellow" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-yellow-400 text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-center">
                    {{ $konf->cost_savings }}
                </div>
                <div class="text-neutral-400 text-base sm:text-lg md:text-xl lg:text-2xl font-medium text-center">
                    Cost Savings
                </div>
            </div>
            <div class="flex flex-col items-center gap-2 sm:gap-3 md:gap-4 p-4 rounded-2xl">
                <svg class="w-8 sm:w-10 md:w-12 h-8 sm:h-10 md:h-12" fill="none" stroke="yellow" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
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
    <div class="w-full h-0.5 outline outline-1 outline-neutral-900 outline-offset--1"></div>
</div>

<!-- About Section -->
<section id="about" class="w-full max-w-screen-2xl mx-auto px-6 py-12 flex flex-col lg:flex-row justify-between items-start gap-12">
    <div class="flex flex-col gap-8 max-w-2xl">
        <div class="flex flex-col gap-6">
            <h2 class="text-3xl lg:text-4xl font-bold text-white leading-snug">
                {{ $konf->about_section_title ?? 'With over 16+ years of experience in manufacturing and technology' }}
            </h2>
            @if($konf->about_section_subtitle)
            <h3 class="text-xl lg:text-2xl font-semibold text-yellow-400">
                {{ $konf->about_section_subtitle }}
            </h3>
            @endif
            <div class="text-gray-400 text-lg leading-relaxed">
                {!! $konf->about_section_description ?? "I've dedicated my career to bridging the gap between traditional manufacturing and cutting-edge AI solutions.<br><br>From my early days as a Production Engineer to becoming an AI Generalist, I've consistently focused on delivering measurable business impact through innovative technology solutions." !!}
            </div>
        </div>
        <div class="flex flex-wrap gap-6">
            @foreach ($award->take(3) as $award_item)
            <div class="flex items-center gap-3">
                <span class="text-yellow-400 text-xl">🏅</span>
                <span class="text-white text-lg font-medium">{{ $award_item->nama_award }}</span>
            </div>
            @endforeach
        </div>
    </div>
    <div class="flex items-center justify-center p-4 bg-slate-800 rounded-2xl outline outline-1 outline-slate-600 aspect-video w-full max-w-4xl mx-auto">
        @if($konf->about_section_image && file_exists(public_path('images/about/' . $konf->about_section_image)))
            <img src="{{ asset('images/about/' . $konf->about_section_image) }}" alt="About Image" class="w-full h-full object-contain" />
        @else
            <img src="{{ asset('logo/' . $konf->logo_setting) }}" alt="Logo Image" class="w-full h-full object-contain" />
        @endif
    </div>
</section>

<!-- Profile Section -->
<section id="profile" class="w-full max-w-screen-2xl mx-auto px-6 py-8">
    <div class="bg-slate-800 rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center gap-6 shadow-lg border border-slate-700">
        <div class="flex-shrink-0">
            <img src="{{ asset('favicon/' . $konf->favicon_setting) }}" alt="Profile" class="w-16 h-16 md:w-20 md:h-20 rounded-full object-cover">
        </div>
        <div class="flex-1 flex flex-col gap-2 md:gap-3">
            <h3 class="text-lg md:text-xl font-bold text-white">
                {{ $konf->profile_title }}
            </h3>
            <p class="text-gray-400 text-sm md:text-base leading-relaxed">
                {!! $konf->profile_content !!}
            </p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0">
            <a href="{{ $konf->primary_button_link }}" target="_blank" class="inline-flex items-center justify-center bg-yellow-400 text-black font-semibold px-4 py-2 rounded-lg text-sm hover:bg-yellow-300 transition whitespace-nowrap">
                {{ $konf->primary_button_title ?? 'Request Quote' }} →
            </a>
            <a href="{{ $konf->secondary_button_link }}" target="_blank" class="inline-flex items-center justify-center border border-slate-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-slate-700 transition whitespace-nowrap">
                {{ $konf->secondary_button_title ?? 'Download Rate Card' }} ⬇
            </a>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 bg-slate-800 rounded-3xl border border-slate-700 -m-1 flex flex-col lg:flex-row gap-8 lg:gap-12">
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
            <div class="flex items-center gap-4 p-4 bg-slate-900 rounded-xl hover:bg-slate-700 transition-all duration-300">
                <div class="flex-shrink-0 w-12 h-12 p-3 bg-yellow-400 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="black" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <div class="flex flex-col gap-1 min-w-0 flex-1">
                    <span class="text-gray-400 text-sm font-light leading-tight">Call me now</span>
                    <a href="tel:{{ $konf->no_hp_setting }}" class="text-white text-base font-normal leading-normal hover:text-yellow-400 transition-colors truncate">{{ $konf->no_hp_setting }}</a>
                </div>
            </div>
            <div class="flex items-center gap-4 p-4 bg-slate-900 rounded-xl hover:bg-slate-700 transition-all duration-300">
                <div class="flex-shrink-0 w-12 h-12 p-3 bg-yellow-400 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="black" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="flex flex-col gap-1 min-w-0 flex-1">
                    <span class="text-gray-400 text-sm font-light leading-tight">Chat with me</span>
                    <a href="mailto:{{ $konf->email_setting }}" class="text-white text-base font-normal leading-normal hover:text-yellow-400 transition-colors truncate">{{ $konf->email_setting }}</a>
                </div>
            </div>
            <div class="flex items-center gap-4 p-4 bg-slate-900 rounded-xl hover:bg-slate-700 transition-all duration-300">
                <div class="flex-shrink-0 w-12 h-12 p-3 bg-yellow-400 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="black" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="flex flex-col gap-1 min-w-0 flex-1">
                    <span class="text-gray-400 text-sm font-light leading-tight">Location</span>
                    <span class="text-white text-base font-normal leading-normal">{{ $konf->alamat_setting }}</span>
                </div>
            </div>
        </div>
        <div class="p-6 sm:p-7 bg-slate-900 rounded-2xl flex flex-col gap-4 hover:bg-slate-700 transition-all duration-300">
            <span class="text-white text-base font-normal leading-normal">Follow me on social media</span>
            <div class="flex gap-3 justify-center">
                <a href="https://www.instagram.com/{{ $konf->instagram_setting }}" target="_blank" class="p-3 bg-slate-800 rounded-full hover:bg-yellow-400 hover:text-black transition-all duration-300">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm10 2c1.654 0 3 1.346 3 3v10c0 1.654-1.346 3-3 3H7c-1.654 0-3-1.346-3-3V7c0-1.654 1.346-3 3-3h10zm-5 3a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6zm4.5-2a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
                    </svg>
                </a>
                <a href="https://www.facebook.com/{{ $konf->facebook_setting }}" target="_blank" class="p-3 bg-slate-800 rounded-full hover:bg-yellow-400 hover:text-black transition-all duration-300">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 12a10 10 0 10-11.5 9.9v-7h-2v-3h2v-2c0-2 1.2-3.1 3-3.1.9 0 1.8.2 1.8.2v2h-1c-1 0-1.3.6-1.3 1.2v1.7h2.5l-.4 3h-2.1v7A10 10 0 0022 12z" />
                    </svg>
                </a>
                <a href="https://wa.me/{{ $konf->no_hp_setting }}" target="_blank" class="p-3 bg-slate-800 rounded-full hover:bg-yellow-400 hover:text-black transition-all duration-300">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 3.5A10.5 10.5 0 003.5 20L2 22l2.2-.6A10.5 10.5 0 1019.5 3.5h.5zM12 20a8 8 0 01-4.1-1.1l-.3-.2-2.4.6.6-2.3-.2-.3A8 8 0 1112 20zm4.3-5.5c-.2-.1-1.2-.6-1.4-.7s-.3-.1-.5.1-.6.7-.8.8-.3.2-.5.1c-.2-.1-.9-.3-1.7-.9-.6-.5-1-1.1-1.1-1.3-.1-.2 0-.3.1-.4s.2-.2.3-.3c.1-.1.2-.2.3-.3.1-.1.2-.2.2-.4s0-.3-.1-.4c-.1-.1-.5-1.1-.7-1.5-.2-.4-.4-.3-.5-.3h-.4c-.1 0-.4.1-.7.3-.2.2-.9.9-.9 2.1s1 2.5 1.1 2.6c.1.2 2 3.1 4.9 4.3.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.6-.1 1.2-.6 1.3-1.1.2-.5.2-1 .1-1.1-.1-.1-.2-.1-.4-.2z" />
                    </svg>
                </a>
                <a href="mailto:{{ $konf->email_setting }}" class="p-3 bg-slate-800 rounded-full hover:bg-yellow-400 hover:text-black transition-all duration-300">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zm0 2v.01L12 13 20 6.01V6H4zm0 12h16V8l-8 7-8-7v10z" />
                    </svg>
                </a>
                <a href="https://www.youtube.com/{{ $konf->youtube_setting }}" target="_blank" class="p-3 bg-slate-800 rounded-full hover:bg-yellow-400 hover:text-black transition-all duration-300">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21.8 8s-.2-1.4-.8-2c-.7-.8-1.5-.8-1.9-.9C16.7 4.8 12 4.8 12 4.8h-.1s-4.7 0-7.1.3c-.4 0-1.2.1-1.9.9-.6.6-.8 2-.8 2S2 9.6 2 11.3v1.3c0 1.7.2 3.3.2 3.3s.2 1.4.8 2c.7.8 1.7.7 2.1.8 1.6.2 6.9.3 6.9.3s4.7 0 7.1-.3c.4 0 1.2-.1 1.9-.9.6-.6.8-2 .8-2s.2-1.6.2-3.3v-1.3c0-1.7-.2-3.3-.2-3.3zM10 14.6V9.4l5.2 2.6-5.2 2.6z" />
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
                <input type="text" name="full_name" placeholder="Full Name" required class="w-full sm:w-1/2 h-12 bg-slate-800 rounded-md border border-slate-600 px-4 text-white placeholder-gray-400 focus:border-yellow-400 focus:outline-none" />
                <input type="email" name="email" placeholder="Email Address" required class="w-full sm:w-1/2 h-12 bg-slate-800 rounded-md border border-slate-600 px-4 text-white placeholder-gray-400 focus:border-yellow-400 focus:outline-none" />
            </div>
            <input type="text" name="subject" placeholder="Subject" class="w-full h-12 bg-slate-800 rounded-md border border-slate-600 px-4 text-white placeholder-gray-400 focus:border-yellow-400 focus:outline-none" />
            <div class="flex flex-col sm:flex-row gap-4">
                <select name="service" class="w-full sm:w-1/2 h-12 bg-slate-800 rounded-md border border-slate-600 px-4 text-white focus:border-yellow-400 focus:outline-none">
                    <option value="">Select Service</option>
                    <option value="ai">AI Development</option>
                    <option value="automation">Automation</option>
                </select>
                <select name="budget" class="w-full sm:w-1/2 h-12 bg-slate-800 rounded-md border border-slate-600 px-4 text-white focus:border-yellow-400 focus:outline-none">
                    <option value="">Select Budget</option>
                    <option value="low">$0 - $500</option>
                    <option value="medium">$500 - $2000</option>
                    <option value="high">$2000+</option>
                </select>
            </div>
            <textarea name="message" placeholder="Message" class="w-full h-32 bg-slate-800 rounded-md border border-slate-600 px-4 py-3 text-white placeholder-gray-400 focus:border-yellow-400 focus:outline-none resize-none"></textarea>
            <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-yellow-400 rounded-xl flex items-center gap-3 hover:bg-yellow-500 transition-all duration-300 shadow-lg hover:shadow-xl">
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