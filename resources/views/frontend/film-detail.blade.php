@extends('frontend.partials.master')

@section('title', $film->title . ' - Never Ending Trails')

@push('styles')
<style>
    :root {
        --film-overlay: rgba(6, 8, 10, 0.55);
        --film-overlay-strong: rgba(2, 3, 4, 0.85);
    }

    .film-hero {
        position: relative;
        min-height: 100vh;
        width: 100%;
        overflow: hidden;
        display: flex;
        align-items: flex-end;
        padding: 0;
    }

    body:has(.film-hero) {
        background-color: #020305;
        color: #f5f5f5;
    }

    body:has(.film-hero) .container {
        padding-top: 0;
    }

    .film-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg,
        rgba(3, 6, 10, 0.05) 0%,
        rgba(3, 6, 10, 0.20) 55%,
        rgba(3, 6, 10, 0.40) 100%
        );
        z-index: 1;
    }

    .film-hero-background {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transform: scale(1.05);
        transition: transform 6s ease-in-out;
    }

    .film-hero:hover .film-hero-background {
        transform: scale(1.12);
    }

    .film-hero-content {
        position: relative;
        z-index: 2;
        width: 100%;
        padding: 60px 0 90px;
    }

    .film-overlay-grid {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 48px;
        align-items: end;
    }

    .film-poster-card {
        width: min(220px, 22vw);
        background: rgba(18, 19, 22, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        padding: 5px;
        position: relative;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
    }

    .film-poster-card::after {
        content: '';
        position: absolute;
        inset: -1px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        pointer-events: none;
    }

    .film-poster-card img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
        aspect-ratio: 2 / 3;
    }

    .film-meta-card {
        color: #fff;
        padding-bottom: 8px;
    }

    .film-category-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.12);
        padding: 6px 14px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        border-radius: 32px;
        margin-bottom: 18px;
        width: fit-content;
    }

    .film-title {
        font-size: clamp(32px, 5vw, 48px);
        line-height: 1.05;
        margin-bottom: 12px;
        letter-spacing: -0.01em;
        color: #fff;
    }

    .film-meta-line {
        font-size: 14px;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 18px;
    }

    .film-synopsis {
        font-size: 18px;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.85);
        max-width: 640px;
    }

    .film-highlight-grid {
        margin-top: 32px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 16px;
    }

    .film-highlight-item {
        padding: 14px 18px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.08);
        font-size: 14px;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.75);
    }

    .film-highlight-item strong {
        display: block;
        color: #fff;
        font-size: 16px;
        margin-top: 6px;
        letter-spacing: normal;
        text-transform: none;
    }

    .film-hero-actions {
        margin-top: 36px;
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
    }

    .film-button {
        padding: 14px 32px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        font-size: 13px;
        font-weight: 600;
        background: transparent;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .film-button.primary {
        background: #ffffff;
        color: #050709;
        border-color: #ffffff;
    }

    .film-button:hover {
        transform: translateY(-3px);
        border-color: #ffffff;
        color: #ffffff;
    }

    .film-button.primary:hover {
        background: transparent;
        color: #ffffff;
    }

    .film-scroll-cue {
        position: absolute;
        bottom: 28px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        color: rgba(255, 255, 255, 0.75);
        font-size: 12px;
        letter-spacing: 0.24em;
        text-transform: uppercase;
    }

    .film-scroll-cue button {
        background: transparent;
        border: none;
        color: inherit;
        cursor: pointer;
        font: inherit;
        letter-spacing: inherit;
        text-transform: inherit;
        transition: color 0.3s ease;
    }

    .film-scroll-cue svg {
        width: 22px;
        height: 32px;
        stroke: currentColor;
        animation: filmScroll 1.8s ease-in-out infinite;
    }

    .film-play-button {
        position: absolute;
        bottom: 60px;
        right: 80px;
        z-index: 3;
        display: inline-flex;
        align-items: center;
        gap: 18px;
        text-decoration: none;
        color: #ffffff;
    }

.film-play-button-circle {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.4);
        transition: transform 0.4s ease, background 0.4s ease;
        overflow: hidden;
    }

    .film-play-button-circle::after {
        content: '';
        position: absolute;
        inset: -12px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        animation: pulse 2.8s ease-out infinite;
    }

