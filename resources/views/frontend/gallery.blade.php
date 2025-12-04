{{--@extends('frontend.partials.master')--}}

{{--@section('title', 'Gallery - Never Ending Trails')--}}

{{--@php--}}
{{--    $hideFooter = true;--}}
{{--@endphp--}}

{{--@section('content')--}}
{{--<!-- Gallery Section -->--}}
{{--        <div class="films-listing-section" id="films-listing-section">--}}
{{--            <div class="films-container" id="films-container">--}}
{{--                @forelse($galleries as $gallery)--}}
{{--                    @php--}}
{{--                        // Build images array: thumbnail first, then child_images--}}
{{--                        $allImages = [];--}}
{{--                        if ($gallery->thumbnail) {--}}
{{--                            $allImages[] = asset($gallery->thumbnail);--}}
{{--                        }--}}
{{--                        if ($gallery->child_images && is_array($gallery->child_images)) {--}}
{{--                            foreach ($gallery->child_images as $childImage) {--}}
{{--                                $childImagePath = is_array($childImage) ? ($childImage['url'] ?? null) : $childImage;--}}
{{--                                if ($childImagePath) {--}}
{{--                                    $childAsset = asset($childImagePath);--}}
{{--                                    if (!in_array($childAsset, $allImages)) {--}}
{{--                                        $allImages[] = $childAsset;--}}
{{--                                    }--}}
{{--                                }--}}
{{--                            }--}}
{{--                        }--}}
{{--                        // If no images, use a placeholder--}}
{{--                        if (empty($allImages)) {--}}
{{--                            $allImages[] = asset('assets/images/specials/1.webp');--}}
{{--                        }--}}
{{--                        $imagesString = implode(',', $allImages);--}}
{{--                        --}}
{{--                        // Get thumbnail or first image--}}
{{--                        $thumbnail = $gallery->thumbnail ? asset($gallery->thumbnail) : (count($allImages) > 0 ? $allImages[0] : asset('assets/images/specials/1.webp'));--}}
{{--                        --}}
{{--                        // Get category name--}}
{{--                        $categoryName = $gallery->category ? $gallery->category->name : 'Uncategorized';--}}
{{--                    @endphp--}}
{{--                    <div class="film-item" data-title="{{$gallery->title}}" data-category="{{$categoryName}}" data-images="{{$imagesString}}" onclick="location.href='{{ route('front.gallery.detail', $gallery->slug) }}'">--}}
{{--                        <div class="film-poster">--}}
{{--                            <img class="film-thumbnail" src="{{$thumbnail}}" alt="{{$gallery->title}}">--}}
{{--                            <div class="film-reel"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @empty--}}
{{--                    <div class="film-item" data-title="No Galleries" data-category="Empty" data-images="{{asset('assets/images/specials/1.webp')}}">--}}
{{--                        <div class="film-poster">--}}
{{--                            <img class="film-thumbnail" src="{{asset('assets/images/specials/1.webp')}}" alt="No Galleries">--}}
{{--                            <div class="film-reel"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforelse--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    --}}
{{--    <script src="{{asset('assets/js/818-js-jquery.min.js')}}"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>--}}
{{--    <script src="{{asset('assets/js/9044-js-jquery-ui.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/js/5348-js-lightgallery.js')}}"></script>--}}
{{--    <script src="{{asset('assets/js/5619-js-jquery.mousewheel.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/js/1096-js-slick.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/js/5706-js-hammer.js')}}"></script>--}}
{{--    <script src="{{asset('assets/js/4412-js-scripts.min.js')}}"></script>--}}
{{--    --}}
{{--    <!-- Gallery Script - Clean Simple Masonry -->--}}
{{--    <script>--}}
{{--        // Optimized Gallery Script - Mobile Friendly with Responsive Columns--}}
{{--        (function() {--}}
{{--            'use strict';--}}

{{--            const style = document.createElement('style');--}}
{{--            style.textContent = `--}}
{{--    .film-thumbnail {--}}
{{--        -webkit-backface-visibility: hidden;--}}
{{--        backface-visibility: hidden;--}}
{{--        -webkit-transform: translateZ(0);--}}
{{--        transform: translateZ(0);--}}
{{--        background-color: transparent !important;--}}
{{--    }--}}

{{--    .film-poster, .film-item {--}}
{{--        background-color: transparent !important;--}}
{{--    }--}}
{{--`;--}}
{{--            document.head.appendChild(style);--}}

{{--            const section = document.getElementById('films-listing-section');--}}
{{--            const container = document.getElementById('films-container');--}}
{{--            const items = Array.from(document.querySelectorAll('.film-item'));--}}

{{--            // Responsive column calculation--}}
{{--            // function getColumnCount() {--}}
{{--            //     const width = window.innerWidth;--}}
{{--            //     if (width < 480) return 1; // Mobile portrait--}}
{{--            //     if (width < 768) return 2; // Mobile landscape / small tablet--}}
{{--            //     return 3; // Desktop--}}
{{--            // }--}}
{{--            function getColumnCount() {--}}
{{--                const width = window.innerWidth;--}}
{{--                const totalItems = items.length;--}}

{{--                // MOBILE--}}
{{--                if (width < 480) return 1;--}}
{{--                if (width < 768) return 2;--}}

{{--                // DESKTOP — AUTO CALCULATE TO AVOID EMPTY SPACES--}}
{{--                if (totalItems <= 3) return totalItems;   // 1, 2, or 3 items fill perfectly--}}
{{--                if (totalItems === 4) return 2;          // ← FIX FOR YOUR ISSUE--}}
{{--                if (totalItems === 5) return 5;          // also solves 5-item gaps--}}
{{--                if (totalItems === 6) return 3;          // balanced layout--}}

{{--                // GENERAL CASE (fallback)--}}
{{--                return Math.min(4, totalItems);--}}
{{--            }--}}

{{--            // Infinite scroll state--}}
{{--            let panX = 0;--}}
{{--            let panY = 0;--}}
{{--            let originalContainerWidth = 0;--}}
{{--            let originalContainerHeight = 0;--}}
{{--            let isPanning = false;--}}
{{--            let panVelocityX = 0;--}}
{{--            let panVelocityY = 0;--}}
{{--            let lastPanTime = 0;--}}
{{--            let columnCount = getColumnCount();--}}

{{--            // Mouse/Touch drag state--}}
{{--            let isDragging = false;--}}
{{--            let dragStartX = 0;--}}
{{--            let dragStartY = 0;--}}
{{--            let dragStartPanX = 0;--}}
{{--            let dragStartPanY = 0;--}}
{{--            let hasMoved = false;--}}
{{--            let isTouchDevice = 'ontouchstart' in window;--}}

{{--            // Hover state (desktop only)--}}
{{--            let isWindowScrolling = false;--}}
{{--            let windowScrollTimer = null;--}}
{{--            let activeHoverItem = null;--}}
{{--            let hoverDelayTimer = null;--}}

{{--            // Window scroll detection--}}
{{--            let lastScrollY = window.pageYOffset || document.documentElement.scrollTop;--}}
{{--            window.addEventListener('scroll', () => {--}}
{{--                const currentScrollY = window.pageYOffset || document.documentElement.scrollTop;--}}
{{--                const scrollDelta = Math.abs(currentScrollY - lastScrollY);--}}
{{--                lastScrollY = currentScrollY;--}}

{{--                if (scrollDelta > 3) {--}}
{{--                    isWindowScrolling = true;--}}
{{--                    clearTimeout(windowScrollTimer);--}}
{{--                    windowScrollTimer = setTimeout(() => {--}}
{{--                        isWindowScrolling = false;--}}
{{--                    }, 150);--}}
{{--                }--}}
{{--            }, { passive: true });--}}

{{--            // Store original item positions--}}
{{--            let originalItemPositions = [];--}}

{{--            // Responsive masonry layout--}}
{{--            function layoutMasonry() {--}}
{{--                const containerWidth = window.innerWidth;--}}
{{--                const containerHeight = window.innerHeight;--}}
{{--                columnCount = getColumnCount();--}}
{{--                const itemWidth = containerWidth / columnCount;--}}
{{--                const columns = new Array(columnCount).fill(0);--}}

{{--                items.forEach((item, index) => {--}}
{{--                    const col = index % columnCount;--}}

{{--                    item.style.width = itemWidth + 'px';--}}
{{--                    item.style.left = (col * itemWidth) + 'px';--}}
{{--                    item.style.top = columns[col] + 'px';--}}
{{--                    item.style.position = 'absolute';--}}

{{--                    const thumbnail = item.querySelector('.film-thumbnail');--}}
{{--                    if (thumbnail && thumbnail.complete && thumbnail.naturalHeight > 0) {--}}
{{--                        const aspectRatio = thumbnail.naturalWidth / thumbnail.naturalHeight;--}}
{{--                        const itemHeight = itemWidth / aspectRatio;--}}
{{--                        columns[col] += itemHeight;--}}
{{--                    } else {--}}
{{--                        const itemHeight = item.offsetHeight || (itemWidth * 1.2);--}}
{{--                        columns[col] += itemHeight;--}}
{{--                    }--}}
{{--                });--}}

{{--                const maxHeight = Math.max(...columns);--}}
{{--                originalContainerWidth = containerWidth;--}}
{{--                originalContainerHeight = maxHeight;--}}

{{--                if (originalContainerWidth > 0 && originalContainerHeight > 0) {--}}
{{--                    createInfiniteScrollArea();--}}
{{--                }--}}
{{--            }--}}

{{--            // Create infinite scroll clones - FILL ENTIRE VIEWPORT--}}
{{--            function createInfiniteScrollArea() {--}}
{{--                const existingClones = container.querySelectorAll('.film-item-clone');--}}
{{--                existingClones.forEach(clone => clone.remove());--}}

{{--                originalItemPositions = [];--}}
{{--                items.forEach((item) => {--}}
{{--                    originalItemPositions.push({--}}
{{--                        left: parseFloat(item.style.left) || 0,--}}
{{--                        top: parseFloat(item.style.top) || 0,--}}
{{--                        width: item.offsetWidth || window.innerWidth / columnCount,--}}
{{--                        height: item.offsetHeight || 400--}}
{{--                    });--}}
{{--                });--}}

{{--                const viewportWidth = originalContainerWidth;--}}
{{--                const viewportHeight = originalContainerHeight;--}}
{{--                const screenWidth = window.innerWidth;--}}
{{--                const screenHeight = window.innerHeight;--}}
{{--                const padding = 100;--}}

{{--                // Calculate how many times we need to repeat content to fill viewport--}}
{{--                const horizontalRepeats = Math.ceil(screenWidth / viewportWidth) + 3;--}}
{{--                const verticalRepeats = Math.ceil(screenHeight / viewportHeight) + 3;--}}

{{--                // Create enough clones to fill and surround viewport--}}
{{--                for (let row = -verticalRepeats; row <= verticalRepeats; row++) {--}}
{{--                    for (let col = -horizontalRepeats; col <= horizontalRepeats; col++) {--}}
{{--                        if (row === 0 && col === 0) continue;--}}

{{--                        items.forEach((originalItem, index) => {--}}
{{--                            const clone = originalItem.cloneNode(true);--}}
{{--                            clone.classList.add('film-item-clone');--}}

{{--                            const pos = originalItemPositions[index];--}}

{{--                            const leftPos = pos.left + col * viewportWidth;--}}
{{--                            const topPos = pos.top + row * viewportHeight;--}}

{{--                            clone.style.left = Math.round(leftPos) + 'px';--}}
{{--                            clone.style.top = Math.round(topPos) + 'px';--}}
{{--                            clone.style.position = 'absolute';--}}
{{--                            clone.style.width = Math.round(pos.width) + 'px';--}}

{{--                            container.appendChild(clone);--}}
{{--                            initializeItemHover(clone);--}}
{{--                        });--}}
{{--                    }--}}
{{--                }--}}

{{--                const minContainerWidth = viewportWidth * (horizontalRepeats * 2 + 1) + padding * 2;--}}
{{--                const minContainerHeight = viewportHeight * (verticalRepeats * 2 + 1) + padding * 2;--}}

{{--                container.style.width = minContainerWidth + 'px';--}}
{{--                container.style.height = minContainerHeight + 'px';--}}
{{--                container.style.left = -padding + 'px';--}}
{{--                container.style.top = -padding + 'px';--}}

{{--                panX = -viewportWidth - padding;--}}
{{--                panY = -viewportHeight - padding;--}}
{{--                applyPanTransform();--}}

{{--                container.offsetHeight;--}}
{{--            }--}}

{{--            // Apply pan transform with seamless wrapping--}}
{{--            function applyPanTransform(skipWrapping = false) {--}}
{{--                const viewportWidth = originalContainerWidth || window.innerWidth;--}}
{{--                const viewportHeight = originalContainerHeight || window.innerHeight;--}}
{{--                const padding = 100;--}}

{{--                if (!skipWrapping && !isDragging) {--}}
{{--                    if (viewportWidth > 0) {--}}
{{--                        const minX = -viewportWidth - padding;--}}
{{--                        const maxX = -padding;--}}

{{--                        if (panX > maxX + 50) {--}}
{{--                            panX -= viewportWidth;--}}
{{--                        } else if (panX < minX - 50) {--}}
{{--                            panX += viewportWidth;--}}
{{--                        }--}}
{{--                    }--}}

{{--                    if (viewportHeight > 0) {--}}
{{--                        const minY = -viewportHeight - padding;--}}
{{--                        const maxY = -padding;--}}

{{--                        if (panY > maxY + 50) {--}}
{{--                            panY -= viewportHeight;--}}
{{--                        } else if (panY < minY - 50) {--}}
{{--                            panY += viewportHeight;--}}
{{--                        }--}}
{{--                    }--}}
{{--                }--}}

{{--                container.style.transform = `translate3d(${panX}px, ${panY}px, 0)`;--}}
{{--                container.style.webkitTransform = `translate3d(${panX}px, ${panY}px, 0)`;--}}
{{--                container.style.transform = `translate3d(${panX}px, ${panY}px, 0)`;--}}
{{--            }--}}

{{--            // Wheel handler (trackpad and mouse wheel)--}}
{{--            section.addEventListener('wheel', (e) => {--}}
{{--                const isTrackpad = Math.abs(e.deltaX) > 0 || (Math.abs(e.deltaY) < 100 && Math.abs(e.deltaY) > 0);--}}

{{--                if (isTrackpad && !e.ctrlKey && !e.metaKey) {--}}
{{--                    e.preventDefault();--}}
{{--                    isPanning = true;--}}

{{--                    container.classList.remove('has-hover');--}}

{{--                    const now = Date.now();--}}
{{--                    const timeDelta = now - lastPanTime;--}}
{{--                    lastPanTime = now;--}}

{{--                    const panSpeed = 1.0;--}}
{{--                    panX -= e.deltaX * panSpeed;--}}
{{--                    panY -= e.deltaY * panSpeed;--}}

{{--                    if (timeDelta > 0) {--}}
{{--                        panVelocityX = -e.deltaX / timeDelta;--}}
{{--                        panVelocityY = -e.deltaY / timeDelta;--}}
{{--                    }--}}

{{--                    applyPanTransform();--}}

{{--                    clearTimeout(panMomentumTimer);--}}
{{--                    panMomentumTimer = setTimeout(() => {--}}
{{--                        isPanning = false;--}}
{{--                        let momentumX = panVelocityX * 15;--}}
{{--                        let momentumY = panVelocityY * 15;--}}
{{--                        const friction = 0.95;--}}

{{--                        function applyMomentum() {--}}
{{--                            if (Math.abs(momentumX) < 0.1 && Math.abs(momentumY) < 0.1) {--}}
{{--                                panVelocityX = 0;--}}
{{--                                panVelocityY = 0;--}}
{{--                                isPanning = false;--}}
{{--                                return;--}}
{{--                            }--}}

{{--                            isPanning = true;--}}
{{--                            panX += momentumX;--}}
{{--                            panY += momentumY;--}}
{{--                            applyPanTransform();--}}

{{--                            momentumX *= friction;--}}
{{--                            momentumY *= friction;--}}
{{--                            requestAnimationFrame(applyMomentum);--}}
{{--                        }--}}
{{--                        applyMomentum();--}}
{{--                    }, 50);--}}
{{--                }--}}
{{--            }, { passive: false });--}}

{{--            let panMomentumTimer = null;--}}

{{--            // Touch events for mobile--}}
{{--            section.addEventListener('touchstart', (e) => {--}}
{{--                if (e.touches.length === 1) {--}}
{{--                    const touch = e.touches[0];--}}
{{--                    dragStartX = touch.clientX;--}}
{{--                    dragStartY = touch.clientY;--}}
{{--                    dragStartPanX = panX;--}}
{{--                    dragStartPanY = panY;--}}
{{--                    hasMoved = false;--}}
{{--                }--}}
{{--            }, { passive: true });--}}

{{--            section.addEventListener('touchmove', (e) => {--}}
{{--                if (e.touches.length === 1) {--}}
{{--                    const touch = e.touches[0];--}}
{{--                    const moveDistance = Math.sqrt(--}}
{{--                        Math.pow(touch.clientX - dragStartX, 2) +--}}
{{--                        Math.pow(touch.clientY - dragStartY, 2)--}}
{{--                    );--}}

{{--                    if (moveDistance > 5) {--}}
{{--                        if (!isDragging) {--}}
{{--                            isDragging = true;--}}
{{--                            isPanning = true;--}}
{{--                            hasMoved = true;--}}
{{--                            e.preventDefault();--}}
{{--                        }--}}

{{--                        const deltaX = touch.clientX - dragStartX;--}}
{{--                        const deltaY = touch.clientY - dragStartY;--}}
{{--                        panX = dragStartPanX + deltaX;--}}
{{--                        panY = dragStartPanY + deltaY;--}}

{{--                        container.style.transition = 'none';--}}
{{--                        container.style.transform = `translate3d(${panX}px, ${panY}px, 0)`;--}}
{{--                        container.style.webkitTransform = `translate3d(${panX}px, ${panY}px, 0)`;--}}
{{--                        container.style.transform = `translate3d(${panX}px, ${panY}px, 0)`;--}}

{{--                        e.preventDefault();--}}
{{--                    }--}}
{{--                }--}}
{{--            }, { passive: false });--}}

{{--            section.addEventListener('touchend', (e) => {--}}
{{--                if (isDragging) {--}}
{{--                    isDragging = false;--}}
{{--                    isPanning = false;--}}

{{--                    container.style.transition = '';--}}
{{--                    applyPanTransform(false);--}}

{{--                    e.preventDefault();--}}
{{--                }--}}

{{--                dragStartX = 0;--}}
{{--                dragStartY = 0;--}}
{{--                hasMoved = false;--}}
{{--            }, { passive: false });--}}

{{--            // Mouse drag handler (desktop)--}}
{{--            section.addEventListener('mousedown', (e) => {--}}
{{--                if (e.button !== 0) return;--}}

{{--                dragStartX = e.clientX;--}}
{{--                dragStartY = e.clientY;--}}
{{--                dragStartPanX = panX;--}}
{{--                dragStartPanY = panY;--}}
{{--                hasMoved = false;--}}

{{--                e.preventDefault();--}}
{{--            });--}}

{{--            document.addEventListener('mousemove', (e) => {--}}
{{--                if (!isDragging && (dragStartX !== 0 || dragStartY !== 0)) {--}}
{{--                    const moveDistance = Math.sqrt(--}}
{{--                        Math.pow(e.clientX - dragStartX, 2) +--}}
{{--                        Math.pow(e.clientY - dragStartY, 2)--}}
{{--                    );--}}

{{--                    if (moveDistance > 3) {--}}
{{--                        isDragging = true;--}}
{{--                        isPanning = true;--}}
{{--                        hasMoved = true;--}}

{{--                        container.classList.remove('has-hover');--}}
{{--                        section.style.cursor = 'grabbing';--}}

{{--                        const deltaX = e.clientX - dragStartX;--}}
{{--                        const deltaY = e.clientY - dragStartY;--}}
{{--                        panX = dragStartPanX + deltaX;--}}
{{--                        panY = dragStartPanY + deltaY;--}}
{{--                        container.style.transform = `translate3d(${panX}px, ${panY}px, 0)`;--}}
{{--                        container.style.transition = 'none';--}}
{{--                    }--}}
{{--                }--}}

{{--                if (isDragging) {--}}
{{--                    const deltaX = e.clientX - dragStartX;--}}
{{--                    const deltaY = e.clientY - dragStartY;--}}

{{--                    panX = dragStartPanX + deltaX;--}}
{{--                    panY = dragStartPanY + deltaY;--}}

{{--                    container.style.transition = 'none';--}}
{{--                    container.style.transform = `translate3d(${panX}px, ${panY}px, 0)`;--}}

{{--                    e.preventDefault();--}}
{{--                    e.stopPropagation();--}}
{{--                }--}}
{{--            });--}}

{{--            document.addEventListener('mouseup', (e) => {--}}
{{--                if (isDragging) {--}}
{{--                    const deltaX = e.clientX - dragStartX;--}}
{{--                    const deltaY = e.clientY - dragStartY;--}}
{{--                    panX = dragStartPanX + deltaX;--}}
{{--                    panY = dragStartPanY + deltaY;--}}
{{--                    container.style.transform = `translate3d(${panX}px, ${panY}px, 0)`;--}}

{{--                    isDragging = false;--}}
{{--                    isPanning = false;--}}

{{--                    container.style.transition = '';--}}
{{--                    applyPanTransform(false);--}}

{{--                    section.style.cursor = '';--}}

{{--                    e.preventDefault();--}}
{{--                }--}}

{{--                dragStartX = 0;--}}
{{--                dragStartY = 0;--}}
{{--                hasMoved = false;--}}
{{--            });--}}

{{--            section.addEventListener('mouseleave', () => {--}}
{{--                if (isDragging) {--}}
{{--                    isDragging = false;--}}
{{--                    isPanning = false;--}}
{{--                    section.style.cursor = '';--}}
{{--                }--}}
{{--            });--}}

{{--            // Quick initial layout - FILL VIEWPORT IMMEDIATELY--}}
{{--            function initQuickLayout() {--}}
{{--                const containerWidth = window.innerWidth;--}}
{{--                const containerHeight = window.innerHeight;--}}
{{--                columnCount = getColumnCount();--}}
{{--                const itemWidth = containerWidth / columnCount;--}}
{{--                const padding = 100;--}}

{{--                const columns = new Array(columnCount).fill(0);--}}

{{--                items.forEach((item, index) => {--}}
{{--                    const col = index % columnCount;--}}
{{--                    const thumbnail = item.querySelector('.film-thumbnail');--}}

{{--                    item.style.width = itemWidth + 'px';--}}
{{--                    item.style.left = (col * itemWidth) + 'px';--}}
{{--                    item.style.top = columns[col] + 'px';--}}
{{--                    item.style.position = 'absolute';--}}

{{--                    let itemHeight = itemWidth * 1.2;--}}
{{--                    if (thumbnail && thumbnail.complete && thumbnail.naturalHeight > 0) {--}}
{{--                        const aspectRatio = thumbnail.naturalWidth / thumbnail.naturalHeight;--}}
{{--                        itemHeight = itemWidth / aspectRatio;--}}
{{--                    }--}}

{{--                    columns[col] += itemHeight;--}}
{{--                });--}}

{{--                const actualContentHeight = Math.max(...columns);--}}
{{--                originalContainerWidth = containerWidth;--}}
{{--                originalContainerHeight = actualContentHeight;--}}

{{--                // Calculate repeats needed to fill viewport--}}
{{--                const horizontalRepeats = Math.ceil(containerWidth / originalContainerWidth) + 3;--}}
{{--                const verticalRepeats = Math.ceil(containerHeight / originalContainerHeight) + 3;--}}

{{--                const initialWidth = originalContainerWidth * (horizontalRepeats * 2 + 1) + padding * 2;--}}
{{--                const initialHeight = originalContainerHeight * (verticalRepeats * 2 + 1) + padding * 2;--}}

{{--                container.style.width = initialWidth + 'px';--}}
{{--                container.style.height = initialHeight + 'px';--}}
{{--                container.style.left = -padding + 'px';--}}
{{--                container.style.top = -padding + 'px';--}}

{{--                createQuickClones();--}}

{{--                panX = -originalContainerWidth - padding;--}}
{{--                panY = -originalContainerHeight - padding;--}}
{{--                applyPanTransform();--}}
{{--            }--}}

{{--            function createQuickClones() {--}}
{{--                const existingClones = container.querySelectorAll('.film-item-clone');--}}
{{--                existingClones.forEach(clone => clone.remove());--}}

{{--                const viewportWidth = originalContainerWidth;--}}
{{--                const viewportHeight = originalContainerHeight;--}}
{{--                const screenWidth = window.innerWidth;--}}
{{--                const screenHeight = window.innerHeight;--}}

{{--                const itemPositions = [];--}}
{{--                items.forEach((item) => {--}}
{{--                    itemPositions.push({--}}
{{--                        left: parseFloat(item.style.left) || 0,--}}
{{--                        top: parseFloat(item.style.top) || 0,--}}
{{--                        width: parseFloat(item.style.width) || viewportWidth / columnCount,--}}
{{--                        height: item.offsetHeight || 400--}}
{{--                    });--}}
{{--                });--}}

{{--                // Calculate repeats--}}
{{--                const horizontalRepeats = Math.ceil(screenWidth / viewportWidth) + 3;--}}
{{--                const verticalRepeats = Math.ceil(screenHeight / viewportHeight) + 3;--}}

{{--                for (let row = -verticalRepeats; row <= verticalRepeats; row++) {--}}
{{--                    for (let col = -horizontalRepeats; col <= horizontalRepeats; col++) {--}}
{{--                        if (row === 0 && col === 0) continue;--}}

{{--                        items.forEach((originalItem, index) => {--}}
{{--                            const clone = originalItem.cloneNode(true);--}}
{{--                            clone.classList.add('film-item-clone');--}}

{{--                            const pos = itemPositions[index];--}}

{{--                            const leftPos = pos.left + col * viewportWidth;--}}
{{--                            const topPos = pos.top + row * viewportHeight;--}}

{{--                            clone.style.left = Math.round(leftPos) + 'px';--}}
{{--                            clone.style.top = Math.round(topPos) + 'px';--}}
{{--                            clone.style.position = 'absolute';--}}
{{--                            clone.style.width = Math.round(pos.width) + 'px';--}}

{{--                            container.appendChild(clone);--}}
{{--                            initializeItemHover(clone);--}}
{{--                        });--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}

{{--            // Initialize layout--}}
{{--            function init() {--}}
{{--                initQuickLayout();--}}

{{--                const images = container.querySelectorAll('.film-thumbnail');--}}
{{--                let loaded = 0;--}}
{{--                const total = images.length;--}}

{{--                const onComplete = () => {--}}
{{--                    setTimeout(() => {--}}
{{--                        layoutMasonry();--}}
{{--                    }, 100);--}}
{{--                };--}}

{{--                if (total === 0) {--}}
{{--                    onComplete();--}}
{{--                    return;--}}
{{--                }--}}

{{--                images.forEach(img => {--}}
{{--                    if (img.complete && img.naturalHeight > 0) {--}}
{{--                        loaded++;--}}
{{--                        if (loaded === total) onComplete();--}}
{{--                    } else {--}}
{{--                        img.addEventListener('load', () => {--}}
{{--                            loaded++;--}}
{{--                            if (loaded === total) onComplete();--}}
{{--                        });--}}
{{--                        img.addEventListener('error', () => {--}}
{{--                            loaded++;--}}
{{--                            if (loaded === total) onComplete();--}}
{{--                        });--}}
{{--                    }--}}
{{--                });--}}
{{--            }--}}

{{--            if (document.readyState === 'loading') {--}}
{{--                document.addEventListener('DOMContentLoaded', init);--}}
{{--            } else {--}}
{{--                init();--}}
{{--            }--}}

{{--            // Responsive resize handler--}}
{{--            let resizeTimer = null;--}}
{{--            window.addEventListener('resize', () => {--}}
{{--                clearTimeout(resizeTimer);--}}
{{--                resizeTimer = setTimeout(() => {--}}
{{--                    layoutMasonry();--}}

{{--                    const padding = 100;--}}
{{--                    panX = -originalContainerWidth - padding;--}}
{{--                    panY = -originalContainerHeight - padding;--}}
{{--                    applyPanTransform();--}}
{{--                }, 150);--}}
{{--            });--}}

{{--            // Tooltip (desktop only)--}}
{{--            const tooltip = !isTouchDevice ? (() => {--}}
{{--                const t = document.createElement('div');--}}
{{--                t.className = 'film-tooltip';--}}
{{--                t.innerHTML = '<div class="film-tooltip-title"></div><div class="film-tooltip-category"></div>';--}}
{{--                document.body.appendChild(t);--}}
{{--                return t;--}}
{{--            })() : null;--}}

{{--            const tooltipTitle = tooltip ? tooltip.querySelector('.film-tooltip-title') : null;--}}
{{--            const tooltipCategory = tooltip ? tooltip.querySelector('.film-tooltip-category') : null;--}}

{{--            // Initialize hover for item (desktop only)--}}
{{--            function initializeItemHover(item) {--}}
{{--                if (isTouchDevice) return;--}}
{{--                if (!tooltip || !tooltipTitle || !tooltipCategory) return;--}}

{{--                const title = item.dataset.title || '';--}}
{{--                const category = item.dataset.category || '';--}}
{{--                const imagesData = item.dataset.images || '';--}}
{{--                const freshReel = item.querySelector('.film-reel');--}}
{{--                const freshThumbnail = item.querySelector('.film-thumbnail');--}}

{{--                let reelImages = [];--}}
{{--                let currentImageIndex = 0;--}}
{{--                let imageCycleInterval = null;--}}
{{--                let isAnimating = false;--}}
{{--                let imagesLoaded = false;--}}
{{--                let isCurrentlyHovered = false;--}}

{{--                // Setup image reel--}}
{{--                if (imagesData && freshReel && freshThumbnail) {--}}
{{--                    const imagePaths = imagesData.split(',').map(p => p.trim()).filter(p => p);--}}

{{--                    const setupReel = () => {--}}
{{--                        if (!freshThumbnail || imagePaths.length === 0) return;--}}

{{--                        freshReel.innerHTML = '';--}}

{{--                        const thumbWidth = freshThumbnail.offsetWidth;--}}
{{--                        const thumbHeight = freshThumbnail.offsetHeight;--}}

{{--                        if (thumbWidth === 0 || thumbHeight === 0) {--}}
{{--                            setTimeout(setupReel, 50);--}}
{{--                            return;--}}
{{--                        }--}}

{{--                        freshReel.style.width = thumbWidth + 'px';--}}
{{--                        freshReel.style.height = thumbHeight + 'px';--}}

{{--                        let loadedCount = 0;--}}
{{--                        imagePaths.forEach((path, idx) => {--}}
{{--                            const img = document.createElement('img');--}}
{{--                            img.src = path;--}}
{{--                            img.alt = title;--}}

{{--                            img.style.width = thumbWidth + 'px';--}}
{{--                            img.style.height = thumbHeight + 'px';--}}
{{--                            img.style.objectFit = 'cover';--}}
{{--                            img.style.objectPosition = 'center center';--}}

{{--                            if (idx === 0) {--}}
{{--                                img.classList.add('active');--}}
{{--                                gsap.set(img, { opacity: 1, z: 0, rotationX: 0, scale: 1, y: 0 });--}}
{{--                            } else {--}}
{{--                                gsap.set(img, { opacity: 0, z: -150, rotationX: -80, scale: 1, y: '-100%' });--}}
{{--                            }--}}

{{--                            const checkLoaded = () => {--}}
{{--                                loadedCount++;--}}
{{--                                if (loadedCount === imagePaths.length) {--}}
{{--                                    imagesLoaded = true;--}}
{{--                                }--}}
{{--                            };--}}

{{--                            if (img.complete) {--}}
{{--                                checkLoaded();--}}
{{--                            } else {--}}
{{--                                img.addEventListener('load', checkLoaded);--}}
{{--                                img.addEventListener('error', checkLoaded);--}}
{{--                            }--}}

{{--                            freshReel.appendChild(img);--}}
{{--                            reelImages.push(img);--}}
{{--                        });--}}

{{--                        if (imagePaths.length === 0) {--}}
{{--                            imagesLoaded = true;--}}
{{--                        }--}}
{{--                    };--}}

{{--                    if (freshThumbnail.complete && freshThumbnail.offsetWidth > 0) {--}}
{{--                        setupReel();--}}
{{--                    } else {--}}
{{--                        const checkThumbnail = () => {--}}
{{--                            if (freshThumbnail.offsetWidth > 0) {--}}
{{--                                setupReel();--}}
{{--                            } else {--}}
{{--                                setTimeout(checkThumbnail, 50);--}}
{{--                            }--}}
{{--                        };--}}
{{--                        freshThumbnail.addEventListener('load', checkThumbnail);--}}
{{--                        freshThumbnail.addEventListener('error', checkThumbnail);--}}
{{--                        setTimeout(() => {--}}
{{--                            if (freshThumbnail.offsetWidth === 0) {--}}
{{--                                setupReel();--}}
{{--                            }--}}
{{--                        }, 500);--}}
{{--                    }--}}
{{--                }--}}

{{--                // Image animation--}}
{{--                const animateToNext = () => {--}}
{{--                    if (isAnimating || reelImages.length <= 1 || !isCurrentlyHovered) return;--}}
{{--                    isAnimating = true;--}}

{{--                    if (currentImageIndex < reelImages.length - 1) {--}}
{{--                        const current = reelImages[currentImageIndex];--}}
{{--                        const next = reelImages[currentImageIndex + 1];--}}

{{--                        gsap.to(current, {--}}
{{--                            y: -1,--}}
{{--                            z: -8,--}}
{{--                            rotationX: 1,--}}
{{--                            scale: 1,--}}
{{--                            duration: 0.3,--}}
{{--                            ease: 'power2.out'--}}
{{--                        });--}}
{{--                        current.classList.remove('active');--}}
{{--                        current.classList.add('stack');--}}
{{--                        current.style.zIndex = currentImageIndex + 1;--}}

{{--                        gsap.set(next, {--}}
{{--                            y: '-100%',--}}
{{--                            z: -100,--}}
{{--                            rotationX: -60,--}}
{{--                            scale: 1,--}}
{{--                            opacity: 0--}}
{{--                        });--}}
{{--                        next.style.transformOrigin = 'center bottom';--}}
{{--                        next.classList.add('active');--}}
{{--                        next.style.zIndex = currentImageIndex + 10;--}}

{{--                        gsap.to(next, {--}}
{{--                            y: 0,--}}
{{--                            z: 0,--}}
{{--                            rotationX: 0,--}}
{{--                            scale: 1,--}}
{{--                            opacity: 1,--}}
{{--                            duration: 0.3,--}}
{{--                            ease: 'power2.out',--}}
{{--                            onComplete: () => {--}}
{{--                                isAnimating = false;--}}
{{--                            }--}}
{{--                        });--}}

{{--                        currentImageIndex++;--}}
{{--                    } else {--}}
{{--                        reelImages.forEach((img, idx) => {--}}
{{--                            gsap.to(img, {--}}
{{--                                opacity: 0,--}}
{{--                                y: '100%',--}}
{{--                                z: -100,--}}
{{--                                rotationX: 60,--}}
{{--                                scale: 1,--}}
{{--                                duration: 0.2,--}}
{{--                                ease: 'power2.in',--}}
{{--                                onComplete: () => {--}}
{{--                                    img.classList.remove('active', 'stack');--}}
{{--                                    if (idx === 0) {--}}
{{--                                        gsap.set(img, {--}}
{{--                                            opacity: 0,--}}
{{--                                            y: '-100%',--}}
{{--                                            z: -100,--}}
{{--                                            rotationX: -60,--}}
{{--                                            scale: 1--}}
{{--                                        });--}}
{{--                                        img.style.transformOrigin = 'center bottom';--}}
{{--                                        img.classList.add('active');--}}
{{--                                        img.style.zIndex = 10;--}}

{{--                                        gsap.to(img, {--}}
{{--                                            opacity: 1,--}}
{{--                                            y: 0,--}}
{{--                                            z: 0,--}}
{{--                                            rotationX: 0,--}}
{{--                                            scale: 1,--}}
{{--                                            duration: 0.3,--}}
{{--                                            ease: 'power2.out',--}}
{{--                                            onComplete: () => {--}}
{{--                                                isAnimating = false;--}}
{{--                                            }--}}
{{--                                        });--}}
{{--                                    }--}}
{{--                                }--}}
{{--                            });--}}
{{--                        });--}}
{{--                        currentImageIndex = 0;--}}
{{--                    }--}}
{{--                };--}}

{{--                // Mouse enter--}}
{{--                item.addEventListener('mouseenter', (e) => {--}}
{{--                    if (activeHoverItem === item && imageCycleInterval) {--}}
{{--                        tooltip.style.left = (e.clientX + 15) + 'px';--}}
{{--                        tooltip.style.top = (e.clientY - 10) + 'px';--}}
{{--                        return;--}}
{{--                    }--}}

{{--                    activeHoverItem = item;--}}
{{--                    isCurrentlyHovered = true;--}}

{{--                    clearTimeout(hoverDelayTimer);--}}

{{--                    if (isWindowScrolling || isPanning) {--}}
{{--                        return;--}}
{{--                    }--}}

{{--                    hoverDelayTimer = setTimeout(() => {--}}
{{--                        if (isWindowScrolling || isPanning || activeHoverItem !== item) return;--}}

{{--                        if (!activeHoverItem || activeHoverItem === item) {--}}
{{--                            container.classList.add('has-hover');--}}
{{--                        }--}}

{{--                        tooltipTitle.textContent = title;--}}
{{--                        tooltipCategory.textContent = category;--}}
{{--                        tooltip.style.left = (e.clientX + 15) + 'px';--}}
{{--                        tooltip.style.top = (e.clientY - 10) + 'px';--}}
{{--                        tooltip.classList.add('show');--}}

{{--                        if (imagesLoaded && reelImages.length > 1 && !imageCycleInterval) {--}}
{{--                            currentImageIndex = 0;--}}
{{--                            isAnimating = false;--}}

{{--                            reelImages.forEach((img, idx) => {--}}
{{--                                gsap.killTweensOf(img);--}}
{{--                                img.classList.remove('active', 'stack');--}}

{{--                                if (idx === 0) {--}}
{{--                                    gsap.set(img, { opacity: 1, z: 0, rotationX: 0, scale: 1, y: 0 });--}}
{{--                                    img.classList.add('active');--}}
{{--                                    img.style.zIndex = 10;--}}
{{--                                } else {--}}
{{--                                    gsap.set(img, { opacity: 0, z: -150, rotationX: -80, scale: 1, y: '-100%' });--}}
{{--                                }--}}
{{--                            });--}}

{{--                            imageCycleInterval = setInterval(() => {--}}
{{--                                if (!isWindowScrolling && activeHoverItem === item && isCurrentlyHovered) {--}}
{{--                                    animateToNext();--}}
{{--                                }--}}
{{--                            }, 150);--}}

{{--                            setTimeout(() => {--}}
{{--                                if (!isWindowScrolling && activeHoverItem === item && isCurrentlyHovered && reelImages.length > 1) {--}}
{{--                                    animateToNext();--}}
{{--                                }--}}
{{--                            }, 50);--}}
{{--                        }--}}
{{--                    }, 200);--}}
{{--                });--}}

{{--                // Mouse leave--}}
{{--                item.addEventListener('mouseleave', () => {--}}
{{--                    isCurrentlyHovered = false;--}}
{{--                    clearTimeout(hoverDelayTimer);--}}

{{--                    if (activeHoverItem === item) {--}}
{{--                        activeHoverItem = null;--}}
{{--                        container.classList.remove('has-hover');--}}
{{--                    }--}}

{{--                    tooltip.classList.remove('show');--}}

{{--                    if (imageCycleInterval) {--}}
{{--                        clearInterval(imageCycleInterval);--}}
{{--                        imageCycleInterval = null;--}}
{{--                    }--}}

{{--                    isAnimating = false;--}}
{{--                    reelImages.forEach(img => {--}}
{{--                        gsap.killTweensOf(img);--}}
{{--                    });--}}

{{--                    if (reelImages.length > 0) {--}}
{{--                        reelImages.forEach((img, idx) => {--}}
{{--                            img.classList.remove('active', 'stack');--}}
{{--                            if (idx === 0) {--}}
{{--                                gsap.set(img, { opacity: 1, z: 0, rotationX: 0, scale: 1, y: 0 });--}}
{{--                                img.classList.add('active');--}}
{{--                                img.style.zIndex = 10;--}}
{{--                            } else {--}}
{{--                                gsap.set(img, { opacity: 0, z: -150, rotationX: -80, scale: 1, y: '-100%' });--}}
{{--                            }--}}
{{--                        });--}}
{{--                        currentImageIndex = 0;--}}
{{--                    }--}}
{{--                });--}}
{{--            }--}}

{{--            // Initialize items with hover--}}
{{--            items.forEach((item) => {--}}
{{--                initializeItemHover(item);--}}
{{--            });--}}
{{--        })();--}}
{{--    </script>--}}
{{--@endsection--}}



@extends('frontend.partials.master')

@section('title', 'Gallery - Never Ending Trails')
@push('styles')
    <style>
        @import url("https://fonts.cdnfonts.com/css/thegoodmonolith");
        @font-face {
            font-family: "PPNeueMontreal";
            src: url("https://assets.codepen.io/7558/PPNeueMontreal-Variable.woff2")
            format("woff2");
            font-weight: 100 900;
            font-style: normal;
        }

        :root {
            --spacing-base: 1rem;
            --spacing-md: 1.5rem;
            --spacing-lg: 2rem;
            --color-text: #ffffff;
            --color-text-dim: 0.6;
            --transition-medium: 0.3s ease;
            --font-size-base: 14px;
        }

        /** {*/
        /*    margin: 0;*/
        /*    padding: 0;*/
        /*    box-sizing: border-box;*/
        /*    -webkit-user-select: none;*/
        /*    -moz-user-select: none;*/
        /*    -ms-user-select: none;*/
        /*    user-select: none;*/
        /*}*/

        body {
            font-family: "PPNeueMontreal", sans-serif;
            background: #000;
            overflow: hidden;
            height: 100vh;
            cursor: -webkit-grab;
            cursor: grab;
        }

        body.dragging {
            cursor: -webkit-grabbing;
            cursor: grabbing;
        }

        body.zoom-mode {
            cursor: default;
        }

        .preloader-overlay {
            background: #000;
        }

        /* Header and Footer */
        .header,
        .footer {
            position: fixed;
            left: 0;
            width: 100vw;
            padding: 1.5rem;
            z-index: 10000;
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            -moz-column-gap: var(--spacing-base);
            column-gap: var(--spacing-base);
            pointer-events: none;
            opacity: 0;
            background: transparent!important;
        }

        .header > *,
        .footer > * {
            pointer-events: auto;
        }

        .header {
            top: 0;
        }

        .footer {
            bottom: 0;
        }

        /* Grid column assignments */
        .nav-section {
            grid-column: 1 / span 3;
        }

        .values-section {
            grid-column: 5 / span 2;
        }

        .location-section {
            grid-column: 7 / span 2;
        }

        .contact-section {
            grid-column: 9 / span 2;
        }

        .social-section {
            grid-column: 11 / span 2;
            text-align: right;
        }

        /* Bottom bar */
        .coordinates-section {
            grid-column: 1 / span 3;
            font-family: "TheGoodMonolith", monospace;
        }

        .info-section {
            grid-column: 9 / span 4;
            text-align: right;
        }

        /* ===== LOGO COMPONENT ===== */
        .logo-container {
            margin-bottom: var(--spacing-md);
            display: block;
            width: 3rem;
            height: 1.5rem;
            position: relative;
            cursor: pointer;
        }

        .logo-circles {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            transition: transform var(--transition-medium);
            width: 1.4rem;
            height: 1.4rem;
            background-color: var(--color-text);
            top: 50%;
        }

        .circle-1 {
            left: 0;
            transform: translate(0, -50%);
        }

        .circle-2 {
            left: 0.8rem;
            transform: translate(0, -50%);
            mix-blend-mode: exclusion;
        }

        .logo-container:hover .circle-1 {
            transform: translate(-0.5rem, -50%);
        }

        .logo-container:hover .circle-2 {
            transform: translate(0.5rem, -50%);
        }

        /* Key hint styling */
        .key-hint {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            border: 1px solid var(--color-text);
            border-radius: 3px;
            font-size: 12px;
            margin: 0 3px;
            min-width: 20px;
            height: 20px;
        }

        /* Footer text styling */
        .footer p {
            font-family: "TheGoodMonolith", monospace;
        }

        /* Global link styling */
        a {
            position: relative;
            cursor: pointer;
            color: var(--color-text);
            padding: 0;
            display: inline-block;
            z-index: 1;
            text-decoration: none;
            font-size: var(--font-size-base);
            opacity: 1;
            transition: color var(--transition-medium);
            font-weight: 700;
        }

        a::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background-color: var(--color-text);
            z-index: -1;
            transition: width 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        a:hover::after {
            width: 100%;
        }

        a:hover {
            color: black;
            mix-blend-mode: difference;
            opacity: 1;
        }

        .main-navbar a:hover {
            color: #ffffff;
            /*mix-blend-mode: difference;*/
            /*opacity: 1;*/
        }

        .main-navbar a::after{
            contain: none;
            background-color: transparent;
        }

        p {
            display: block;
            text-decoration: none;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: -0.01rem;
            -webkit-font-smoothing: antialiased;
        }

        ul {
            list-style: none;
        }

        h3 {
            font-size: 14px;
            margin-bottom: var(--spacing-base);
            font-weight: 600;
            color: #fff;
        }

        .viewport {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            z-index: 1;
            opacity: 0;
        }

        .canvas-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            transform-origin: 0 0;
            will-change: transform;
            isolation: isolate;
        }

        .grid-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .grid-item {
            position: absolute;
            width: 320px;
            height: 320px;
            background: #000;
            cursor: pointer;
            will-change: transform, opacity;
            z-index: 1;
            opacity: 1;
            transition: opacity 0.6s ease;
        }

        .grid-item.out-of-view {
            opacity: 0.1;
        }

        .grid-item.selected {
            z-index: 2 !important;
        }

        .grid-item img {
            width: 100%;
            height: 100%;
            -o-object-fit: cover;
            object-fit: cover;
            display: block;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            pointer-events: none;
        }

        /* Split Screen Layout */
        .split-screen-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            z-index: 2;
            opacity: 0;
            pointer-events: none;
        }

        .split-screen-container.active {
            opacity: 1;
            pointer-events: all;
        }

        .split-left {
            position: relative;
            width: 50vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1;
            cursor: pointer;
        }

        .split-right {
            position: relative;
            width: 50vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1;
            cursor: pointer;
        }

        /* Image target - BEHIND the scaling image */
        .zoom-target {
            width: 100%;
            height: 100%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        /* Image title overlay - positioned at bottom left */
        .image-title-overlay {
            position: absolute;
            bottom: 40px;
            left: 40px;
            transform: none;
            color: white;
            z-index: 4;
            opacity: 0;
            pointer-events: none;
            width: min-content;
        }

        .image-title-overlay.active {
            opacity: 0;
        }

        .image-slide-number {
            position: relative;
            width: 400px;
            height: 20px;
            margin-bottom: 0.5em;
            -webkit-clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%);
            clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%);
            overflow: hidden;
        }

        .image-slide-number span {
            position: absolute;
            top: 0;
            left: 0;
            color: white;
            font-family: "TheGoodMonolith", monospace;
            font-size: 12px;
            font-weight: 400;
            line-height: 1.5;
            transform: translateY(0px);
            will-change: transform;
            margin: 0;
            padding: 0;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .image-slide-title {
            position: relative;
            width: 400px;
            height: 60px;
            margin-bottom: 1em;
            -webkit-clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%);
            clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%);
            overflow: hidden;
        }

        .image-slide-title h1 {
            position: absolute;
            top: 0;
            left: 0;
            color: white;
            font-family: "PPNeueMontreal", sans-serif;
            font-size: 48px;
            font-weight: 500;
            letter-spacing: -0.02em;
            line-height: 1.2;
            transform: translateY(0px);
            will-change: transform;
            margin: 0;
            padding: 0;
        }

        .image-slide-description {
            position: relative;
            width: 400px;
            min-height: 80px;
            -webkit-clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%);
            clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%);
            overflow: hidden;
        }

        .description-line {
            position: relative;
            display: block;
            color: rgba(255, 255, 255, 0.8);
            font-family: "PPNeueMontreal", sans-serif;
            font-size: 16px;
            font-weight: 300;
            line-height: 1.4;
            transform: translateY(0px);
            will-change: transform;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        @media (max-width: 900px) {
            .image-title-overlay {
                bottom: 20px;
                left: 20px;
            }

            .image-slide-number {
                width: 300px;
                height: 18px;
            }

            .image-slide-number span {
                font-size: 10px;
            }

            .image-slide-title {
                width: 300px;
                height: 50px;
            }

            .image-slide-title h1 {
                font-size: 36px;
            }

            .image-slide-description {
                width: 300px;
                min-height: 70px;
            }

            .description-line {
                font-size: 14px;
            }
        }

        /* Hide placeholder when active */
        .split-screen-container.active .zoom-target::before {
            display: none;
        }

        .zoom-target::before {
            content: "IMAGE TARGET";
            color: rgba(255, 255, 255, 0.5);
            font-family: "TheGoodMonolith", monospace;
            font-size: 0.75em;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .controls-container {
            position: fixed;
            bottom: 1.25em;
            left: 50%;
            width: auto;
            transform: translateX(-50%);
            display: flex;
            z-index: 6;
            opacity: 0;
            transition: left 1.2s cubic-bezier(0.87, 0, 0.13, 1);
        }

        .controls-container.visible {
            opacity: 1;
        }

        .controls-container.split-mode {
            left: 75%;
        }

        .percentage-indicator {
            background-color: #f0f0f0;
            background-image: radial-gradient(rgba(0, 0, 0, 0.015) 1px, transparent 0);
            background-size: 0.44em 0.44em;
            background-position: -0.06em -0.06em;
            padding: 0.625em 1.25em;
            border-radius: 0.25em;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "TheGoodMonolith", monospace;
            font-size: 0.75em;
            font-weight: 400;
            text-transform: uppercase;
            color: #333;
            min-width: 5em;
            white-space: nowrap;
        }

        .switch {
            display: flex;
            gap: 1.25em;
            background-color: #222;
            background-image: radial-gradient(
                    rgba(255, 255, 255, 0.015) 1px,
                    transparent 0
            );
            background-size: 0.44em 0.44em;
            background-position: -0.06em -0.06em;
            padding: 0.625em 1.25em;
            border-radius: 0.25em;
            transition: padding 0.3s ease-in-out;
        }

        .sound-toggle {
            background-color: #f0f0f0;
            background-image: radial-gradient(rgba(0, 0, 0, 0.015) 1px, transparent 0);
            background-size: 0.44em 0.44em;
            background-position: -0.06em -0.06em;
            padding: 0.5em 0.75em;
            border-radius: 0.25em;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 3.75em;
            position: relative;
            border-color: transparent;
        }

        .sound-wave-canvas {
            width: 2em;
            height: 1em;
            border: none !important;
            outline: none !important;
            background: none !important;
        }

        .sound-toggle.active .sound-wave-canvas {
            opacity: 1;
        }

        .sound-toggle:hover .sound-wave-canvas {
            opacity: 0.8;
        }

        .switch-button {
            background: none;
            border: none;
            border-color: transparent;
            color: #666;
            cursor: pointer;
            font-family: "TheGoodMonolith", monospace;
            font-size: 0.75em;
            font-weight: 400;
            text-transform: uppercase;
            padding: 5px 10px;
            position: relative;
            transition: all 0.3s ease-in-out;
            white-space: nowrap;
        }

        .switch-button-current {
            color: #f0f0f0;
        }

        .indicator-dot {
            position: absolute;
            width: 5px;
            height: 5px;
            background-color: #f0f0f0;
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            top: 50%;
            transform: translateY(-50%);
            left: -8px;
        }

        .switch-button:hover .indicator-dot {
            opacity: 1;
        }

        /* Simple 64px white arrow button */
        .close-button {
            position: fixed;
            top: 50%;
            right: 20px;
            width: 64px;
            height: 64px;
            background: none;
            border: none;
            border-color: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
            opacity: 0;
            pointer-events: none;
            transform: translate(40px, -50%);
        }

        .close-button.active,.redirect-button.active {
            pointer-events: all;
        }

        .close-button:hover,.redirect-button:hover {
            opacity: 0.7;
        }

        .close-button svg {
            width: 64px;
            height: 64px;
            transform: rotate(180deg);
        }

        .redirect-button svg {
            width: 64px;
            height: 64px;
        }

        .redirect-button {
            position: fixed;
            top: 70%;
            left: 45%;
            width: 64px;
            height: 64px;
            background: none;
            border: none;
            border-color: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
            opacity: 0;
            pointer-events: none;
            transform: translate(40px, -50%);
        }


        /* Scaling image overlay */
        .scaling-image-overlay {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 3;
            pointer-events: none;
            will-change: transform;
            opacity: 1 !important;
        }

        .scaling-image-overlay img {
            width: 100%;
            height: 100%;
            -o-object-fit: cover;
            object-fit: cover;
            display: block;
        }

        /* Page vignette effect */
        .page-vignette-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9998;
        }

        .page-vignette-extreme {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            mix-blend-mode: overlay;
            background: linear-gradient(
                    to bottom,
                    rgba(0, 0, 0, 0.9) 0%,
                    rgba(0, 0, 0, 0.5) 20%,
                    transparent 40%
            );
        }
    </style>

    <script>
        window.console = window.console || function(t) {};
    </script>

@endpush

@php
$hideFooter = true;
@endphp

@section('content')
    <!-- Preloader -->
    <div id="preloader-overlay"></div>

    <!-- Main Viewport -->
    <div class="viewport" id="viewport">
        <div class="canvas-wrapper" id="canvasWrapper">
            <div class="grid-container" id="gridContainer">
                <!-- Grid items will be generated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Split Screen Container -->
    <div class="split-screen-container" id="splitScreenContainer">
        <div class="split-left" id="splitLeft">
            <div class="zoom-target" id="zoomTarget"></div>
        </div>
        <div class="split-right" id="splitRight">
            <!-- Right panel content -->
        </div>
    </div>

    <!-- Image Title Overlay -->
    <div class="image-title-overlay" id="imageTitleOverlay">
        <div class="image-slide-number" id="imageSlideNumber">
            <span>01</span>
        </div>
        <div class="image-slide-title" id="imageSlideTitle">
            <h1>Fashion Portrait</h1>
        </div>
        <div class="image-slide-description" id="imageSlideDescription">
            <!-- Lines will be generated dynamically -->
        </div>
    </div>

    <!-- Simple 64px white arrow button -->
    <button class="close-button" id="closeButton">
        <svg width="64" height="64" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.89873 16L6.35949 14.48L11.8278 9.08H0V6.92H11.8278L6.35949 1.52L7.89873 0L16 8L7.89873 16Z" fill="white" />
        </svg>
    </button>

    <!-- Simple 64px white arrow button -->
    <button class="redirect-button" id="redirectButton">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 20 20" fill="none">
            <path d="M10 20A10 10 0 1 0 0 10a10 10 0 0 0 10 10zM8.711 4.3l5.7 5.766L8.7 15.711l-1.4-1.422 4.289-4.242-4.3-4.347z" fill="white"/>
        </svg>

    </button>

    <!-- Controls Container -->
    <div class="controls-container" id="controlsContainer">
        <div class="percentage-indicator" id="percentageIndicator">
            60%
        </div>
        <div class="switch" id="controls">
            <button class="switch-button" onclick="gallery.setZoom(0.3, this)">
                <span class="indicator-dot"></span>
                ZOOM OUT
            </button>
            <button class="switch-button switch-button-current" onclick="gallery.setZoom(0.6, this)">
                <span class="indicator-dot"></span>
                NORMAL
            </button>
            <button class="switch-button" onclick="gallery.setZoom(1.0, this)">
                <span class="indicator-dot"></span>
                ZOOM IN
            </button>
            <button class="switch-button" onclick="gallery.autoFitZoom(this)">
                <span class="indicator-dot"></span>
                FIT
            </button>
        </div>
        <button class="sound-toggle" id="soundToggle">
            <canvas class="sound-wave-canvas" id="soundWaveCanvas" width="32" height="16"></canvas>
        </button>
    </div>

    <!-- Footer Navigation -->
{{--    <div class="footer">--}}
{{--        <div class="info-section">--}}
{{--            <p>Browse Photo Albums</p>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Page vignette effects -->
    <div class="page-vignette-container">
        <div class="page-vignette-extreme"></div>
    </div>
@endsection
@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/Draggable.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/InertiaPlugin.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/CustomEase.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/Flip.min.js'></script>
    <script id="rendered-js" >
        // Register GSAP plugins
        gsap.registerPlugin(Draggable, InertiaPlugin, CustomEase, Flip);

        class PreloaderManager {
            constructor() {
                this.overlay = null;
                this.canvas = null;
                this.ctx = null;
                this.animationId = null;
                this.startTime = null;
                this.duration = 2000; // 2 seconds
                this.createLoadingScreen();
            }

            createLoadingScreen() {
                this.overlay = document.getElementById("preloader-overlay");
                this.overlay.style.cssText = `
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: #000;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 100000;
    `;

                this.canvas = document.createElement("canvas");
                this.canvas.width = 300;
                this.canvas.height = 300;

                this.ctx = this.canvas.getContext("2d");
                this.overlay.appendChild(this.canvas);

                this.startAnimation();
            }

            startAnimation() {
                const centerX = this.canvas.width / 2;
                const centerY = this.canvas.height / 2;
                let time = 0;
                let lastTime = 0;

                const dotRings = [
                    { radius: 20, count: 8 },
                    { radius: 35, count: 12 },
                    { radius: 50, count: 16 },
                    { radius: 65, count: 20 },
                    { radius: 80, count: 24 }];


                const colors = {
                    primary: "#2C1B14",
                    accent: "#febd12" };


                const hexToRgb = hex => {
                    return [
                        parseInt(hex.slice(1, 3), 16),
                        parseInt(hex.slice(3, 5), 16),
                        parseInt(hex.slice(5, 7), 16)];

                };

                const animate = timestamp => {
                    if (!this.startTime) this.startTime = timestamp;

                    if (!lastTime) lastTime = timestamp;
                    const deltaTime = timestamp - lastTime;
                    lastTime = timestamp;
                    time += deltaTime * 0.001;

                    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

                    // Draw center dot
                    this.ctx.beginPath();
                    this.ctx.arc(centerX, centerY, 3, 0, Math.PI * 2);
                    const rgb = hexToRgb(colors.primary);
                    this.ctx.fillStyle = `rgba(${rgb[0]}, ${rgb[1]}, ${rgb[2]}, 0.9)`;
                    this.ctx.fill();

                    // Draw Line Pulse Wave animation
                    dotRings.forEach((ring, ringIndex) => {
                        for (let i = 0; i < ring.count; i++) {
                            const angle = i / ring.count * Math.PI * 2;
                            const radiusPulse = Math.sin(time * 2 - ringIndex * 0.4) * 3;
                            const x = centerX + Math.cos(angle) * (ring.radius + radiusPulse);
                            const y = centerY + Math.sin(angle) * (ring.radius + radiusPulse);

                            const opacityWave =
                                0.4 + Math.sin(time * 2 - ringIndex * 0.4 + i * 0.2) * 0.6;
                            const isActive = Math.sin(time * 2 - ringIndex * 0.4 + i * 0.2) > 0.6;

                            // Draw line from center to point
                            this.ctx.beginPath();
                            this.ctx.moveTo(centerX, centerY);
                            this.ctx.lineTo(x, y);
                            this.ctx.lineWidth = 0.8;

                            if (isActive) {
                                const accentRgb = hexToRgb(colors.accent);
                                this.ctx.strokeStyle = `rgba(${accentRgb[0]}, ${accentRgb[1]}, ${
                                    accentRgb[2]
                                }, ${opacityWave * 0.7})`;
                            } else {
                                const primaryRgb = hexToRgb(colors.primary);
                                this.ctx.strokeStyle = `rgba(${primaryRgb[0]}, ${primaryRgb[1]}, ${
                                    primaryRgb[2]
                                }, ${opacityWave * 0.5})`;
                            }
                            this.ctx.stroke();

                            // Draw dot at the end of the line
                            this.ctx.beginPath();
                            this.ctx.arc(x, y, 2.5, 0, Math.PI * 2);
                            if (isActive) {
                                const accentRgb = hexToRgb(colors.accent);
                                this.ctx.fillStyle = `rgba(${accentRgb[0]}, ${accentRgb[1]}, ${accentRgb[2]}, ${opacityWave})`;
                            } else {
                                const primaryRgb = hexToRgb(colors.primary);
                                this.ctx.fillStyle = `rgba(${primaryRgb[0]}, ${primaryRgb[1]}, ${primaryRgb[2]}, ${opacityWave})`;
                            }
                            this.ctx.fill();
                        }
                    });

                    // Check if we should complete the loading
                    if (timestamp - this.startTime >= this.duration) {
                        this.complete();
                        return;
                    }

                    this.animationId = requestAnimationFrame(animate);
                };

                this.animationId = requestAnimationFrame(animate);
            }

            complete(onComplete) {
                if (this.animationId) {
                    cancelAnimationFrame(this.animationId);
                }

                if (this.overlay) {
                    this.overlay.style.opacity = "0";
                    this.overlay.style.transition = "opacity 0.8s ease";
                    setTimeout(() => {
                        this.overlay?.remove();
                        if (onComplete) onComplete();
                    }, 800);
                }
            }}


        class FashionGallery {
            constructor() {
                // DOM elements
                this.viewport = document.getElementById("viewport");
                this.canvasWrapper = document.getElementById("canvasWrapper");
                this.gridContainer = document.getElementById("gridContainer");
                this.splitScreenContainer = document.getElementById("splitScreenContainer");
                this.imageTitleOverlay = document.getElementById("imageTitleOverlay");
                this.closeButton = document.getElementById("closeButton");
                this.redirectButton = document.getElementById("redirectButton");
                this.controlsContainer = document.getElementById("controlsContainer");
                this.soundToggle = document.getElementById("soundToggle");
                // Create custom eases
                this.customEase = CustomEase.create("smooth", ".87,0,.13,1");
                this.centerEase = CustomEase.create("center", ".25,.46,.45,.94");
                // Configuration
                this.config = {
                    itemSize: 320,
                    baseGap: 16,
                    rows: 8,
                    cols: 12,
                    currentZoom: 0.6,
                    currentGap: 32 };

                // State
                this.zoomState = {
                    isActive: false,
                    selectedItem: null,
                    flipAnimation: null,
                    scalingOverlay: null };

                this.gridItems = [];
                this.gridDimensions = {};
                this.lastValidPosition = {
                    x: 0,
                    y: 0 };

                this.draggable = null;
                this.viewportObserver = null;
                // Initialize sound system
                this.initSoundSystem();
                // Initialize image data
                this.initImageData();
            }
            initSoundSystem() {
                this.soundSystem = {
                    enabled: false,
                    sounds: {
                        click: new Audio("https://assets.codepen.io/7558/glitch-fx-001.mp3"),
                        open: new Audio("https://assets.codepen.io/7558/click-glitch-001.mp3"),
                        close: new Audio("https://assets.codepen.io/7558/click-glitch-001.mp3"),
                        "zoom-in": new Audio(
                            "https://assets.codepen.io/7558/whoosh-fx-001.mp3"),

                        "zoom-out": new Audio(
                            "https://assets.codepen.io/7558/whoosh-fx-001.mp3"),

                        "drag-start": new Audio(
                            "https://assets.codepen.io/7558/preloader-2s-001.mp3"),

                        "drag-end": new Audio(
                            "https://assets.codepen.io/7558/preloader-2s-001.mp3") },


                    play: soundName => {
                        if (!this.soundSystem.enabled || !this.soundSystem.sounds[soundName])
                            return;
                        try {
                            const audio = this.soundSystem.sounds[soundName];
                            audio.currentTime = 0;
                            audio.play().catch(() => {});
                        } catch (e) {
                            // Silently handle audio errors
                        }
                    },
                    toggle: () => {
                        this.soundSystem.enabled = !this.soundSystem.enabled;
                        this.soundToggle.classList.toggle("active", this.soundSystem.enabled);
                        // Prevent visual conflicts during sound toggle
                        if (this.zoomState.isActive) return;
                        if (this.soundSystem.enabled) {
                            // Delay sound to prevent flashing during visual updates
                            setTimeout(() => {
                                this.soundSystem.play("click");
                            }, 50);
                        }
                    } };

                // Preload sounds
                Object.values(this.soundSystem.sounds).forEach(audio => {
                    audio.preload = "auto";
                    audio.volume = 0.3;
                });
                // Initialize sound wave canvas animation
                this.initSoundWave();
            }
            initSoundWave() {
                const canvas = document.getElementById("soundWaveCanvas");
                if (!canvas) return;
                const ctx = canvas.getContext("2d");
                const width = 32;
                const height = 16;
                const centerY = Math.floor(height / 2);
                let startTime = Date.now();
                let currentAmplitude = this.soundSystem.enabled ? 1 : 0;
                const interpolateColor = (color1, color2, factor) => {
                    const r1 = parseInt(color1.substring(1, 3), 16);
                    const g1 = parseInt(color1.substring(3, 5), 16);
                    const b1 = parseInt(color1.substring(5, 7), 16);
                    const r2 = parseInt(color2.substring(1, 3), 16);
                    const g2 = parseInt(color2.substring(3, 5), 16);
                    const b2 = parseInt(color2.substring(5, 7), 16);
                    const r = Math.round(r1 + factor * (r2 - r1)).
                    toString(16).
                    padStart(2, "0");
                    const g = Math.round(g1 + factor * (g2 - g1)).
                    toString(16).
                    padStart(2, "0");
                    const b = Math.round(b1 + factor * (b2 - b1)).
                    toString(16).
                    padStart(2, "0");
                    return `#${r}${g}${b}`;
                };
                const animate = () => {
                    const targetAmplitude = this.soundSystem.enabled ? 1 : 0;
                    currentAmplitude += (targetAmplitude - currentAmplitude) * 0.08;
                    ctx.clearRect(0, 0, width, height);
                    const time = (Date.now() - startTime) / 1000;
                    const muteFactor = 1 - currentAmplitude;
                    const primaryColor = "#2C1B14";
                    const accentColor = "#A64B23";
                    const muteColor = "#D9C4AA";
                    if (!this.soundSystem.enabled && currentAmplitude < 0.01) {
                        ctx.fillStyle = muteColor;
                        ctx.fillRect(0, centerY, width, 2);
                    } else {
                        ctx.fillStyle = interpolateColor(primaryColor, muteColor, muteFactor);
                        for (let i = 0; i < width; i++) {
                            const x = i - width / 2;
                            const e = Math.exp(-x * x / 50);
                            const y =
                                centerY +
                                Math.cos(x * 0.4 - time * 8) * e * height * 0.35 * currentAmplitude;
                            ctx.fillRect(i, Math.round(y), 1, 2);
                        }
                        ctx.fillStyle = interpolateColor(accentColor, muteColor, muteFactor);
                        for (let i = 0; i < width; i++) {
                            const x = i - width / 2;
                            const e = Math.exp(-x * x / 80);
                            const y =
                                centerY +
                                Math.cos(x * 0.3 - time * 5) * e * height * 0.25 * currentAmplitude;
                            ctx.fillRect(i, Math.round(y), 1, 2);
                        }
                    }
                    requestAnimationFrame(animate);
                };
                animate();
            }
            initImageData() {
                window.galleries = @json($galleries);
                // Fashion portrait images
                this.fashionImages = [];
                this.imageData = [];
                let index = 1;
                // Loop galleries passed from Blade
                window.galleries.forEach(gallery => {

                    // Build image array: thumbnail + child_images
                    let images = [];

                    if (gallery.thumbnail) {
                        images.push(gallery.thumbnail.startsWith("http")
                            ? gallery.thumbnail
                            : `${window.location.origin}/${gallery.thumbnail}`);
                    }

                    if (gallery.child_images && Array.isArray(gallery.child_images)) {
                        gallery.child_images.forEach(img => {
                            const imgUrl = typeof img === "string" ? img : img.url;
                            if (imgUrl) {
                                const full = imgUrl.startsWith("http")
                                    ? imgUrl
                                    : `${window.location.origin}/${imgUrl}`;

                                if (!images.includes(full)) images.push(full);
                            }
                        });
                    }

                    // If nothing found, use fallback
                    if (images.length === 0) {
                        images.push(`${window.location.origin}/assets/images/specials/1.webp`);
                    }

                    // Add to fashionImages (slideshow images)
                    images.forEach(img => {
                        if (!this.fashionImages.includes(img)) {
                            this.fashionImages.push(img);
                        }
                    });

                    // Create imageData entry
                    this.imageData.push({
                        number: String(index).padStart(2, "0"),
                        title: gallery.title ?? "Untitled",
                        slug: gallery.slug ?? "",
                        category: gallery.category?.name ?? "Untitled",
                        images: gallery.child_images ?? [],
                        thumbnail: images[0],
                        description: (gallery.description ?? "No description")
                            .replace(/<\/?[^>]+(>|$)/g, "")
                            .trim(),
                    });

                    index++;
                });
            }
            // Custom line splitting function (since we can't use SplitText)
            splitTextIntoLines(element, text) {
                element.innerHTML = "";
                // Split by sentences and create lines
                const sentences = text.split(/(?<=[.!?])\s+/);
                const lines = [];
                // Create temporary div to measure text width
                const temp = document.createElement("div");
                temp.style.cssText = `
          position: absolute;
          visibility: hidden;
          width: ${element.offsetWidth}px;
          font-family: 'PPNeueMontreal', sans-serif;
          font-size: 16px;
          font-weight: 300;
          line-height: 1.4;
        `;
                document.body.appendChild(temp);
                let currentLine = "";
                sentences.forEach(sentence => {
                    const words = sentence.split(" ");
                    words.forEach(word => {
                        const testLine = currentLine ? `${currentLine} ${word}` : word;
                        temp.textContent = testLine;
                        if (temp.offsetWidth > element.offsetWidth && currentLine) {
                            lines.push(currentLine);
                            currentLine = word;
                        } else {
                            currentLine = testLine;
                        }
                    });
                });
                if (currentLine) {
                    lines.push(currentLine);
                }
                document.body.removeChild(temp);
                // Create line elements
                lines.forEach(lineText => {
                    const lineSpan = document.createElement("span");
                    lineSpan.className = "description-line";
                    lineSpan.textContent = lineText;
                    element.appendChild(lineSpan);
                });
                return element.querySelectorAll(".description-line");
            }
            calculateGapForZoom(zoomLevel) {
                if (zoomLevel >= 1.0) return 0;else
                if (zoomLevel >= 0.6) return 0;else
                    return 0;
            }
            calculateGridDimensions(gap = this.config.currentGap) {
                const totalWidth = this.config.cols * (this.config.itemSize + gap) - gap;
                const totalHeight = this.config.rows * (this.config.itemSize + gap) - gap;
                this.gridDimensions = {
                    width: totalWidth,
                    height: totalHeight,
                    scaledWidth: totalWidth * this.config.currentZoom,
                    scaledHeight: totalHeight * this.config.currentZoom,
                    gap: gap };

                return this.gridDimensions;
            }
            generateGridItems() {
                this.config.currentGap = this.calculateGapForZoom(this.config.currentZoom);
                this.calculateGridDimensions();
                this.canvasWrapper.style.width = this.gridDimensions.width + "px";
                this.canvasWrapper.style.height = this.gridDimensions.height + "px";
                this.gridContainer.innerHTML = "";
                this.gridItems = [];

                let imageIndex = 0;
                for (let row = 0; row < this.config.rows; row++) {
                    for (let col = 0; col < this.config.cols; col++) {
                        const item = document.createElement("div");
                        item.className = "grid-item";

                        // Calculate final grid position
                        const x = col * (this.config.itemSize + this.config.currentGap);
                        const y = row * (this.config.itemSize + this.config.currentGap);

                        // Set to grid position
                        item.style.left = `${x}px`;
                        item.style.top = `${y}px`;

                        // Hide initially - will be positioned and shown in playIntroAnimation
                        item.style.opacity = "0";

                        const imageUrl = this.fashionImages[
                        imageIndex % this.fashionImages.length];

                        imageIndex++;
                        const img = document.createElement("img");
                        img.src = imageUrl;
                        img.alt = `Fashion Portrait ${imageIndex}`;
                        item.appendChild(img);
                        const itemData = {
                            element: item,
                            img: img,
                            row: row,
                            col: col,
                            baseX: x,
                            baseY: y,
                            imageUrl: imageUrl,
                            index: this.gridItems.length };

                        // Add click event for zoom
                        item.addEventListener("click", () => {
                            if (!this.zoomState.isActive) {
                                this.soundSystem.play("click");
                                this.enterZoomMode(itemData);
                            }
                        });
                        this.gridContainer.appendChild(item);
                        this.gridItems.push(itemData);
                    }
                }
            }
            setupViewportObserver() {
                if (this.viewportObserver) {
                    this.viewportObserver.disconnect();
                }
                this.viewportObserver = new IntersectionObserver(
                    entries => {
                        entries.forEach(entry => {
                            // Skip if this is the currently selected item in zoom mode
                            if (
                                this.zoomState.selectedItem &&
                                entry.target === this.zoomState.selectedItem.element)
                            {
                                return;
                            }
                            if (entry.isIntersecting) {
                                entry.target.classList.remove("out-of-view");
                                gsap.to(entry.target, {
                                    opacity: 1,
                                    duration: 0.6,
                                    ease: "power2.out" });

                            } else {
                                entry.target.classList.add("out-of-view");
                                gsap.to(entry.target, {
                                    opacity: 0.1,
                                    duration: 0.6,
                                    ease: "power2.out" });

                            }
                        });
                    },
                    {
                        root: null,
                        threshold: 0.15,
                        rootMargin: "10%" });


                // Observe all grid items
                this.gridItems.forEach(item => {
                    this.viewportObserver.observe(item.element);
                });
            }
            updateTitleOverlay(imageIndex) {
                const data = this.imageData[imageIndex % this.imageData.length];
                //console.log(data);
                const numberElement = document.querySelector("#imageSlideNumber span");
                const titleElement = document.querySelector("#imageSlideTitle h1");
                const descriptionElement = document.getElementById("imageSlideDescription");
                if (numberElement && titleElement && descriptionElement) {
                    numberElement.textContent = data.number;
                    titleElement.textContent = data.title;
                    // Split description into lines
                    this.descriptionLines = this.splitTextIntoLines(
                        descriptionElement,
                        data.description);


                }
                const redirectElement = document.getElementById("redirectButton");

                if (redirectButton) {
                    redirectButton.addEventListener("click", () => {
                        // Make sure data.slug exists for the current image
                        if (data && data.slug) {
                            // Redirect to Laravel gallery route
                            window.location.href = `/gallery/${data.slug}`;
                        }
                    });
                }

            }
            createScalingOverlay(sourceImg) {
                const overlay = document.createElement("div");
                overlay.className = "scaling-image-overlay";
                const img = document.createElement("img");
                img.src = sourceImg.src;
                img.alt = sourceImg.alt;
                overlay.appendChild(img);
                document.body.appendChild(overlay);
                const sourceRect = sourceImg.getBoundingClientRect();
                gsap.set(overlay, {
                    left: sourceRect.left,
                    top: sourceRect.top,
                    width: sourceRect.width,
                    height: sourceRect.height,
                    opacity: 1 });

                return overlay;
            }
            enterZoomMode(selectedItemData) {
                if (this.zoomState.isActive) return;
                this.zoomState.isActive = true;
                this.zoomState.selectedItem = selectedItemData;
                this.soundSystem.play("open");
                // Disable dragging
                if (this.draggable) this.draggable.disable();
                document.body.classList.add("zoom-mode");
                const splitContainer = this.splitScreenContainer;
                const zoomTarget = document.getElementById("zoomTarget");
                splitContainer.classList.add("active");
                gsap.to(splitContainer, {
                    opacity: 1,
                    duration: 1.2,
                    ease: this.customEase });

                this.zoomState.scalingOverlay = this.createScalingOverlay(
                    selectedItemData.img);

                gsap.set(selectedItemData.img, {
                    opacity: 0 });

                this.zoomState.flipAnimation = Flip.fit(
                    this.zoomState.scalingOverlay,
                    zoomTarget,
                    {
                        duration: 1.2,
                        ease: this.customEase,
                        absolute: true,
                        onComplete: () => {
                            this.updateTitleOverlay(selectedItemData.index);
                            const imageTitleOverlay = this.imageTitleOverlay;
                            // Reset positions for animation
                            gsap.set("#imageSlideNumber span", {
                                y: 20,
                                opacity: 0 });

                            gsap.set("#imageSlideTitle h1", {
                                y: 60,
                                opacity: 0 });

                            gsap.set(this.descriptionLines, {
                                y: 80,
                                opacity: 0 });

                            // Show overlay container immediately
                            imageTitleOverlay.classList.add("active");
                            gsap.to(imageTitleOverlay, {
                                opacity: 1,
                                duration: 0.3,
                                ease: "power2.out" });

                            // Animate in number - much sooner
                            gsap.to("#imageSlideNumber span", {
                                duration: 0.8,
                                y: 0,
                                opacity: 1,
                                ease: this.customEase,
                                delay: 0.1 });

                            // Animate in title - sooner
                            gsap.to("#imageSlideTitle h1", {
                                duration: 0.8,
                                y: 0,
                                opacity: 1,
                                ease: this.customEase,
                                delay: 0.15 });

                            // Animate description lines one by one - much sooner
                            gsap.to(this.descriptionLines, {
                                duration: 0.8,
                                y: 0,
                                opacity: 1,
                                ease: this.customEase,
                                delay: 0.2,
                                stagger: 0.15 });

                        } });


                this.controlsContainer.classList.add("split-mode");
                gsap.fromTo(
                    this.closeButton,
                    {
                        x: 40,
                        opacity: 0 },

                    {
                        x: 0,
                        opacity: 1,
                        duration: 0.6,
                        ease: "power2.out",
                        delay: 0.9 });
                this.closeButton.classList.add("active");

                gsap.fromTo(
                    this.redirectButton,
                    {
                        x: 40,
                        opacity: 0 },

                    {
                        x: 0,
                        opacity: 1,
                        duration: 0.6,
                        ease: "power2.out",
                        delay: 0.9 });

                this.redirectButton.classList.add("active");
                // Add event listeners
                document.
                getElementById("splitLeft").
                addEventListener("click", this.handleSplitAreaClick.bind(this));
                document.
                getElementById("splitRight").
                addEventListener("click", this.handleSplitAreaClick.bind(this));
                document.addEventListener("keydown", this.handleZoomKeys.bind(this));
            }
            handleSplitAreaClick(e) {
                if (e.target === e.currentTarget) {
                    this.exitZoomMode();
                }
            }
            exitZoomMode() {
                if (
                    !this.zoomState.isActive ||
                    !this.zoomState.selectedItem ||
                    !this.zoomState.scalingOverlay)

                    return;
                this.soundSystem.play("close");
                document.removeEventListener("keydown", this.handleZoomKeys);
                const splitLeft = document.getElementById("splitLeft");
                const splitRight = document.getElementById("splitRight");
                if (splitLeft)
                    splitLeft.removeEventListener("click", this.handleSplitAreaClick);
                if (splitRight)
                    splitRight.removeEventListener("click", this.handleSplitAreaClick);
                const splitContainer = this.splitScreenContainer;
                const selectedElement = this.zoomState.selectedItem.element;
                const selectedImg = this.zoomState.selectedItem.img;
                if (this.zoomState.flipAnimation) {
                    this.zoomState.flipAnimation.kill();
                }
                // Hide title overlay quickly
                const overlayElement = this.imageTitleOverlay;
                gsap.to(overlayElement, {
                    opacity: 0,
                    duration: 0.3,
                    ease: "power2.out" });

                gsap.to("#imageSlideNumber span", {
                    duration: 0.4,
                    y: -20,
                    opacity: 0,
                    ease: "power2.out" });

                gsap.to("#imageSlideTitle h1", {
                    duration: 0.4,
                    y: -60,
                    opacity: 0,
                    ease: "power2.out" });

                if (this.descriptionLines) {
                    gsap.to(this.descriptionLines, {
                        duration: 0.4,
                        y: -80,
                        opacity: 0,
                        ease: "power2.out",
                        stagger: -0.05,
                        onComplete: () => {
                            overlayElement.classList.remove("active");
                            // Reset all text elements
                            gsap.set("#imageSlideNumber span", {
                                y: 20,
                                opacity: 0 });

                            gsap.set("#imageSlideTitle h1", {
                                y: 60,
                                opacity: 0 });

                            gsap.set(this.descriptionLines, {
                                y: 80,
                                opacity: 0 });

                        } });

                }
                gsap.to(this.closeButton, {
                    duration: 0.3,
                    opacity: 0,
                    x: 40,
                    ease: "power2.in" });

                gsap.to(this.redirectButton, {
                    duration: 0.3,
                    opacity: 0,
                    x: 40,
                    ease: "power2.in" });

                splitContainer.classList.remove("active");
                this.controlsContainer.classList.remove("split-mode");
                gsap.to(splitContainer, {
                    opacity: 0,
                    duration: 0.8,
                    ease: "power2.out" });

                Flip.fit(this.zoomState.scalingOverlay, selectedElement, {
                    duration: 1.2,
                    ease: this.customEase,
                    absolute: true,
                    onComplete: () => {
                        gsap.set(selectedImg, {
                            opacity: 1 });

                        if (this.zoomState.scalingOverlay) {
                            document.body.removeChild(this.zoomState.scalingOverlay);
                            this.zoomState.scalingOverlay = null;
                        }
                        splitContainer.classList.remove("active");
                        document.body.classList.remove("zoom-mode");
                        this.closeButton.classList.remove("active");
                        this.redirectButton.classList.remove("active");
                        if (this.draggable) this.draggable.enable();
                        this.zoomState.isActive = false;
                        this.zoomState.selectedItem = null;
                        this.zoomState.flipAnimation = null;
                    } });

                if (this.zoomState.scalingOverlay) {
                    gsap.to(this.zoomState.scalingOverlay, {
                        opacity: 0.4,
                        duration: 0.8,
                        ease: "power2.out" });

                }
            }
            handleZoomKeys(e) {
                if (!this.zoomState.isActive) return;
                if (e.key === "Escape") {
                    this.exitZoomMode();
                }
            }
            calculateBounds() {
                const vw = window.innerWidth;
                const vh = window.innerHeight;
                const { scaledWidth, scaledHeight } = this.gridDimensions;
                const marginX = this.config.currentGap * this.config.currentZoom;
                const marginY = this.config.currentGap * this.config.currentZoom;
                let minX, maxX, minY, maxY;
                if (scaledWidth <= vw) {
                    const centerX = (vw - scaledWidth) / 2;
                    minX = maxX = centerX;
                } else {
                    maxX = marginX;
                    minX = vw - scaledWidth - marginX;
                }
                if (scaledHeight <= vh) {
                    const centerY = (vh - scaledHeight) / 2;
                    minY = maxY = centerY;
                } else {
                    maxY = marginY;
                    minY = vh - scaledHeight - marginY;
                }
                return {
                    minX,
                    maxX,
                    minY,
                    maxY };

            }
            initDraggable() {
                if (this.draggable) {
                    this.draggable.kill();
                }
                this.calculateGridDimensions(this.config.currentGap);
                const bounds = this.calculateBounds();
                this.draggable = Draggable.create(this.canvasWrapper, {
                    type: "x,y",
                    bounds: bounds,
                    edgeResistance: 0.8,
                    inertia: true,
                    throwProps: {
                        x: {
                            velocity: "auto",
                            resistance: 300,
                            end: endValue => Math.round(endValue) },

                        y: {
                            velocity: "auto",
                            resistance: 300,
                            end: endValue => Math.round(endValue) } },


                    onDragStart: () => {
                        document.body.classList.add("dragging");
                        this.soundSystem.play("drag-start");
                        this.lastValidPosition.x = this.draggable.x;
                        this.lastValidPosition.y = this.draggable.y;
                    },
                    onDrag: () => {
                        this.lastValidPosition.x = this.draggable.x;
                        this.lastValidPosition.y = this.draggable.y;
                    },
                    onDragEnd: () => {
                        document.body.classList.remove("dragging");
                        this.soundSystem.play("drag-end");
                    } })[
                    0];
            }
            handleMouseLeave() {
                if (document.body.classList.contains("dragging")) {
                    document.body.classList.remove("dragging");
                    gsap.to(this.canvasWrapper, {
                        duration: 0.6,
                        x: this.lastValidPosition.x,
                        y: this.lastValidPosition.y,
                        ease: "power2.out" });

                    if (this.draggable) {
                        this.draggable.endDrag();
                    }
                }
            }
            calculateFitZoom() {
                const vw = window.innerWidth;
                const vh = window.innerHeight - 80;
                const currentGap = this.calculateGapForZoom(1.0);
                const gridWidth =
                    this.config.cols * (this.config.itemSize + currentGap) - currentGap;
                const gridHeight =
                    this.config.rows * (this.config.itemSize + currentGap) - currentGap;
                const margin = 40;
                const availableWidth = vw - margin * 2;
                const availableHeight = vh - margin * 2;
                const zoomToFitWidth = availableWidth / gridWidth;
                const zoomToFitHeight = availableHeight / gridHeight;
                const fitZoom = Math.min(zoomToFitWidth, zoomToFitHeight);
                return Math.max(0.1, Math.min(2.0, fitZoom));
            }
            playIntroAnimation() {
                const vw = window.innerWidth;
                const vh = window.innerHeight;
                const screenCenterX = vw / 2;
                const screenCenterY = vh / 2;
                const canvasStyle = getComputedStyle(this.canvasWrapper);
                const canvasMatrix = new DOMMatrix(canvasStyle.transform);
                const canvasX = canvasMatrix.m41;
                const canvasY = canvasMatrix.m42;
                const canvasScale = canvasMatrix.a;
                const centerX =
                    (screenCenterX - canvasX) / canvasScale - this.config.itemSize / 2;
                const centerY =
                    (screenCenterY - canvasY) / canvasScale - this.config.itemSize / 2;

                // Position items at center but keep hidden
                this.gridItems.forEach((itemData, index) => {
                    const zIndex = this.gridItems.length - index;
                    gsap.set(itemData.element, {
                        left: centerX,
                        top: centerY,
                        scale: 0.8,
                        zIndex: zIndex,
                        opacity: 0 // Keep hidden, will fade in during animation
                    });
                });

                // Animate from center to grid positions with fade in
                gsap.to(
                    this.gridItems.map(item => item.element),
                    {
                        duration: 0.2,
                        left: index => this.gridItems[index].baseX,
                        top: index => this.gridItems[index].baseY,
                        scale: 1,
                        opacity: 1, // Add fade in
                        ease: "power2.out",
                        stagger: {
                            amount: 1.5,
                            from: "start",
                            grid: [this.config.rows, this.config.cols] },

                        onComplete: () => {
                            this.gridItems.forEach(itemData => {
                                gsap.set(itemData.element, {
                                    zIndex: 1 });

                            });
                            // Show controls with staggered animation
                            const percentageIndicator = this.controlsContainer.querySelector(
                                ".percentage-indicator");

                            const switchElement = this.controlsContainer.querySelector(".switch");
                            const soundToggle = this.controlsContainer.querySelector(
                                ".sound-toggle");

                            gsap.set(this.controlsContainer, {
                                opacity: 0 });

                            gsap.set(percentageIndicator, {
                                x: "-3em" });

                            gsap.set(switchElement, {
                                y: "2em" });

                            gsap.set(soundToggle, {
                                x: "3em" });

                            const navTimeline = gsap.timeline();
                            navTimeline.to(
                                this.controlsContainer,
                                {
                                    opacity: 1,
                                    duration: 0.5,
                                    ease: "power2.out" },

                                0);

                            navTimeline.to(
                                percentageIndicator,
                                {
                                    x: 0,
                                    duration: 0.2,
                                    ease: "power2.out" },

                                0.25);

                            navTimeline.to(
                                switchElement,
                                {
                                    y: 0,
                                    duration: 0.2,
                                    ease: "power2.out" },

                                0.3);

                            navTimeline.to(
                                soundToggle,
                                {
                                    x: 0,
                                    duration: 0.2,
                                    ease: "power2.out" },

                                0.35);

                            this.controlsContainer.classList.add("visible");
                        } });


            }
            autoFitZoom(buttonElement = null) {
                if (this.zoomState.isActive) {
                    this.exitZoomMode();
                    return;
                }
                const fitZoom = this.calculateFitZoom();
                this.config.currentZoom = fitZoom;
                const newGap = this.calculateGapForZoom(fitZoom);
                this.soundSystem.play(fitZoom < 0.6 ? "zoom-out" : "zoom-in");
                this.calculateGridDimensions(this.config.currentGap);
                const vw = window.innerWidth;
                const vh = window.innerHeight;
                const currentScaledWidth =
                    this.gridDimensions.width * this.config.currentZoom;
                const currentScaledHeight =
                    this.gridDimensions.height * this.config.currentZoom;
                const centerX = (vw - currentScaledWidth) / 2;
                const centerY = (vh - currentScaledHeight) / 2;
                gsap.to(this.canvasWrapper, {
                    duration: 0.6,
                    x: centerX,
                    y: centerY,
                    ease: this.centerEase,
                    onComplete: () => {
                        if (newGap !== this.config.currentGap) {
                            this.gridItems.forEach(itemData => {
                                const newX = itemData.col * (this.config.itemSize + newGap);
                                const newY = itemData.row * (this.config.itemSize + newGap);
                                itemData.baseX = newX;
                                itemData.baseY = newY;
                                gsap.to(itemData.element, {
                                    duration: 1.0,
                                    left: newX,
                                    top: newY,
                                    ease: this.customEase });

                            });
                            const newWidth =
                                this.config.cols * (this.config.itemSize + newGap) - newGap;
                            const newHeight =
                                this.config.rows * (this.config.itemSize + newGap) - newGap;
                            gsap.to(this.canvasWrapper, {
                                duration: 1.0,
                                width: newWidth,
                                height: newHeight,
                                ease: this.customEase });

                            this.config.currentGap = newGap;
                        }
                        this.calculateGridDimensions(newGap);
                        const finalScaledWidth = this.gridDimensions.width * fitZoom;
                        const finalScaledHeight = this.gridDimensions.height * fitZoom;
                        const finalCenterX = (vw - finalScaledWidth) / 2;
                        const finalCenterY = (vh - finalScaledHeight) / 2;
                        gsap.to(this.canvasWrapper, {
                            duration: 1.2,
                            scale: fitZoom,
                            x: finalCenterX,
                            y: finalCenterY,
                            ease: this.customEase,
                            onComplete: () => {
                                this.lastValidPosition.x = finalCenterX;
                                this.lastValidPosition.y = finalCenterY;
                                this.initDraggable();
                            } });

                    } });

                this.updatePercentageIndicator(fitZoom);
                document.querySelectorAll(".switch-button").forEach(btn => {
                    btn.classList.remove("switch-button-current");
                });
                if (buttonElement) {
                    buttonElement.classList.add("switch-button-current");
                }
            }
            updatePercentageIndicator(zoomLevel) {
                const percentage = Math.round(zoomLevel * 100);
                document.getElementById(
                    "percentageIndicator").
                    textContent = `${percentage}%`;
            }
            setZoom(zoomLevel, buttonElement = null) {
                if (this.zoomState.isActive) {
                    this.exitZoomMode();
                    return;
                }
                const newGap = this.calculateGapForZoom(zoomLevel);
                const oldZoom = this.config.currentZoom;
                this.config.currentZoom = zoomLevel;
                this.soundSystem.play(zoomLevel < oldZoom ? "zoom-out" : "zoom-in");
                this.calculateGridDimensions(this.config.currentGap);
                const vw = window.innerWidth;
                const vh = window.innerHeight;
                const currentScaledWidth = this.gridDimensions.width * oldZoom;
                const currentScaledHeight = this.gridDimensions.height * oldZoom;
                const centerX = (vw - currentScaledWidth) / 2;
                const centerY = (vh - currentScaledHeight) / 2;
                gsap.to(this.canvasWrapper, {
                    duration: 0.6,
                    x: centerX,
                    y: centerY,
                    ease: this.centerEase,
                    onComplete: () => {
                        if (newGap !== this.config.currentGap) {
                            this.gridItems.forEach(itemData => {
                                const newX = itemData.col * (this.config.itemSize + newGap);
                                const newY = itemData.row * (this.config.itemSize + newGap);
                                itemData.baseX = newX;
                                itemData.baseY = newY;
                                gsap.to(itemData.element, {
                                    duration: 1.2,
                                    left: newX,
                                    top: newY,
                                    ease: this.customEase });

                            });
                            const newWidth =
                                this.config.cols * (this.config.itemSize + newGap) - newGap;
                            const newHeight =
                                this.config.rows * (this.config.itemSize + newGap) - newGap;
                            gsap.to(this.canvasWrapper, {
                                duration: 1.2,
                                width: newWidth,
                                height: newHeight,
                                ease: this.customEase });

                            this.config.currentGap = newGap;
                        }
                        this.calculateGridDimensions(newGap);
                        const finalScaledWidth = this.gridDimensions.width * zoomLevel;
                        const finalScaledHeight = this.gridDimensions.height * zoomLevel;
                        const finalCenterX = (vw - finalScaledWidth) / 2;
                        const finalCenterY = (vh - finalScaledHeight) / 2;
                        gsap.to(this.canvasWrapper, {
                            duration: 1.2,
                            scale: zoomLevel,
                            x: finalCenterX,
                            y: finalCenterY,
                            ease: this.customEase,
                            onComplete: () => {
                                this.lastValidPosition.x = finalCenterX;
                                this.lastValidPosition.y = finalCenterY;
                                this.calculateGridDimensions(newGap);
                                this.initDraggable();
                            } });

                    } });

                this.updatePercentageIndicator(zoomLevel);
                document.querySelectorAll(".switch-button").forEach(btn => {
                    btn.classList.remove("switch-button-current");
                });
                if (buttonElement) {
                    buttonElement.classList.add("switch-button-current");
                } else {
                    const buttons = document.querySelectorAll(".switch-button");
                    if (zoomLevel === 0.3) buttons[1].classList.add("switch-button-current");else
                    if (zoomLevel === 0.6)
                        buttons[2].classList.add("switch-button-current");else
                    if (zoomLevel === 1.0)
                        buttons[3].classList.add("switch-button-current");
                }
            }
            resetPosition() {
                if (this.zoomState.isActive) {
                    this.exitZoomMode();
                    return;
                }
                this.calculateGridDimensions(this.config.currentGap);
                const vw = window.innerWidth;
                const vh = window.innerHeight;
                const { scaledWidth, scaledHeight } = this.gridDimensions;
                const centerX = (vw - scaledWidth) / 2;
                const centerY = (vh - scaledHeight) / 2;
                gsap.to(this.canvasWrapper, {
                    duration: 1.0,
                    x: centerX,
                    y: centerY,
                    ease: this.centerEase,
                    onComplete: () => {
                        this.lastValidPosition.x = centerX;
                        this.lastValidPosition.y = centerY;
                        this.initDraggable();
                    } });

            }
            init() {
                this.config.currentGap = this.calculateGapForZoom(this.config.currentZoom);
                this.generateGridItems();

                // Set initial opacity for viewport to hide the flash
                gsap.set(this.viewport, { opacity: 0 });

                gsap.set(this.canvasWrapper, {
                    scale: this.config.currentZoom });

                this.calculateGridDimensions(this.config.currentGap);
                const vw = window.innerWidth;
                const vh = window.innerHeight;
                const { scaledWidth, scaledHeight } = this.gridDimensions;
                const centerX = (vw - scaledWidth) / 2;
                const centerY = (vh - scaledHeight) / 2;
                gsap.set(this.canvasWrapper, {
                    x: centerX,
                    y: centerY });

                this.lastValidPosition.x = centerX;
                this.lastValidPosition.y = centerY;
                this.updatePercentageIndicator(this.config.currentZoom);

                // Setup event listeners
                this.setupEventListeners();

                // Fade in viewport, then play animations
                gsap.to(this.viewport, {
                    duration: 0.6,
                    opacity: 1,
                    ease: "power2.inOut",
                    onComplete: () => {
                        this.playIntroAnimation();

                        gsap.to(".header", {
                            duration: 1.2,
                            opacity: 1,
                            ease: "power2.out",
                            delay: 0.8 });


                        gsap.to(".footer", {
                            duration: 1.4,
                            opacity: 1,
                            ease: "power2.out",
                            delay: 1 });


                        setTimeout(() => {
                            this.initDraggable();
                            this.setupViewportObserver();
                        }, 1500);
                    } });

            }
            setupEventListeners() {
                window.addEventListener("resize", () => {
                    setTimeout(() => {
                        this.resetPosition();
                        this.initDraggable();
                    }, 100);
                });
                document.addEventListener("mouseleave", () => this.handleMouseLeave());
                this.viewport.addEventListener("mouseleave", () => this.handleMouseLeave());
                this.closeButton.addEventListener("click", () => this.exitZoomMode());
                this.soundToggle.addEventListener("click", () => this.soundSystem.toggle());
                // Keyboard shortcuts
                document.addEventListener("keydown", e => {
                    if (this.zoomState.isActive) return;
                    switch (e.key) {
                        case "1":
                            this.setZoom(0.3);
                            break;
                        case "2":
                            this.setZoom(0.6);
                            break;
                        case "3":
                            this.setZoom(1.0);
                            break;
                        case "f":
                        case "F":
                            this.autoFitZoom();
                            break;}

                });
            }}

        // Initialize gallery with preloader
        let gallery;
        document.addEventListener("DOMContentLoaded", () => {
            const preloader = new PreloaderManager();

            // Wait for preloader to complete, then initialize gallery
            setTimeout(() => {
                preloader.complete(() => {
                    // Initialize gallery after preloader fades out
                    gallery = new FashionGallery();
                    gallery.init();
                });
            }, 2000); // 2 seconds preloader duration
        });
        //# sourceURL=pen.js
    </script>

@endpush

