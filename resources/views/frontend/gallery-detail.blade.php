@extends('frontend.partials.master')
@section('title', $gallery->title . ' - Never Ending Trails')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        h2 {
            font-size: clamp(1rem, 8vw, 10rem);
            font-weight: 600;
            text-align: center;
            margin-right: -0.5em;
            width: 90vw;
            max-width: 1200px;
            text-transform: none;
        }

        header {
            position: fixed;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            width: 100%;
            z-index: 3;
            height: 7em;
            font-size: clamp(0.66rem, 2vw, 1rem);
            letter-spacing: 0.5em;
        }

        section {
            height: 100%;
            width: 100%;
            top: 0;
            position: fixed;
            visibility: hidden;
        }
        section .outer,
        section .inner {
            width: 100%;
            height: 100%;
            overflow-y: hidden;
        }
        .bg {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            padding: 0 6%;
            height: 100%;
            width: 100%;
            background: #d1d1d1;
        }

        .section-gallery-desc {
            z-index: 10;
            width: 70%;
            text-align: left;
            font-size: 2.7rem;
            font-weight: 600;
            letter-spacing: -.0em;
            line-height: .95;
            font-family: 'Prata', serif;
            padding-right: 2vw;
            word-spacing: 0.1em;
        }
        .section-heading.full {
            position: absolute;
            top: 100px;
            left: 0;
            z-index: 10;
            width: 70%;
            text-align: left;
            font-size: clamp(1rem, 5vw, 5rem);
            font-weight: 600;
            letter-spacing: -0.01em;
            text-transform: uppercase;
            font-family: 'Prata', serif;
            line-height: 1.3;
            padding-right: 2vw;
        }

        .section-heading-child{
            position: absolute;
            top: 0px;
            left: 20px;
            z-index: 10;
            width: 300px;
            text-align: left;
            font-size: 35px;
            font-weight: 600;
            letter-spacing: -0.01em;
            text-transform: uppercase;
            font-family: 'Prata', serif;
            line-height: 1.3;
            padding-right: 2vw;
        }

        .first-layout {
            width: 100%;
            position: relative;
            text-align: left;
            padding-top: 16vw;
            height: 100%;
        }

        .thumb-group {
            position: relative;
            width: 100%;
            height: 45vh;
            margin-left: 0;
            margin-right: auto;
        }

        .thumb {
            position: absolute;
            width: 18vw;
            height: 70%;
            object-fit: cover;
            border-radius: 0px;
            box-shadow: 0 12px 45px rgba(0,0,0,0.25);
            transition: transform .45s ease, filter .45s ease, box-shadow .45s ease;
            cursor: pointer;
        }

        .thumb:nth-child(1) {
            left: 50%;
            transform: translateX(calc(-100% - 30px)) translateY(140px) scale(.88);
            z-index: 1;
        }

        .thumb:nth-child(2) {
            left: 50%;
            transform: translateX(-50%) translateY(-5px) scale(1.04);
            z-index: 3;
            height: 80%;
        }

        .thumb:nth-child(3) {
            left: 50%;
            transform: translateX(30px) translateY(180px) scale(.9);
            z-index: 4;
        }

        .stack-gallery .thumb:nth-child(1) {
            /*left: 50%;*/
            transform: translateX(calc(-100% - 30px)) translateY(140px) scale(.88);
            z-index: 1;
        }

        .stack-gallery .thumb:nth-child(2) {
            left: 50%;
            transform: translateX(-50%) translateY(-5px) scale(1.04);
            z-index: 3;
            height: 80%;
        }

        .stack-gallery .thumb:nth-child(3) {
            left: 50%;
            transform: translateX(30px) translateY(180px) scale(.9);
            z-index: 4;
        }

        .stack-gallery .thumb{
            height: inherit!important;
        }

        .category-badge {
            position: absolute;
            right: 0vw;
            bottom: 1vw;
            z-index: 10;
            width: max-content;
            font-size: 35px;
            font-weight: 500;
            letter-spacing: -0.01em;
            text-transform: uppercase;
            font-family: 'Prata', serif;
            line-height: 1.3;
        }

        .scroll-indicator-gallery {
            position: absolute;
            left: 50%;
            bottom: 1vw;
            transform: translateX(-50%);
            cursor: pointer;
            font-size: 2.8rem;
            color: #111;
            line-height: 1;
            user-select: none;
            animation: scrollBounce 1.4s infinite ease-in-out;
            z-index: 20;
            width: auto;
            height: auto;
            display: inline-block;
            text-align: center;
        }

        @keyframes scrollBounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(-12px); }
        }

        .footer{
            display: none;
        }

        /* ---------- STACK GALLERY CSS ---------- */
        .stack-gallery {
            position: relative;
            width: 100%;
            height: 70vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .stack-thumb {
            position: absolute;
            left: 50%;
            transform-style: preserve-3d;     /* enables depth */
            transition:
                    transform 0.8s ease,
                    opacity 0.8s ease,
                    filter 0.8s ease;
            /*width: 400px;*/
            width: auto;
            transform-origin: center center;
            cursor: grab;
        }

        /* default sizes */
        .stack-size-1 { width: 26vw; z-index: 30; }
        .stack-size-2 { width: 20vw; z-index: 20; }
        .stack-size-3 { width: 15vw; z-index: 10; }

        section.third .bg{
            background: #ffffff;
        }

        .thumb-meta {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            pointer-events: none;
            z-index: 50;
        }

        .thumb-title {
            position: absolute;
            left: 4%;
            top: 30%;
            width: 40%;
        }

        .thumb-desc {
            position: absolute;
            top: 0px;
            right: 0px;
            z-index: 10;
            width: 280px;
            text-align: left;
            font-size: 17px;
            font-weight: 500;
            letter-spacing: -0.01em;
            text-transform: uppercase;
            font-family: 'Prata', serif;
            line-height: 1.3;
            padding-right: 1vw;
        }

        .thumb-date {
            position: absolute;
            top: 30vh;
            right: 0px;
            z-index: 10;
            width: 280px;
            text-align: left;
            font-size: 17px;
            font-weight: 500;
            letter-spacing: -0.01em;
            text-transform: uppercase;
            font-family: 'Prata', serif;
            line-height: 1.3;
            padding-right: 2vw;
        }
    </style>
@endpush

@section('content')
{{--    @php--}}
{{--        $childImages = is_array($gallery->child_images) ? $gallery->child_images : [];--}}
{{--    @endphp--}}
    @php
        $childImages = is_array($gallery->child_images) ? $gallery->child_images : [];

        $sections = ['first'];

        if (!empty($gallery->description)) {
            $sections[] = 'second'; // Only add if description exists
        }

        $sections[] = 'third';
    @endphp
@foreach($sections as $section)
    <section class="{{ $section }}">
        <div class="outer">
            <div class="inner">
                <div class="bg">

                    {{-- FIRST SECTION --}}
                    @if($section === 'first')
                        <div class="first-layout">
                            <h2 class="section-heading full">{{ $gallery->title }}</h2>

                            <div class="thumb-group" onclick="gotoSection(1, 1)">
                                @foreach(array_slice($childImages, 0, 3) as $i => $img)
                                    <img src="{{ $img['url'] }}" class="thumb" alt="{{ $img['title'] }}">
                                @endforeach
                            </div>

                            <div class="category-badge">
                                {{ $gallery->category->name ?? 'Category' }}
                            </div>

                            <div class="scroll-indicator-gallery" onclick="gotoSection(1, 1)">
                                <i class="fa-solid fa-chevron-down" style="cursor: pointer"></i>
                            </div>
                        </div>
                    @endif

                    {{-- SECOND SECTION (only shown if description is NOT NULL) --}}
                    @if($section === 'second')
                        <div>
                            <h2 class="section-gallery-desc">{!! $gallery->description !!}</h2>
                            <h5 style="text-transform: uppercase; margin-top: 50px; font-weight: 600; cursor: pointer"
                                onclick="gotoSection(2, 1)">Read More</h5>
                        </div>
                    @endif

                    {{-- THIRD SECTION --}}
                    @if($section === 'third')
                        <div class="gallery-stack-wrapper" style="width: 100%;">
                            <div class="thumb-group stack-gallery">
                                @foreach($childImages as $i => $img)
                                    <img src="{{ $img['url'] }}"
                                         class="thumb stack-thumb"
                                         data-index="{{ $i }}"
                                         data-title="{{ $img['title'] }}"
                                         data-desc="{{ $img['short_description'] }}"
                                         data-date="{{ $img['date'] }}"
                                         alt="{{ $img['title'] }}">
                                @endforeach
                            </div>

                            <div class="thumb-meta">
                                <h2 class="section-heading-child"></h2>
                                <p class="thumb-desc"></p>
                                <span class="thumb-date"></span>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
@endforeach

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/Observer.min.js"></script>

    <script>
        gsap.registerPlugin(Observer);

        let sections      = gsap.utils.toArray("section"),
            images        = gsap.utils.toArray(".bg"),
            outerWrappers = gsap.utils.toArray(".outer"),
            innerWrappers = gsap.utils.toArray(".inner"),
            currentIndex  = -1,
            wrap          = gsap.utils.wrap(0, sections.length),
            animating;

        // ---------- FIX: Dynamic gallery section index ----------
        const gallerySection = document.querySelector("section.third");
        const galleryIndex   = sections.indexOf(gallerySection);
        // ---------------------------------------------------------

        // stack gallery
        const thumbs      = gsap.utils.toArray(".stack-thumb");
        let currentThumb  = 0;
        let inGallerySection = false;
        let scrollLock    = false;
        const totalThumbs = thumbs.length;

        // initialize
        gsap.set(outerWrappers, { yPercent: 100 });
        gsap.set(innerWrappers, { yPercent: -100 });

        // -------------------- GOTO SECTION --------------------
        function gotoSection(index, direction) {
            index = wrap(index);
            animating = true;

            // enter gallery
            if (index === galleryIndex && !inGallerySection) {
                currentThumb = 0;
                showThumb(currentThumb);
            }
            inGallerySection = (index === galleryIndex);

            let fromTop = direction === -1,
                dFactor = fromTop ? -1 : 1,
                tl = gsap.timeline({
                    defaults: { duration: 1.25, ease: "power1.inOut" },
                    onComplete: () => animating = false
                });

            if (currentIndex >= 0) {
                gsap.set(sections[currentIndex], { zIndex: 0 });
                tl.to(images[currentIndex], { yPercent: -15 * dFactor })
                    .set(sections[currentIndex], { autoAlpha: 0 });
            }

            gsap.set(sections[index], { autoAlpha: 1, zIndex: 1 });

            tl.fromTo([outerWrappers[index], innerWrappers[index]],
                { yPercent: i => i ? -100 * dFactor : 100 * dFactor },
                { yPercent: 0 }, 0)
                .fromTo(images[index], { yPercent: 15 * dFactor }, { yPercent: 0 }, 0)
                .fromTo(sections[index].querySelector("h2"),
                    { autoAlpha: 0, yPercent: 50 * dFactor },
                    { autoAlpha: 1, yPercent: 0, duration: 1, ease: "power2" },
                    0.2);

            currentIndex = index;
        }

        // -------------------- THUMB DISPLAY --------------------
        function showThumb(index, scrollingDown = true) {
            const total      = thumbs.length;
            const visible    = 3;
            const baseTop    = 60;
            const spacingY   = 15;
            const scaleStep  = 0.1;
            const zStep      = 120;
            const duration   = 2.2;

            thumbs.forEach((thumb, i) => {
                const r = i - index;

                if (r === 0) {
                    thumb.style.transition = `transform ${duration}s cubic-bezier(0.22,1,0.36,1), opacity ${duration}s ease`;
                    thumb.style.zIndex = total;
                    thumb.style.opacity = 1;
                    thumb.style.transform = `
                translate(-50%, -50%)
                translateY(${baseTop}%)
                translateZ(0)
                scale(1)
            `;
                    thumb.style.display = "block";
                    thumb.style.pointerEvents = "auto";

                } else if (r > 0 && r <= visible) {
                    const scale  = 1 - r * scaleStep;
                    const zMove  = -r * zStep;
                    const yOff   = baseTop - r * spacingY;

                    thumb.style.transition = `transform ${duration}s cubic-bezier(0.22,1,0.36,1)`;
                    thumb.style.zIndex = total - r;
                    thumb.style.opacity = 1;
                    thumb.style.transform =
                        `translate(-50%, -50%) translateY(${yOff}%) translateZ(${zMove}px) scale(${scale})`;
                    thumb.style.display = "block";
                    thumb.style.pointerEvents = "auto";

                } else if (r < 0) {
                    const exitY = scrollingDown ? 200 : -50;

                    thumb.style.transition = `transform ${duration}s cubic-bezier(0.22,1,0.36,1), opacity ${duration}s ease`;
                    thumb.style.zIndex = 0;
                    thumb.style.opacity = 0;
                    thumb.style.transform =
                        `translate(-50%, -50%) translateY(${exitY}%) translateZ(0) scale(.8)`;
                    thumb.style.pointerEvents = "none";

                    setTimeout(() => (thumb.style.display = "none"), duration * 1000);

                } else {
                    thumb.style.display = "none";
                    thumb.style.opacity = 0;
                    thumb.style.pointerEvents = "none";
                }
            });

            // metadata
            const meta   = document.querySelector('.thumb-meta');
            const elTitle= meta.querySelector('.section-heading-child');
            const elDesc = meta.querySelector('.thumb-desc');
            const elDate = meta.querySelector('.thumb-date');

            const t = thumbs[index];

            elTitle.textContent = t.dataset.title;
            elDesc.textContent  = t.dataset.desc;
            elDate.textContent  = t.dataset.date;

            elTitle.style.opacity = 0;
            elDesc.style.opacity  = 0;
            elDate.style.opacity  = 0;

            setTimeout(() => {
                elTitle.style.transition = "opacity 1s ease";
                elDesc.style.transition  = "opacity 1s ease";
                elDate.style.transition  = "opacity 1s ease";
                elTitle.style.opacity = 1;
                elDesc.style.opacity  = 1;
                elDate.style.opacity  = 1;
            }, 50);
        }

        // -------------------- SCROLL HANDLER --------------------
        function handleScroll(dir) {
            if (scrollLock || animating) return;
            scrollLock = true;

            if (inGallerySection) {
                if (dir > 0 && currentThumb < totalThumbs - 1) {
                    currentThumb++;
                    showThumb(currentThumb, true);
                } else if (dir < 0 && currentThumb > 0) {
                    currentThumb--;
                    showThumb(currentThumb, false);
                } else if (currentThumb === 0 && dir < 0) {
                    inGallerySection = false;
                    gotoSection(currentIndex - 1, -1);
                }
            } else {
                gotoSection(currentIndex + (dir > 0 ? 1 : -1), dir > 0 ? 1 : -1);
            }

            setTimeout(() => (scrollLock = false), 100);
        }

        // -------------------- OBSERVER --------------------
        Observer.create({
            type: "wheel,touch,pointer",
            wheelSpeed: -1,
            tolerance: 50,
            preventDefault: true,
            onUp: () => handleScroll(1),
            onDown: () => handleScroll(-1)
        });

        // init
        showThumb(currentThumb);
        gotoSection(0, 1);
    </script>

@endpush





{{--@extends('frontend.partials.master')--}}

{{--@section('title', $gallery->title . ' - Never Ending Trails')--}}

{{--@php--}}
{{--    $childImages = collect($gallery->child_images ?? [])->filter(function ($image) {--}}
{{--        return is_array($image) && !empty($image['url']);--}}
{{--    })->values();--}}
{{--@endphp--}}

{{--@push('styles')--}}
{{--<style>--}}
{{--    body {--}}
{{--        background: #ffffff;--}}
{{--        color: #050505;--}}
{{--        font-family: 'Space Grotesk', 'Inter', sans-serif;--}}
{{--    }--}}

{{--    body.no-scroll {--}}
{{--        overflow: hidden;--}}
{{--    }--}}

{{--    .gd-intro {--}}
{{--        max-width: 1200px;--}}
{{--        margin: 0 auto;--}}
{{--        padding: clamp(40px, 6vw, 120px) clamp(24px, 6vw, 80px);--}}
{{--    }--}}

{{--    .gd-intro__subtitle {--}}
{{--        font-size: 16px;--}}
{{--        text-transform: uppercase;--}}
{{--        letter-spacing: 0.4em;--}}
{{--        color: rgba(5, 5, 5, 0.55);--}}
{{--        margin-bottom: 24px;--}}
{{--    }--}}

{{--    .gd-intro__title {--}}
{{--        font-size: clamp(48px, 8vw, 110px);--}}
{{--        font-weight: 600;--}}
{{--        margin: 0 0 24px;--}}
{{--    }--}}

{{--    .gd-intro__description {--}}
{{--        font-size: 20px;--}}
{{--        line-height: 1.8;--}}
{{--        color: rgba(5,5,5,0.75);--}}
{{--    }--}}

{{--    .gd-stack-section {--}}
{{--        background: #fff;--}}
{{--        padding: clamp(40px, 6vw, 120px) clamp(24px, 6vw, 80px) clamp(80px, 8vw, 160px);--}}
{{--    }--}}

{{--    .gd-stack-grid {--}}
{{--        display: grid;--}}
{{--        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));--}}
{{--        gap: clamp(40px, 6vw, 80px);--}}
{{--        align-items: center;--}}
{{--    }--}}

{{--    .stacked-gallery-wrapper {--}}
{{--        position: relative;--}}
{{--        width: min(520px, 90vw);--}}
{{--        height: min(70vh, 560px);--}}
{{--        margin: 0 auto;--}}
{{--        perspective: 1600px;--}}
{{--        cursor: grab;--}}
{{--    }--}}

{{--    .stacked-gallery {--}}
{{--        position: relative;--}}
{{--        width: 100%;--}}
{{--        height: 100%;--}}
{{--    }--}}

{{--    .stacked-image {--}}
{{--        position: absolute;--}}
{{--        inset: 0;--}}
{{--        border-radius: 28px;--}}
{{--        overflow: hidden;--}}
{{--        box-shadow: 0 35px 90px rgba(0,0,0,0.25);--}}
{{--        transform-origin: center;--}}
{{--        transition: box-shadow 0.4s ease;--}}
{{--    }--}}

{{--    .stacked-image img {--}}
{{--        width: 100%;--}}
{{--        height: 100%;--}}
{{--        object-fit: cover;--}}
{{--        display: block;--}}
{{--    }--}}

{{--    .gd-meta-panel {--}}
{{--        display: flex;--}}
{{--        flex-direction: column;--}}
{{--        gap: 12px;--}}
{{--        font-size: 18px;--}}
{{--        line-height: 1.8;--}}
{{--    }--}}

{{--    .gd-meta-panel__label {--}}
{{--        text-transform: uppercase;--}}
{{--        letter-spacing: 0.35em;--}}
{{--        font-size: 12px;--}}
{{--        color: rgba(5,5,5,0.45);--}}
{{--    }--}}

{{--    .gd-meta-panel__count {--}}
{{--        font-size: clamp(48px, 8vw, 90px);--}}
{{--        font-weight: 600;--}}
{{--        letter-spacing: 0.15em;--}}
{{--    }--}}
{{--</style>--}}
{{--@endpush--}}

{{--@section('content')--}}

{{--@if($childImages->isNotEmpty())--}}
{{--    <section class="gd-intro">--}}
{{--        <p class="gd-intro__subtitle">{{ $gallery->category->name ?? 'Gallery' }}</p>--}}
{{--        <h1 class="gd-intro__title">{{ $gallery->title }}</h1>--}}
{{--        <p class="gd-intro__description">--}}
{{--            {!!$gallery->description !!}--}}
{{--        </p>--}}
{{--    </section>--}}

{{--    <section class="gd-stack-section">--}}
{{--        <div class="gd-stack-grid">--}}
{{--            <div class="gd-meta-panel" id="stackedMetaLeft">--}}
{{--                <span class="gd-meta-panel__label">FRAME TITLE</span>--}}
{{--                <div id="stackedTitle">{{ $childImages[0]['title'] ?? 'Untitled frame' }}</div>--}}
{{--            </div>--}}

{{--            <div class="stacked-gallery-wrapper" id="stackedGallery">--}}
{{--                <div class="stacked-gallery">--}}
{{--                    @foreach($childImages as $index => $image)--}}
{{--                        <figure--}}
{{--                            class="stacked-image"--}}
{{--                            style="--stack-index: {{ $loop->index }};"--}}
{{--                            data-title="{{ e($image['title'] ?? 'Untitled frame') }}"--}}
{{--                            data-description="{{ e($image['short_description'] ?? 'No description yet.') }}"--}}
{{--                            data-date="{{ e($image['date'] ?? '') }}"--}}
{{--                            data-count="{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}"--}}
{{--                        >--}}
{{--                            <img src="{{ $image['url'] }}" alt="{{ $image['title'] ?? $gallery->title }}">--}}
{{--                        </figure>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="gd-meta-panel" id="stackedMetaRight" style="text-align: right;">--}}
{{--                <span class="gd-meta-panel__label">DESCRIPTION</span>--}}
{{--                <p id="stackedDescription">{{ $childImages[0]['short_description'] ?? 'No description yet.' }}</p>--}}
{{--                <p id="stackedDate">{{ $childImages[0]['date'] ?? '' }}</p>--}}
{{--                <div class="gd-meta-panel__count" id="stackedCounter">{{ str_pad(1, 2, '0', STR_PAD_LEFT) }}</div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--@else--}}
{{--    <p class="text-center py-20">No gallery images available.</p>--}}
{{--@endif--}}

{{--@endsection--}}

{{--@push('scripts')--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>--}}
{{--<script>--}}
{{--    document.addEventListener("DOMContentLoaded", () => {--}}

{{--        const wrapper = document.getElementById("stackedGallery");--}}
{{--        const stackSection = document.querySelector(".gd-stack-section");--}}
{{--        const cards = Array.from(wrapper.querySelectorAll(".stacked-image"));--}}
{{--        const metaPanels = document.querySelectorAll(".gd-meta-panel");--}}

{{--        const titleEl = document.getElementById("stackedTitle");--}}
{{--        const descEl = document.getElementById("stackedDescription");--}}
{{--        const dateEl = document.getElementById("stackedDate");--}}
{{--        const counterEl = document.getElementById("stackedCounter");--}}

{{--        if (!cards.length) return;--}}

{{--        let isAnimating = false;--}}
{{--        let scrollLocked = false;--}}
{{--        let stackEngaged = false;--}}
{{--        let currentIndex = 0;--}}
{{--        const total = cards.length;--}}
{{--        const visibleDepth = Math.min(4, total - 1);--}}

{{--        const applyLayout = () => {--}}
{{--            cards.forEach((card, i) => {--}}
{{--                const depth = Math.min(i, visibleDepth);--}}
{{--                gsap.set(card, {--}}
{{--                    y: depth * 26,--}}
{{--                    scale: 1 - depth * 0.04,--}}
{{--                    opacity: depth > visibleDepth ? 0 : 1,--}}
{{--                    zIndex: total - i--}}
{{--                });--}}
{{--            });--}}
{{--        };--}}

{{--        const updateMeta = () => {--}}
{{--            const card = cards[0];--}}
{{--            titleEl.textContent = card.dataset.title || "Untitled frame";--}}
{{--            descEl.textContent = card.dataset.description || "No description yet.";--}}
{{--            dateEl.textContent = card.dataset.date || "";--}}
{{--            counterEl.textContent = card.dataset.count || "01";--}}
{{--        };--}}

{{--        const lockScroll = () => {--}}
{{--            scrollLocked = true;--}}
{{--            document.body.classList.add("no-scroll");--}}
{{--        };--}}
{{--        const unlockScroll = () => {--}}
{{--            scrollLocked = false;--}}
{{--            stackEngaged = false;--}}
{{--            document.body.classList.remove("no-scroll");--}}
{{--        };--}}

{{--        const animateExitDown = () => {--}}
{{--            isAnimating = true;--}}
{{--            const lastCard = cards[0];--}}

{{--            gsap.timeline({--}}
{{--                onComplete() {--}}
{{--                    unlockScroll();--}}
{{--                    isAnimating = false;--}}
{{--                }--}}
{{--            })--}}
{{--                .to(lastCard, {--}}
{{--                    y: 200,--}}
{{--                    scale: 1.2,--}}
{{--                    opacity: 0,--}}
{{--                    duration: 0.5,--}}
{{--                    ease: "power2.in"--}}
{{--                })--}}
{{--                .to(wrapper, {--}}
{{--                    opacity: 0,--}}
{{--                    duration: 0.35,--}}
{{--                    ease: "power1.in"--}}
{{--                }, "-=0.2");--}}
{{--        };--}}

{{--        const animateExitUp = () => {--}}
{{--            isAnimating = true;--}}
{{--            const firstCard = cards[0];--}}

{{--            gsap.timeline({--}}
{{--                onComplete() {--}}
{{--                    unlockScroll();--}}
{{--                    isAnimating = false;--}}
{{--                }--}}
{{--            })--}}
{{--                .to(firstCard, {--}}
{{--                    y: -200,--}}
{{--                    scale: 1.2,--}}
{{--                    opacity: 0,--}}
{{--                    duration: 0.45,--}}
{{--                    ease: "power2.in"--}}
{{--                })--}}
{{--                .to(wrapper, {--}}
{{--                    opacity: 0,--}}
{{--                    duration: 0.35,--}}
{{--                    ease: "power1.in"--}}
{{--                }, "-=0.2");--}}
{{--        };--}}

{{--        const animateStackReEntry = () => {--}}
{{--            gsap.set(wrapper, { opacity: 0 });--}}

{{--            gsap.to(wrapper, {--}}
{{--                opacity: 1,--}}
{{--                duration: 0.35,--}}
{{--                ease: "power1.out"--}}
{{--            });--}}
{{--        };--}}

{{--        const cycleForward = () => {--}}
{{--            if (isAnimating) return;--}}

{{--            // If already at last → exit stack downward--}}
{{--            if (currentIndex === total - 1) {--}}
{{--                animateExitDown();--}}
{{--                return;--}}
{{--            }--}}

{{--            isAnimating = true;--}}
{{--            const first = cards.shift();--}}
{{--            currentIndex++;--}}

{{--            gsap.timeline({--}}
{{--                onComplete() {--}}
{{--                    cards.push(first);--}}
{{--                    applyLayout();--}}
{{--                    updateMeta();--}}
{{--                    isAnimating = false;--}}
{{--                }--}}
{{--            })--}}
{{--                .to(first, {--}}
{{--                    y: -220,--}}
{{--                    rotation: -4,--}}
{{--                    scale: 1.05,--}}
{{--                    opacity: 0,--}}
{{--                    duration: 0.45,--}}
{{--                    ease: "power2.in"--}}
{{--                });--}}
{{--        };--}}

{{--        const cycleBackward = () => {--}}
{{--            if (isAnimating) return;--}}

{{--            // If already at first + scroll up → exit upward--}}
{{--            if (currentIndex === 0) {--}}
{{--                animateExitUp();--}}
{{--                return;--}}
{{--            }--}}

{{--            isAnimating = true;--}}

{{--            const last = cards.pop();--}}
{{--            cards.unshift(last);--}}
{{--            currentIndex--;--}}

{{--            gsap.set(last, {--}}
{{--                y: (visibleDepth + 1) * 26,--}}
{{--                scale: 1 - (visibleDepth + 1) * 0.04,--}}
{{--                opacity: 0,--}}
{{--                rotation: 4--}}
{{--            });--}}

{{--            gsap.timeline({--}}
{{--                onComplete() {--}}
{{--                    applyLayout();--}}
{{--                    updateMeta();--}}
{{--                    isAnimating = false;--}}
{{--                }--}}
{{--            })--}}
{{--                .to(last, {--}}
{{--                    y: 0,--}}
{{--                    scale: 1,--}}
{{--                    rotation: 0,--}}
{{--                    opacity: 1,--}}
{{--                    duration: 0.45,--}}
{{--                    ease: "power2.out"--}}
{{--                });--}}
{{--        };--}}

{{--        applyLayout();--}}
{{--        updateMeta();--}}

{{--        const handleScroll = (direction) => {--}}
{{--            if (!stackEngaged || !scrollLocked || isAnimating) return;--}}

{{--            direction === "down" ? cycleForward() : cycleBackward();--}}
{{--        };--}}

{{--        const onWheel = (e) => {--}}
{{--            if (!scrollLocked) return;--}}

{{--            e.preventDefault();--}}
{{--            const direction = e.deltaY > 0 ? "down" : "up";--}}
{{--            handleScroll(direction);--}}
{{--        };--}}

{{--        wrapper.addEventListener("wheel", onWheel, { passive: false });--}}
{{--        metaPanels.forEach(panel =>--}}
{{--            panel.addEventListener("wheel", onWheel, { passive: false })--}}
{{--        );--}}

{{--        const engageStack = () => {--}}
{{--            if (stackEngaged) return;--}}
{{--            stackEngaged = true;--}}
{{--            lockScroll();--}}
{{--            animateStackReEntry();--}}

{{--            window.scrollTo({--}}
{{--                top: stackSection.offsetTop,--}}
{{--                behavior: "smooth"--}}
{{--            });--}}
{{--        };--}}

{{--        // Detect entering stack area from top or bottom--}}
{{--        const observer = new IntersectionObserver((entries) => {--}}
{{--            entries.forEach(entry => {--}}
{{--                if (!entry.isIntersecting) return;--}}

{{--                const viewportTop = window.scrollY;--}}
{{--                const stackTop = stackSection.offsetTop;--}}

{{--                const comingFromBelow = viewportTop > stackTop + 50;--}}
{{--                const comingFromAbove = viewportTop < stackTop - 50;--}}

{{--                if (!stackEngaged && !scrollLocked) {--}}
{{--                    if (comingFromAbove || comingFromBelow) {--}}
{{--                        engageStack();--}}
{{--                    }--}}
{{--                }--}}
{{--            });--}}
{{--        }, {--}}
{{--            threshold: 0.6,--}}
{{--            rootMargin: "-15% 0px"--}}
{{--        });--}}

{{--        observer.observe(stackSection);--}}

{{--    });--}}
{{--</script>--}}

{{--@endpush--}}