.film-play-button-label {
    position: absolute;
    inset: 0;
    display: block;
    font-size: 10px;
    letter-spacing: 0.36em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.85);
    text-align: center;
    pointer-events: none;
}

    .film-play-button-label span {
        position: absolute;
        left: 50%;
        top: 50%;
        transform-origin: 0 0;
        transform: rotate(var(--angle)) translate(0, -36px);
    }

    .film-play-button svg {
        width: 60px;
        height: 60px;
        fill: currentColor;
        pointer-events: none;
    }

    .film-play-button:hover {
        transform: scale(1.06);
        /*background: rgba(255, 255, 255, 0.2);*/
    }

    @keyframes pulse {
        0% { transform: scale(0.8); opacity: 0.8; }
        70% { transform: scale(1.4); opacity: 0; }
        100% { transform: scale(1.4); opacity: 0; }
    }

    @keyframes filmScroll {
        0%, 100% { transform: translateY(0); opacity: 0.4; }
        50% { transform: translateY(8px); opacity: 1; }
    }

    .film-details-section {
        background: #020305;
        color: #f5f5f5;
        padding: 30px 0 30px;
    }

    .film-details-section .wrap_float {
        overflow: visible;
    }

    .film-details-grid {
        display: grid;
        grid-template-columns: minmax(180px, 0.5fr) minmax(0, 1.5fr);
        gap: 36px;
        align-items: stretch;
    }

    .film-details-right {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .film-detail-sticky {
        position: relative;
        align-self: stretch;
        height: 100%;
        display: flex;
        align-items: flex-start;
        justify-content: center;
    }

    .film-detail-poster {
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.12);
        background: rgba(4, 6, 9, 0.92);
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.6);
        padding: 0px;
        width: 100%;
        /* max-width: 240px; */
        margin: 0 auto;
        opacity: 0;
        transform: translateY(120px) scale(0.88);
        transition: opacity 3s ease-out,
            transform 4s cubic-bezier(0.19, 1, 0.22, 1);
