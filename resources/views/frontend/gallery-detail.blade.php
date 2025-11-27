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

                        {{-- SECOND SECTION --}}
                        @if($section === 'second')
                            <div>
                                <h2 class="section-gallery-desc">{!! $gallery->description !!}</h2>
                                <h5 style="text-transform: uppercase; margin-top: 50px; font-weight: 600; cursor: pointer"
                                    onclick="gotoSection(2, 1)">Read More</h5>
                            </div>
                        @endif

                        {{-- THIRD SECTION --}}
                        @if($section === 'third')
                            <div class="gallery-stack-wrapper">
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

        let sections = gsap.utils.toArray("section"),
            images = gsap.utils.toArray(".bg"),
            outerWrappers = gsap.utils.toArray(".outer"),
            innerWrappers = gsap.utils.toArray(".inner"),
            currentIndex = -1,
            wrap = gsap.utils.wrap(0, sections.length),
            animating;

        // Stack gallery variables
        const thumbs = gsap.utils.toArray(".stack-thumb");
        let currentThumb = 0;
        const totalThumbs = thumbs.length;
        let inGallerySection = false;
        let scrollLock = false;

        // Dynamically find gallery section index
        const gallerySectionEl = document.querySelector('.third');
        const galleryIndex = sections.indexOf(gallerySectionEl);

        // Initialize sections
        gsap.set(outerWrappers, { yPercent: 100 });
        gsap.set(innerWrappers, { yPercent: -100 });

        // -------------------- GOTO SECTION --------------------
        function gotoSection(index, direction) {
            index = wrap(index);
            animating = true;

            // Enter gallery section
            if(index === galleryIndex && !inGallerySection){
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

            if(currentIndex >= 0){
                gsap.set(sections[currentIndex], { zIndex: 0 });
                tl.to(images[currentIndex], { yPercent: -15 * dFactor })
                    .set(sections[currentIndex], { autoAlpha: 0 });
            }

            gsap.set(sections[index], { autoAlpha: 1, zIndex: 1 });
            tl.fromTo([outerWrappers[index], innerWrappers[index]],
                { yPercent: i => i ? -100*dFactor : 100*dFactor },
                { yPercent: 0 }, 0)
                .fromTo(images[index], { yPercent: 15*dFactor }, { yPercent: 0 }, 0)
                .fromTo(sections[index].querySelector("h2"),
                    { autoAlpha: 0, yPercent: 50*dFactor },
                    { autoAlpha: 1, yPercent: 0, duration: 1, ease: "power2" }, 0.2);

            currentIndex = index;
        }

        // -------------------- SHOW THUMB --------------------
        function showThumb(index, scrollingDown = true) {
            const total = thumbs.length;
            const visibleAbove = 3;
            const baseTop = 60;
            const spacingY = 15;
            const scaleStep = 0.1;
            const zStep = 120;
            const duration = 2.2;
            const slowDuration = 2.2;

            thumbs.forEach((thumb, i) => {
                const relativeIndex = i - index;

                if (relativeIndex === 0) {
                    thumb.style.transition = `transform ${slowDuration}s cubic-bezier(0.22, 1, 0.36, 1), opacity ${slowDuration}s ease`;
                    thumb.style.zIndex = total;
                    thumb.style.opacity = 1;
                    thumb.style.transform = `translate(-50%, -50%) translateY(${baseTop}%) translateZ(0px) scale(1)`;
                    thumb.style.pointerEvents = "auto";
                    thumb.style.display = "block";
                } else if (relativeIndex > 0 && relativeIndex <= visibleAbove) {
                    const offset = relativeIndex;
                    const scale = 1 - offset * scaleStep;
                    const zMove = -offset * zStep;
                    const yOffset = baseTop - offset * spacingY;
                    thumb.style.transition = `transform ${duration}s cubic-bezier(0.22, 1, 0.36, 1)`;
                    thumb.style.zIndex = total - offset;
                    thumb.style.opacity = 1;
                    thumb.style.transform = `translate(-50%, -50%) translateY(${yOffset}%) translateZ(${zMove}px) scale(${scale})`;
                    thumb.style.pointerEvents = "auto";
                    thumb.style.display = "block";
                } else if (relativeIndex < 0) {
                    thumb.style.transition = `transform ${duration}s cubic-bezier(0.22, 1, 0.36, 1), opacity ${duration}s ease`;
                    thumb.style.zIndex = total - visibleAbove - 1;
                    thumb.style.opacity = 0;
                    const exitY = scrollingDown ? 200 : -50;
                    thumb.style.transform = `translate(-50%, -50%) translateY(${exitY}%) translateZ(0px) scale(0.8)`;
                    thumb.style.pointerEvents = "none";
                    thumb.style.display = "block";
                    setTimeout(() => { thumb.style.display = "none"; }, duration * 10000);
                } else {
                    thumb.style.zIndex = 0;
                    thumb.style.opacity = 0;
                    thumb.style.transform = `translate(-50%, -50%) translateY(-9999px) scale(0.5)`;
                    thumb.style.pointerEvents = "none";
                    thumb.style.display = "none";
                }
            });

            const metaContainer = document.querySelector('.thumb-meta');
            const titleEl = metaContainer.querySelector('.section-heading-child');
            const descEl = metaContainer.querySelector('.thumb-desc');
            const dateEl = metaContainer.querySelector('.thumb-date');

            const activeThumb = thumbs[index];
            titleEl.textContent = activeThumb.dataset.title;
            descEl.textContent = activeThumb.dataset.desc;
            dateEl.textContent = activeThumb.dataset.date;

            titleEl.style.opacity = 0;
            descEl.style.opacity = 0;
            dateEl.style.opacity = 0;

            setTimeout(() => {
                titleEl.style.transition = "opacity 1s ease";
                descEl.style.transition = "opacity 1s ease";
                dateEl.style.transition = "opacity 1s ease";
                titleEl.style.opacity = 1;
                descEl.style.opacity = 1;
                dateEl.style.opacity = 1;
            }, 50);
        }

        // -------------------- SCROLL HANDLER --------------------
        function handleScroll(dir){
            if(scrollLock || animating) return;
            scrollLock = true;

            if(inGallerySection){
                if(dir > 0 && currentThumb < totalThumbs-1){
                    currentThumb++;
                    showThumb(currentThumb, true);
                } else if(dir < 0 && currentThumb > 0){
                    currentThumb--;
                    showThumb(currentThumb, false);
                } else if(currentThumb === 0 && dir < 0){
                    inGallerySection = false;
                    gotoSection(currentIndex-1, -1);
                }
            } else {
                if(dir > 0){
                    gotoSection(currentIndex+1, 1);
                } else {
                    gotoSection(currentIndex-1, -1);
                }
            }

            setTimeout(()=> scrollLock=false, 500);
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

        // -------------------- INITIALIZE --------------------
        showThumb(currentThumb);
        gotoSection(0,1);
    </script>
@endpush


{{--@push('scripts')--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/Observer.min.js"></script>--}}
{{--    <script>--}}
{{--        gsap.registerPlugin(Observer);--}}

{{--        let sections = gsap.utils.toArray("section"),--}}
{{--            images = gsap.utils.toArray(".bg"),--}}
{{--            outerWrappers = gsap.utils.toArray(".outer"),--}}
{{--            innerWrappers = gsap.utils.toArray(".inner"),--}}
{{--            currentIndex = -1,--}}
{{--            wrap = gsap.utils.wrap(0, sections.length),--}}
{{--            animating;--}}

{{--        // Stack gallery variables--}}
{{--        const thumbs = gsap.utils.toArray(".stack-thumb");--}}
{{--        let currentThumb = 0;--}}
{{--        const totalThumbs = thumbs.length;--}}
{{--        let inGallerySection = false;--}}
{{--        let scrollLock = false;--}}
{{--        // let thumbAnimating = false;--}}

{{--        // Initialize sections--}}
{{--        gsap.set(outerWrappers, { yPercent: 100 });--}}
{{--        gsap.set(innerWrappers, { yPercent: -100 });--}}

{{--        // -------------------- GOTO SECTION ----------------------}}
{{--        function gotoSection(index, direction) {--}}
{{--            index = wrap(index);--}}
{{--            animating = true;--}}

{{--            // Enter gallery section--}}
{{--            if(index === 2 && !inGallerySection){--}}
{{--                currentThumb = 0;--}}
{{--                showThumb(currentThumb);--}}
{{--            }--}}

{{--            inGallerySection = (index === 2);--}}

{{--            let fromTop = direction === -1,--}}
{{--                dFactor = fromTop ? -1 : 1,--}}
{{--                tl = gsap.timeline({--}}
{{--                    defaults: { duration: 1.25, ease: "power1.inOut" },--}}
{{--                    onComplete: () => animating = false--}}
{{--                });--}}

{{--            if(currentIndex >= 0){--}}
{{--                gsap.set(sections[currentIndex], { zIndex: 0 });--}}
{{--                tl.to(images[currentIndex], { yPercent: -15 * dFactor })--}}
{{--                    .set(sections[currentIndex], { autoAlpha: 0 });--}}
{{--            }--}}

{{--            gsap.set(sections[index], { autoAlpha: 1, zIndex: 1 });--}}
{{--            tl.fromTo([outerWrappers[index], innerWrappers[index]],--}}
{{--                { yPercent: i => i ? -100*dFactor : 100*dFactor },--}}
{{--                { yPercent: 0 }, 0)--}}
{{--                .fromTo(images[index], { yPercent: 15*dFactor }, { yPercent: 0 }, 0)--}}
{{--                .fromTo(sections[index].querySelector("h2"),--}}
{{--                    { autoAlpha: 0, yPercent: 50*dFactor },--}}
{{--                    { autoAlpha: 1, yPercent: 0, duration: 1, ease: "power2" }, 0.2);--}}

{{--            currentIndex = index;--}}
{{--        }--}}

{{--        function showThumb(index, scrollingDown = true) {--}}
{{--            const total = thumbs.length;--}}
{{--            const visibleAbove = 3;--}}
{{--            const baseTop = 60;--}}
{{--            const spacingY = 15;--}}
{{--            const scaleStep = 0.1;--}}
{{--            const zStep = 120;--}}
{{--            const duration = 2.2;--}}
{{--            const slowDuration = 2.2;--}}

{{--            // thumbAnimating = true; // block scroll while thumb animates--}}

{{--            thumbs.forEach((thumb, i) => {--}}
{{--                const relativeIndex = i - index;--}}

{{--                if (relativeIndex === 0) {--}}
{{--                    // new current card--}}
{{--                    thumb.style.transition = `--}}
{{--                transform ${slowDuration}s cubic-bezier(0.22, 1, 0.36, 1),--}}
{{--                opacity ${slowDuration}s ease--}}
{{--            `;--}}
{{--                    thumb.style.zIndex = total;--}}
{{--                    thumb.style.opacity = 1;--}}
{{--                    thumb.style.transform = `--}}
{{--                translate(-50%, -50%)--}}
{{--                translateY(${baseTop}%)--}}
{{--                translateZ(0px)--}}
{{--                scaleX(1) scaleY(1)--}}
{{--            `;--}}
{{--                    // scaleX(1.3) scaleY(1.05)--}}
{{--                    thumb.style.pointerEvents = "auto";--}}
{{--                    thumb.style.display = "block";--}}
{{--                } else if (relativeIndex > 0 && relativeIndex <= visibleAbove) {--}}
{{--                    // cards above current--}}
{{--                    const offset = relativeIndex;--}}
{{--                    const scale = 1 - offset * scaleStep;--}}
{{--                    const zMove = -offset * zStep;--}}
{{--                    const yOffset = baseTop - offset * spacingY;--}}

{{--                    thumb.style.transition = `transform ${duration}s cubic-bezier(0.22, 1, 0.36, 1)`;--}}
{{--                    thumb.style.zIndex = total - offset;--}}
{{--                    thumb.style.opacity = 1;--}}
{{--                    thumb.style.transform = `translate(-50%, -50%) translateY(${yOffset}%) translateZ(${zMove}px) scale(${scale})`;--}}
{{--                    thumb.style.pointerEvents = "auto";--}}
{{--                    thumb.style.display = "block";--}}
{{--                } else if (relativeIndex < 0) {--}}
{{--                    // old current / cards leaving screen--}}
{{--                    thumb.style.transition = `transform ${duration}s cubic-bezier(0.22, 1, 0.36, 1), opacity ${duration}s ease`;--}}
{{--                    thumb.style.zIndex = total - visibleAbove - 1;--}}
{{--                    thumb.style.opacity = 0;--}}
{{--                    const exitY = scrollingDown ? 200 : -50;--}}
{{--                    thumb.style.transform = `translate(-50%, -50%) translateY(${exitY}%) translateZ(0px) scale(0.8)`;--}}
{{--                    thumb.style.pointerEvents = "none";--}}
{{--                    thumb.style.display = "block";--}}

{{--                    setTimeout(() => {--}}
{{--                        thumb.style.display = "none";--}}
{{--                    }, duration * 10000);--}}
{{--                } else {--}}
{{--                    // far away cards--}}
{{--                    thumb.style.zIndex = 0;--}}
{{--                    thumb.style.opacity = 0;--}}
{{--                    thumb.style.transform = `translate(-50%, -50%) translateY(-9999px) scale(0.5)`;--}}
{{--                    thumb.style.pointerEvents = "none";--}}
{{--                    thumb.style.display = "none";--}}
{{--                }--}}
{{--            });--}}

{{--            const metaContainer = document.querySelector('.thumb-meta');--}}
{{--            const titleEl = metaContainer.querySelector('.section-heading-child');--}}
{{--            const descEl = metaContainer.querySelector('.thumb-desc');--}}
{{--            const dateEl = metaContainer.querySelector('.thumb-date');--}}

{{--            const activeThumb = thumbs[index];--}}
{{--            titleEl.textContent = activeThumb.dataset.title;--}}
{{--            descEl.textContent = activeThumb.dataset.desc;--}}
{{--            dateEl.textContent = activeThumb.dataset.date;--}}

{{--            // fade in smoothly--}}
{{--            titleEl.style.opacity = 0;--}}
{{--            descEl.style.opacity = 0;--}}
{{--            dateEl.style.opacity = 0;--}}

{{--            setTimeout(() => {--}}
{{--                titleEl.style.transition = "opacity 1s ease";--}}
{{--                descEl.style.transition = "opacity 1s ease";--}}
{{--                dateEl.style.transition = "opacity 1s ease";--}}
{{--                titleEl.style.opacity = 1;--}}
{{--                descEl.style.opacity = 1;--}}
{{--                dateEl.style.opacity = 1;--}}
{{--            }, 50);--}}

{{--            // unlock after the slow entrance finishes--}}
{{--            // setTimeout(() => {--}}
{{--            //     thumbAnimating = false;--}}
{{--            // }, slowDuration * 1000);--}}
{{--        }--}}


{{--        // -------------------- SCROLL HANDLER ----------------------}}
{{--        function handleScroll(dir){--}}
{{--            // if(scrollLock || animating || thumbAnimating) return; // block scroll until thumb animation ends--}}
{{--            if(scrollLock || animating) return; // block scroll until thumb animation ends--}}
{{--            scrollLock = true;--}}

{{--            if(inGallerySection){--}}
{{--                if(dir > 0 && currentThumb < totalThumbs-1){--}}
{{--                    currentThumb++;--}}
{{--                    showThumb(currentThumb, true);--}}
{{--                } else if(dir < 0 && currentThumb > 0){--}}
{{--                    currentThumb--;--}}
{{--                    showThumb(currentThumb, false);--}}
{{--                } else if(currentThumb === 0 && dir < 0){--}}
{{--                    // exit to previous section--}}
{{--                    inGallerySection = false;--}}
{{--                    gotoSection(currentIndex-1, -1);--}}
{{--                }--}}
{{--            } else {--}}
{{--                // Normal section scroll--}}
{{--                if(dir > 0){--}}
{{--                    gotoSection(currentIndex+1, 1);--}}
{{--                } else {--}}
{{--                    gotoSection(currentIndex-1, -1);--}}
{{--                }--}}
{{--            }--}}

{{--            setTimeout(()=> scrollLock=false, 100); // debounce scroll for wheel--}}
{{--        }--}}

{{--        // -------------------- OBSERVER ----------------------}}
{{--        Observer.create({--}}
{{--            type: "wheel,touch,pointer",--}}
{{--            wheelSpeed: -1,--}}
{{--            tolerance: 50,--}}
{{--            preventDefault: true,--}}
{{--            onUp: () => handleScroll(1),--}}
{{--            onDown: () => handleScroll(-1)--}}
{{--        });--}}

{{--        // -------------------- INITIALIZE ----------------------}}
{{--        showThumb(currentThumb);--}}
{{--        gotoSection(0,1);--}}
{{--    </script>--}}
{{--@endpush--}}