transition-delay: 0.1s;
    }

    .film-detail-poster.is-fixed {
        position: fixed;
        top: 90px;
        z-index: 5;
    }

    .film-detail-poster.is-visible {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    .film-detail-poster.is-bottom {
        position: absolute;
        top: auto;
        bottom: 0;
        z-index: 1;
    }

    .film-detail-poster img {
        width: 100%;
        display: block;
        object-fit: cover;
        aspect-ratio: 2 / 3;
    }

    .film-details-main {
        background: #040608;
        padding: 38px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
    }

    .film-details-header {
        margin-bottom: 0px;
    }

    .film-details-header h2 {
        font-size: clamp(26px, 3vw, 38px);
        color: #fdfdfd;
        margin-bottom: 0px;
    }

    .film-description p {
        font-size: 18px;
        line-height: 1.8;
        margin-bottom: 12px;
        color: rgba(245, 245, 245, 0.78);
    }

    .film-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
        margin-top: 10px;
    }

    .film-info-card {
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 18px 20px;
        background: rgba(7, 10, 14, 0.9);
    }

    .film-info-card label {
        font-size: 11px;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: rgba(245, 245, 245, 0.6);
        margin-bottom: 10px;
        display: block;
    }

    .film-info-card span {
        color: #fdfdfd;
        font-size: 17px;
    }

    .film-tags {
        margin-top: 10px;
    }

    .film-tags span {
        display: inline-flex;
        padding: 9px 16px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        margin: 6px;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        font-size: 11px;
        color: #fdfdfd;
        background: rgba(255, 255, 255, 0.05);
    }

    .film-gallery {
        margin-top: 20px;
    }

    .film-gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-top: 26px;
    }

    .film-gallery-grid a {
        display: block;
        width: 100%;
        height: 100%;
    }

    .film-gallery-grid img {
        width: 100%;
        display: block;
        object-fit: cover;
        height: 320px;
    }

    .film-related-section {
        background: #040507;
        padding-bottom: 30px;
    }

    .film-related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 24px;
        margin-top: 25px;
    }

    .film-related-card {
        /* border: 1px solid rgba(255, 255, 255, 0.08); */
        /* padding: 14px; */
        background: rgba(255, 255, 255, 0.02);
        text-decoration: none;
        color: inherit;
        transition: transform 0.25s ease, border-color 0.25s ease;
    }

    .film-related-card:hover {
        transform: translateY(-6px);
        /* border-color: rgba(255, 255, 255, 0.35); */
    }

    .film-related-card img {
        width: 100%;
        aspect-ratio: 3 / 4;
        object-fit: cover;
        margin-bottom: 14px;
    }

    .film-related-card h4 {
        font-size: 18px;
        color: #fff;
        margin-bottom: 6px;
    }

    @media (max-width: 1024px) {
        .film-overlay-grid {
            grid-template-columns: 1fr;
            gap: 28px;
        }

        .film-poster-card {
            width: min(420px, 60vw);
            justify-self: start;
        }
    }

    @media (max-width: 1024px) {
        .film-details-grid {
            grid-template-columns: 1fr;
        }

        .film-detail-sticky {
            position: static;
        }

        .film-details-main {
            padding: 32px;
        }
    }

    @media (max-width: 768px) {
        .film-hero {
            min-height: 90vh;
        }

        .film-hero-content {
            padding: 40px 0 100px;
        }

        .film-poster-card {
            width: 100%;
        }

        .film-title {
            font-size: clamp(32px, 9vw, 48px);
        }

        .film-details-main {
            padding: 24px;
        }

        .film-gallery-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .film-gallery-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <section class="film-hero">
        <div class="film-hero-background" style="background-image: url('{{ $film->film_banner ? asset($film->film_banner) : asset('assets/images/main-banner.webp') }}');"></div>
        <div class="film-hero-content">
            <div class="wrap">
                <div class="wrap_float">
                    <div class="film-overlay-grid">
                        <div class="film-poster-card">
                            <img src="{{ $film->film_poster ? asset($film->film_poster) : asset('assets/images/specials/1.webp') }}" alt="{{ $film->title }}">
                        </div>
                        <div class="film-meta-card">
                            <div class="film-category-pill">
                                {{ optional($film->category)->name ?? 'Feature' }}
                            </div>
                            <h1 class="film-title">{{ $film->title }}</h1>
                            @php
                                $filmMetaParts = [];
                                $filmMetaParts[] = optional($film->category)->name ?? 'Movie';
                                if ($film->release_date) {
                                    $filmMetaParts[] = $film->release_date->format('Y');
                                }
                                if (!empty($film->genre)) {
                                    $primaryGenre = is_array($film->genre) ? ($film->genre[0] ?? null) : $film->genre;
                                    if ($primaryGenre) {
                                        $filmMetaParts[] = $primaryGenre;
                                    }
                                }
                            @endphp
                            @if(!empty(array_filter($filmMetaParts)))
                                <div class="film-meta-line">{{ implode(', ', array_filter($filmMetaParts)) }}</div>
                            @endif
                            @if($film->synopsis)
                                <p class="film-synopsis">{{ \Illuminate\Support\Str::limit($film->synopsis, 230) }}</p>
                            @endif
                            <div class="film-hero-actions">
                                @if($film->trailer_link)
                                    <a href="{{ $film->trailer_link }}" class="film-button primary" target="_blank" rel="noopener">
                                        Watch Trailer
                                    </a>
                                @endif
{{--                                @if($film->watch_link)--}}
{{--                                    <a href="{{ $film->watch_link }}" class="film-button" target="_blank" rel="noopener">--}}
{{--                                        Stream Film--}}
{{--                                    </a>--}}
{{--                                @endif--}}
                                <button class="film-button scroll-to-details" data-target="#film-details">
                                    Explore Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($film->watch_link)
            <a href="{{ $film->watch_link }}" class="film-play-button" target="_blank" rel="noopener">
                <span class="film-play-button-circle">
                    <span class="film-play-button-label">
                        <span style="--angle: 0deg;">W</span>
                        <span style="--angle: 18deg;">A</span>
                        <span style="--angle: 36deg;">T</span>
                        <span style="--angle: 54deg;">C</span>
                        <span style="--angle: 72deg;">H</span>
                        <span style="--angle: 108deg;">N</span>
                        <span style="--angle: 126deg;">O</span>
                        <span style="--angle: 144deg;">W</span>
                    </span>
                    <svg viewBox="0 0 60 60">
                        <path d="M24 18v24l18-12-18-12z"/>
                    </svg>
                </span>
            </a>
        @endif
        <div class="film-scroll-cue">
            <svg fill="none">
                <rect x="0.75" y="0.75" width="20.5" height="30.5" rx="10.25" stroke="currentColor" stroke-width="1.5"/>
                <path d="M11 8V15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <button class="scroll-to-details" data-target="#film-details">Scroll</button>
        </div>
    </section>

    <section class="film-details-section" id="film-details">
        <div class="wrap">
            <div class="wrap_float">
                <div class="film-details-grid">
                    <div class="film-detail-sticky">
                        <div class="film-detail-poster">
                            <img src="{{ $film->film_poster ? asset($film->film_poster) : asset('assets/images/specials/1.webp') }}" alt="{{ $film->title }} poster">
                        </div>
                    </div>
                    <div class="film-details-right">
                        <div class="film-details-main">
                            <div class="film-details-header">
                                <h2>Description</h2>
                                <div class="film-description">
                                    @if($film->description)
                                        {!! $film->description !!}
                                    @elseif($film->synopsis)
                                        <p>{{ $film->synopsis }}</p>
                                    @else
                                        <p>Detailed information coming soon.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="film-info-grid">
                            <div class="film-info-card">
                                <label>Category</label>
                                <span>{{ optional($film->category)->name ?? 'Uncategorized' }}</span>
                            </div>
                            <div class="film-info-card">
                                <label>Release Date</label>
                                <span>{{ $film->release_date?->format('F d, Y') ?? 'TBA' }}</span>
                            </div>
                            <div class="film-info-card">
                                <label>Duration</label>
                                <span>{{ $film->watch_time ?? '—' }}</span>
                            </div>
                            @if(!empty($film->genre))
                                <div class="film-info-card">
                                    <label>Genres</label>
                                    <span>{{ implode(' / ', (array) $film->genre) }}</span>
                                </div>
                            @endif
                            @if(!empty($film->tags))
                                <div class="film-info-card">
                                    <label>Keywords</label>
                                    <span>{{ implode(', ', (array) $film->tags) }}</span>
                                </div>
                            @endif
                        </div>

                        @if(!empty($film->tags))
                            <div class="film-tags">
                                @foreach((array) $film->tags as $tag)
                                    <span>#{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                @if(!empty($film->film_images))
                    <div class="film-gallery" id="film-gallery-grid">
                        <div class="film-details-header">
                            <h2>Few Moments from the Film</h2>
                        </div>
                        <div class="film-gallery-grid">
                            @foreach($film->film_images as $image)
                                <a href="{{ asset($image) }}" class="film-gallery-item" data-src="{{ asset($image) }}">
                                    <img src="{{ asset($image) }}" alt="{{ $film->title }} still">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if($otherFilms->isNotEmpty())
        <section class="film-related-section">
            <div class="wrap">
                <div class="wrap_float">
                    <div class="film-details-header">
                        <h2>More Films</h2>
                    </div>
                    <div class="film-related-grid">
                        @foreach($otherFilms as $relatedFilm)
                            <a href="{{ route('front.film.detail', $relatedFilm->slug) }}" class="film-related-card">
                                <img src="{{ $relatedFilm->film_poster ? asset($relatedFilm->film_poster) : asset('assets/images/specials/1.webp') }}" alt="{{ $relatedFilm->title }}">
                                <h4>{{ $relatedFilm->title }}</h4>
                                <span>{{ optional($relatedFilm->category)->name ?? 'Film' }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.scroll-to-details').forEach(button => {
        button.addEventListener('click', event => {
            event.preventDefault();
            const target = document.querySelector(button.dataset.target);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    const stickyWrapper = document.querySelector('.film-detail-sticky');
    const stickyPoster = document.querySelector('.film-detail-poster');
    const stickyEndTarget = document.querySelector('.film-tags') || document.querySelector('.film-details-right');
    const filmDetailsSection = document.getElementById('film-details');

    function updateStickyPoster() {
        if (!stickyWrapper || !stickyPoster || !stickyEndTarget) {
            return;
        }

        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const wrapperTop = stickyWrapper.getBoundingClientRect().top + scrollTop;
        const endBottom = stickyEndTarget.getBoundingClientRect().top + scrollTop + stickyEndTarget.offsetHeight;
        const posterHeight = stickyPoster.offsetHeight;
        const topOffset = 90;

        const startSticky = scrollTop + topOffset > wrapperTop;
        const beyondEnd = scrollTop + posterHeight + topOffset >= endBottom;

        if (startSticky && !beyondEnd) {
            stickyPoster.classList.add('is-fixed');
            stickyPoster.classList.remove('is-bottom');
            stickyPoster.style.width = `${stickyWrapper.offsetWidth}px`;
        } else if (beyondEnd) {
            stickyPoster.classList.remove('is-fixed');
            stickyPoster.classList.add('is-bottom');
            stickyPoster.style.width = `${stickyWrapper.offsetWidth}px`;
        } else {
            stickyPoster.classList.remove('is-fixed', 'is-bottom');
            stickyPoster.style.width = '';
        }
    }

    if (stickyPoster) {
        updateStickyPoster();
        window.addEventListener('scroll', updateStickyPoster, { passive: true });
        window.addEventListener('resize', () => {
            stickyPoster.style.width = '';
            requestAnimationFrame(updateStickyPoster);
        });

        if ('IntersectionObserver' in window && filmDetailsSection) {
            const visibilityObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        stickyPoster.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });

            visibilityObserver.observe(filmDetailsSection);
        } else {
            stickyPoster.classList.add('is-visible');
        }
    }

    const initFilmGalleryLightbox = () => {
        const galleryContainer = document.getElementById('film-gallery-grid');
        if (!galleryContainer) {
            return;
        }

        if (typeof jQuery !== 'undefined' && jQuery.fn.lightGallery) {
            jQuery(() => {
                jQuery(galleryContainer).lightGallery({
                    selector: '.film-gallery-item',
                    mode: 'lg-fade',
                    download: false,
                    share: false,
                    zoom: true,
                    speed: 500
                });
            });
        } else if (typeof lightGallery !== 'undefined') {
            lightGallery(galleryContainer, {
                selector: '.film-gallery-item',
                mode: 'lg-fade',
                download: false,
                share: false,
                zoom: true,
                speed: 500
            });
        }
    };

    initFilmGalleryLightbox();
</script>
@endpush

