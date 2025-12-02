@extends('frontend.partials.master')

@section('title', 'Gallery - Never Ending Trails')

@php
    $hideFooter = true;
@endphp

@section('content')
<!-- Gallery Section -->
        <div class="films-listing-section" id="films-listing-section">
            <div class="films-container" id="films-container">
                @forelse($galleries as $gallery)
                    @php
                        // Build images array: thumbnail first, then child_images
                        $allImages = [];
                        if ($gallery->thumbnail) {
                            $allImages[] = asset($gallery->thumbnail);
                        }
                        if ($gallery->child_images && is_array($gallery->child_images)) {
                            foreach ($gallery->child_images as $childImage) {
                                $childImagePath = is_array($childImage) ? ($childImage['url'] ?? null) : $childImage;
                                if ($childImagePath) {
                                    $childAsset = asset($childImagePath);
                                    if (!in_array($childAsset, $allImages)) {
                                        $allImages[] = $childAsset;
                                    }
                                }
                            }
                        }
                        // If no images, use a placeholder
                        if (empty($allImages)) {
                            $allImages[] = asset('assets/images/specials/1.webp');
                        }
                        $imagesString = implode(',', $allImages);
                        
                        // Get thumbnail or first image
                        $thumbnail = $gallery->thumbnail ? asset($gallery->thumbnail) : (count($allImages) > 0 ? $allImages[0] : asset('assets/images/specials/1.webp'));
                        
                        // Get category name
                        $categoryName = $gallery->category ? $gallery->category->name : 'Uncategorized';
                    @endphp
                    <div class="film-item" data-title="{{$gallery->title}}" data-category="{{$categoryName}}" data-images="{{$imagesString}}" onclick="location.href='{{ route('front.gallery.detail', $gallery->slug) }}'">
                        <div class="film-poster">
                            <img class="film-thumbnail" src="{{$thumbnail}}" alt="{{$gallery->title}}">
                            <div class="film-reel"></div>
                        </div>
                    </div>
                @empty
                    <div class="film-item" data-title="No Galleries" data-category="Empty" data-images="{{asset('assets/images/specials/1.webp')}}">
                        <div class="film-poster">
                            <img class="film-thumbnail" src="{{asset('assets/images/specials/1.webp')}}" alt="No Galleries">
                            <div class="film-reel"></div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

    
    <script src="{{asset('assets/js/818-js-jquery.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="{{asset('assets/js/9044-js-jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/js/5348-js-lightgallery.js')}}"></script>
    <script src="{{asset('assets/js/5619-js-jquery.mousewheel.min.js')}}"></script>
    <script src="{{asset('assets/js/1096-js-slick.min.js')}}"></script>
    <script src="{{asset('assets/js/5706-js-hammer.js')}}"></script>
    <script src="{{asset('assets/js/4412-js-scripts.min.js')}}"></script>
    
    <!-- Gallery Script - Clean Simple Masonry -->
    <script>
        // Optimized Gallery Script - Mobile Friendly with Responsive Columns
        (function() {
            'use strict';

            const style = document.createElement('style');
            style.textContent = `
    .film-thumbnail {
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        background-color: transparent !important;
    }

    .film-poster, .film-item {
        background-color: transparent !important;
    }
`;
            document.head.appendChild(style);

            const section = document.getElementById('films-listing-section');
            const container = document.getElementById('films-container');
            const items = Array.from(document.querySelectorAll('.film-item'));

            // Responsive column calculation
            // function getColumnCount() {
            //     const width = window.innerWidth;
            //     if (width < 480) return 1; // Mobile portrait
            //     if (width < 768) return 2; // Mobile landscape / small tablet
            //     return 3; // Desktop
            // }
            function getColumnCount() {
                const width = window.innerWidth;
                const totalItems = items.length;

                // MOBILE
                if (width < 480) return 1;
                if (width < 768) return 2;

                // DESKTOP — AUTO CALCULATE TO AVOID EMPTY SPACES
                if (totalItems <= 3) return totalItems;   // 1, 2, or 3 items fill perfectly
                if (totalItems === 4) return 4;          // ← FIX FOR YOUR ISSUE
                if (totalItems === 5) return 5;          // also solves 5-item gaps
                if (totalItems === 6) return 3;          // balanced layout

                // GENERAL CASE (fallback)
                return Math.min(4, totalItems);
            }

            // Infinite scroll state
            let panX = 0;
            let panY = 0;
            let originalContainerWidth = 0;
            let originalContainerHeight = 0;
            let isPanning = false;
            let panVelocityX = 0;
            let panVelocityY = 0;
            let lastPanTime = 0;
            let columnCount = getColumnCount();

            // Mouse/Touch drag state
            let isDragging = false;
            let dragStartX = 0;
            let dragStartY = 0;
            let dragStartPanX = 0;
            let dragStartPanY = 0;
            let hasMoved = false;
            let isTouchDevice = 'ontouchstart' in window;

            // Hover state (desktop only)
            let isWindowScrolling = false;
            let windowScrollTimer = null;
            let activeHoverItem = null;
            let hoverDelayTimer = null;

            // Window scroll detection
            let lastScrollY = window.pageYOffset || document.documentElement.scrollTop;
            window.addEventListener('scroll', () => {
                const currentScrollY = window.pageYOffset || document.documentElement.scrollTop;
                const scrollDelta = Math.abs(currentScrollY - lastScrollY);
                lastScrollY = currentScrollY;

                if (scrollDelta > 3) {
                    isWindowScrolling = true;
                    clearTimeout(windowScrollTimer);
                    windowScrollTimer = setTimeout(() => {
                        isWindowScrolling = false;
                    }, 150);
                }
            }, { passive: true });

            // Store original item positions
            let originalItemPositions = [];

            // Responsive masonry layout
            function layoutMasonry() {
                const containerWidth = window.innerWidth;
                const containerHeight = window.innerHeight;
                columnCount = getColumnCount();
                const itemWidth = containerWidth / columnCount;
                const columns = new Array(columnCount).fill(0);

                items.forEach((item, index) => {
                    const col = index % columnCount;

                    item.style.width = itemWidth + 'px';
                    item.style.left = (col * itemWidth) + 'px';
                    item.style.top = columns[col] + 'px';
                    item.style.position = 'absolute';

                    const thumbnail = item.querySelector('.film-thumbnail');
                    if (thumbnail && thumbnail.complete && thumbnail.naturalHeight > 0) {
                        const aspectRatio = thumbnail.naturalWidth / thumbnail.naturalHeight;
                        const itemHeight = itemWidth / aspectRatio;
                        columns[col] += itemHeight;
                    } else {
                        const itemHeight = item.offsetHeight || (itemWidth * 1.2);
                        columns[col] += itemHeight;
                    }
                });

                const maxHeight = Math.max(...columns);
                originalContainerWidth = containerWidth;
                originalContainerHeight = maxHeight;

                if (originalContainerWidth > 0 && originalContainerHeight > 0) {
                    createInfiniteScrollArea();
                }
            }

            // Create infinite scroll clones - FILL ENTIRE VIEWPORT
            function createInfiniteScrollArea() {
                const existingClones = container.querySelectorAll('.film-item-clone');
                existingClones.forEach(clone => clone.remove());

                originalItemPositions = [];
                items.forEach((item) => {
                    originalItemPositions.push({
                        left: parseFloat(item.style.left) || 0,
                        top: parseFloat(item.style.top) || 0,
                        width: item.offsetWidth || window.innerWidth / columnCount,
                        height: item.offsetHeight || 400
                    });
                });

                const viewportWidth = originalContainerWidth;
                const viewportHeight = originalContainerHeight;
                const screenWidth = window.innerWidth;
                const screenHeight = window.innerHeight;
                const padding = 100;

                // Calculate how many times we need to repeat content to fill viewport
                const horizontalRepeats = Math.ceil(screenWidth / viewportWidth) + 3;
                const verticalRepeats = Math.ceil(screenHeight / viewportHeight) + 3;

                // Create enough clones to fill and surround viewport
                for (let row = -verticalRepeats; row <= verticalRepeats; row++) {
                    for (let col = -horizontalRepeats; col <= horizontalRepeats; col++) {
                        if (row === 0 && col === 0) continue;

                        items.forEach((originalItem, index) => {
                            const clone = originalItem.cloneNode(true);
                            clone.classList.add('film-item-clone');

                            const pos = originalItemPositions[index];

                            const leftPos = pos.left + col * viewportWidth;
                            const topPos = pos.top + row * viewportHeight;

                            clone.style.left = Math.round(leftPos) + 'px';
                            clone.style.top = Math.round(topPos) + 'px';
                            clone.style.position = 'absolute';
                            clone.style.width = Math.round(pos.width) + 'px';

                            container.appendChild(clone);
                            initializeItemHover(clone);
                        });
                    }
                }

                const minContainerWidth = viewportWidth * (horizontalRepeats * 2 + 1) + padding * 2;
                const minContainerHeight = viewportHeight * (verticalRepeats * 2 + 1) + padding * 2;

                container.style.width = minContainerWidth + 'px';
                container.style.height = minContainerHeight + 'px';
                container.style.left = -padding + 'px';
                container.style.top = -padding + 'px';

                panX = -viewportWidth - padding;
                panY = -viewportHeight - padding;
                applyPanTransform();

                container.offsetHeight;
            }

            // Apply pan transform with seamless wrapping
            function applyPanTransform(skipWrapping = false) {
                const viewportWidth = originalContainerWidth || window.innerWidth;
                const viewportHeight = originalContainerHeight || window.innerHeight;
                const padding = 100;

                if (!skipWrapping && !isDragging) {
                    if (viewportWidth > 0) {
                        const minX = -viewportWidth - padding;
                        const maxX = -padding;

                        if (panX > maxX + 50) {
                            panX -= viewportWidth;
                        } else if (panX < minX - 50) {
                            panX += viewportWidth;
                        }
                    }

                    if (viewportHeight > 0) {
                        const minY = -viewportHeight - padding;
                        const maxY = -padding;

                        if (panY > maxY + 50) {
                            panY -= viewportHeight;
                        } else if (panY < minY - 50) {
                            panY += viewportHeight;
                        }
                    }
                }

                container.style.transform = `translate3d(${panX}px, ${panY}px, 0)`;
                container.style.webkitTransform = `translate3d(${panX}px, ${panY}px, 0)`;
                container.style.transform = `translate3d(${panX}px, ${panY}px, 0)`;
            }

            // Wheel handler (trackpad and mouse wheel)
            section.addEventListener('wheel', (e) => {
                const isTrackpad = Math.abs(e.deltaX) > 0 || (Math.abs(e.deltaY) < 100 && Math.abs(e.deltaY) > 0);

                if (isTrackpad && !e.ctrlKey && !e.metaKey) {
                    e.preventDefault();
                    isPanning = true;

                    container.classList.remove('has-hover');

                    const now = Date.now();
                    const timeDelta = now - lastPanTime;
                    lastPanTime = now;

                    const panSpeed = 1.0;
                    panX -= e.deltaX * panSpeed;
                    panY -= e.deltaY * panSpeed;

                    if (timeDelta > 0) {
                        panVelocityX = -e.deltaX / timeDelta;
                        panVelocityY = -e.deltaY / timeDelta;
                    }

                    applyPanTransform();

                    clearTimeout(panMomentumTimer);
                    panMomentumTimer = setTimeout(() => {
                        isPanning = false;
                        let momentumX = panVelocityX * 15;
                        let momentumY = panVelocityY * 15;
                        const friction = 0.95;

                        function applyMomentum() {
                            if (Math.abs(momentumX) < 0.1 && Math.abs(momentumY) < 0.1) {
                                panVelocityX = 0;
                                panVelocityY = 0;
                                isPanning = false;
                                return;
                            }

                            isPanning = true;
                            panX += momentumX;
                            panY += momentumY;
                            applyPanTransform();

                            momentumX *= friction;
                            momentumY *= friction;
                            requestAnimationFrame(applyMomentum);
                        }
                        applyMomentum();
                    }, 50);
                }
            }, { passive: false });

            let panMomentumTimer = null;

            // Touch events for mobile
            section.addEventListener('touchstart', (e) => {
                if (e.touches.length === 1) {
                    const touch = e.touches[0];
                    dragStartX = touch.clientX;
                    dragStartY = touch.clientY;
                    dragStartPanX = panX;
                    dragStartPanY = panY;
                    hasMoved = false;
                }
            }, { passive: true });

            section.addEventListener('touchmove', (e) => {
                if (e.touches.length === 1) {
                    const touch = e.touches[0];
                    const moveDistance = Math.sqrt(
                        Math.pow(touch.clientX - dragStartX, 2) +
                        Math.pow(touch.clientY - dragStartY, 2)
                    );

                    if (moveDistance > 5) {
                        if (!isDragging) {
                            isDragging = true;
                            isPanning = true;
                            hasMoved = true;
                            e.preventDefault();
                        }

                        const deltaX = touch.clientX - dragStartX;
                        const deltaY = touch.clientY - dragStartY;
                        panX = dragStartPanX + deltaX;
                        panY = dragStartPanY + deltaY;

                        container.style.transition = 'none';
                        container.style.transform = `translate3d(${panX}px, ${panY}px, 0)`;
                        container.style.webkitTransform = `translate3d(${panX}px, ${panY}px, 0)`;
                        container.style.transform = `translate3d(${panX}px, ${panY}px, 0)`;

                        e.preventDefault();
                    }
                }
            }, { passive: false });

            section.addEventListener('touchend', (e) => {
                if (isDragging) {
                    isDragging = false;
                    isPanning = false;

                    container.style.transition = '';
                    applyPanTransform(false);

                    e.preventDefault();
                }

                dragStartX = 0;
                dragStartY = 0;
                hasMoved = false;
            }, { passive: false });

            // Mouse drag handler (desktop)
            section.addEventListener('mousedown', (e) => {
                if (e.button !== 0) return;

                dragStartX = e.clientX;
                dragStartY = e.clientY;
                dragStartPanX = panX;
                dragStartPanY = panY;
                hasMoved = false;

                e.preventDefault();
            });

            document.addEventListener('mousemove', (e) => {
                if (!isDragging && (dragStartX !== 0 || dragStartY !== 0)) {
                    const moveDistance = Math.sqrt(
                        Math.pow(e.clientX - dragStartX, 2) +
                        Math.pow(e.clientY - dragStartY, 2)
                    );

                    if (moveDistance > 3) {
                        isDragging = true;
                        isPanning = true;
                        hasMoved = true;

                        container.classList.remove('has-hover');
                        section.style.cursor = 'grabbing';

                        const deltaX = e.clientX - dragStartX;
                        const deltaY = e.clientY - dragStartY;
                        panX = dragStartPanX + deltaX;
                        panY = dragStartPanY + deltaY;
                        container.style.transform = `translate3d(${panX}px, ${panY}px, 0)`;
                        container.style.transition = 'none';
                    }
                }

                if (isDragging) {
                    const deltaX = e.clientX - dragStartX;
                    const deltaY = e.clientY - dragStartY;

                    panX = dragStartPanX + deltaX;
                    panY = dragStartPanY + deltaY;

                    container.style.transition = 'none';
                    container.style.transform = `translate3d(${panX}px, ${panY}px, 0)`;

                    e.preventDefault();
                    e.stopPropagation();
                }
            });

            document.addEventListener('mouseup', (e) => {
                if (isDragging) {
                    const deltaX = e.clientX - dragStartX;
                    const deltaY = e.clientY - dragStartY;
                    panX = dragStartPanX + deltaX;
                    panY = dragStartPanY + deltaY;
                    container.style.transform = `translate3d(${panX}px, ${panY}px, 0)`;

                    isDragging = false;
                    isPanning = false;

                    container.style.transition = '';
                    applyPanTransform(false);

                    section.style.cursor = '';

                    e.preventDefault();
                }

                dragStartX = 0;
                dragStartY = 0;
                hasMoved = false;
            });

            section.addEventListener('mouseleave', () => {
                if (isDragging) {
                    isDragging = false;
                    isPanning = false;
                    section.style.cursor = '';
                }
            });

            // Quick initial layout - FILL VIEWPORT IMMEDIATELY
            function initQuickLayout() {
                const containerWidth = window.innerWidth;
                const containerHeight = window.innerHeight;
                columnCount = getColumnCount();
                const itemWidth = containerWidth / columnCount;
                const padding = 100;

                const columns = new Array(columnCount).fill(0);

                items.forEach((item, index) => {
                    const col = index % columnCount;
                    const thumbnail = item.querySelector('.film-thumbnail');

                    item.style.width = itemWidth + 'px';
                    item.style.left = (col * itemWidth) + 'px';
                    item.style.top = columns[col] + 'px';
                    item.style.position = 'absolute';

                    let itemHeight = itemWidth * 1.2;
                    if (thumbnail && thumbnail.complete && thumbnail.naturalHeight > 0) {
                        const aspectRatio = thumbnail.naturalWidth / thumbnail.naturalHeight;
                        itemHeight = itemWidth / aspectRatio;
                    }

                    columns[col] += itemHeight;
                });

                const actualContentHeight = Math.max(...columns);
                originalContainerWidth = containerWidth;
                originalContainerHeight = actualContentHeight;

                // Calculate repeats needed to fill viewport
                const horizontalRepeats = Math.ceil(containerWidth / originalContainerWidth) + 3;
                const verticalRepeats = Math.ceil(containerHeight / originalContainerHeight) + 3;

                const initialWidth = originalContainerWidth * (horizontalRepeats * 2 + 1) + padding * 2;
                const initialHeight = originalContainerHeight * (verticalRepeats * 2 + 1) + padding * 2;

                container.style.width = initialWidth + 'px';
                container.style.height = initialHeight + 'px';
                container.style.left = -padding + 'px';
                container.style.top = -padding + 'px';

                createQuickClones();

                panX = -originalContainerWidth - padding;
                panY = -originalContainerHeight - padding;
                applyPanTransform();
            }

            function createQuickClones() {
                const existingClones = container.querySelectorAll('.film-item-clone');
                existingClones.forEach(clone => clone.remove());

                const viewportWidth = originalContainerWidth;
                const viewportHeight = originalContainerHeight;
                const screenWidth = window.innerWidth;
                const screenHeight = window.innerHeight;

                const itemPositions = [];
                items.forEach((item) => {
                    itemPositions.push({
                        left: parseFloat(item.style.left) || 0,
                        top: parseFloat(item.style.top) || 0,
                        width: parseFloat(item.style.width) || viewportWidth / columnCount,
                        height: item.offsetHeight || 400
                    });
                });

                // Calculate repeats
                const horizontalRepeats = Math.ceil(screenWidth / viewportWidth) + 3;
                const verticalRepeats = Math.ceil(screenHeight / viewportHeight) + 3;

                for (let row = -verticalRepeats; row <= verticalRepeats; row++) {
                    for (let col = -horizontalRepeats; col <= horizontalRepeats; col++) {
                        if (row === 0 && col === 0) continue;

                        items.forEach((originalItem, index) => {
                            const clone = originalItem.cloneNode(true);
                            clone.classList.add('film-item-clone');

                            const pos = itemPositions[index];

                            const leftPos = pos.left + col * viewportWidth;
                            const topPos = pos.top + row * viewportHeight;

                            clone.style.left = Math.round(leftPos) + 'px';
                            clone.style.top = Math.round(topPos) + 'px';
                            clone.style.position = 'absolute';
                            clone.style.width = Math.round(pos.width) + 'px';

                            container.appendChild(clone);
                            initializeItemHover(clone);
                        });
                    }
                }
            }

            // Initialize layout
            function init() {
                initQuickLayout();

                const images = container.querySelectorAll('.film-thumbnail');
                let loaded = 0;
                const total = images.length;

                const onComplete = () => {
                    setTimeout(() => {
                        layoutMasonry();
                    }, 100);
                };

                if (total === 0) {
                    onComplete();
                    return;
                }

                images.forEach(img => {
                    if (img.complete && img.naturalHeight > 0) {
                        loaded++;
                        if (loaded === total) onComplete();
                    } else {
                        img.addEventListener('load', () => {
                            loaded++;
                            if (loaded === total) onComplete();
                        });
                        img.addEventListener('error', () => {
                            loaded++;
                            if (loaded === total) onComplete();
                        });
                    }
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }

            // Responsive resize handler
            let resizeTimer = null;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    layoutMasonry();

                    const padding = 100;
                    panX = -originalContainerWidth - padding;
                    panY = -originalContainerHeight - padding;
                    applyPanTransform();
                }, 150);
            });

            // Tooltip (desktop only)
            const tooltip = !isTouchDevice ? (() => {
                const t = document.createElement('div');
                t.className = 'film-tooltip';
                t.innerHTML = '<div class="film-tooltip-title"></div><div class="film-tooltip-category"></div>';
                document.body.appendChild(t);
                return t;
            })() : null;

            const tooltipTitle = tooltip ? tooltip.querySelector('.film-tooltip-title') : null;
            const tooltipCategory = tooltip ? tooltip.querySelector('.film-tooltip-category') : null;

            // Initialize hover for item (desktop only)
            function initializeItemHover(item) {
                if (isTouchDevice) return;
                if (!tooltip || !tooltipTitle || !tooltipCategory) return;

                const title = item.dataset.title || '';
                const category = item.dataset.category || '';
                const imagesData = item.dataset.images || '';
                const freshReel = item.querySelector('.film-reel');
                const freshThumbnail = item.querySelector('.film-thumbnail');

                let reelImages = [];
                let currentImageIndex = 0;
                let imageCycleInterval = null;
                let isAnimating = false;
                let imagesLoaded = false;
                let isCurrentlyHovered = false;

                // Setup image reel
                if (imagesData && freshReel && freshThumbnail) {
                    const imagePaths = imagesData.split(',').map(p => p.trim()).filter(p => p);

                    const setupReel = () => {
                        if (!freshThumbnail || imagePaths.length === 0) return;

                        freshReel.innerHTML = '';

                        const thumbWidth = freshThumbnail.offsetWidth;
                        const thumbHeight = freshThumbnail.offsetHeight;

                        if (thumbWidth === 0 || thumbHeight === 0) {
                            setTimeout(setupReel, 50);
                            return;
                        }

                        freshReel.style.width = thumbWidth + 'px';
                        freshReel.style.height = thumbHeight + 'px';

                        let loadedCount = 0;
                        imagePaths.forEach((path, idx) => {
                            const img = document.createElement('img');
                            img.src = path;
                            img.alt = title;

                            img.style.width = thumbWidth + 'px';
                            img.style.height = thumbHeight + 'px';
                            img.style.objectFit = 'cover';
                            img.style.objectPosition = 'center center';

                            if (idx === 0) {
                                img.classList.add('active');
                                gsap.set(img, { opacity: 1, z: 0, rotationX: 0, scale: 1, y: 0 });
                            } else {
                                gsap.set(img, { opacity: 0, z: -150, rotationX: -80, scale: 1, y: '-100%' });
                            }

                            const checkLoaded = () => {
                                loadedCount++;
                                if (loadedCount === imagePaths.length) {
                                    imagesLoaded = true;
                                }
                            };

                            if (img.complete) {
                                checkLoaded();
                            } else {
                                img.addEventListener('load', checkLoaded);
                                img.addEventListener('error', checkLoaded);
                            }

                            freshReel.appendChild(img);
                            reelImages.push(img);
                        });

                        if (imagePaths.length === 0) {
                            imagesLoaded = true;
                        }
                    };

                    if (freshThumbnail.complete && freshThumbnail.offsetWidth > 0) {
                        setupReel();
                    } else {
                        const checkThumbnail = () => {
                            if (freshThumbnail.offsetWidth > 0) {
                                setupReel();
                            } else {
                                setTimeout(checkThumbnail, 50);
                            }
                        };
                        freshThumbnail.addEventListener('load', checkThumbnail);
                        freshThumbnail.addEventListener('error', checkThumbnail);
                        setTimeout(() => {
                            if (freshThumbnail.offsetWidth === 0) {
                                setupReel();
                            }
                        }, 500);
                    }
                }

                // Image animation
                const animateToNext = () => {
                    if (isAnimating || reelImages.length <= 1 || !isCurrentlyHovered) return;
                    isAnimating = true;

                    if (currentImageIndex < reelImages.length - 1) {
                        const current = reelImages[currentImageIndex];
                        const next = reelImages[currentImageIndex + 1];

                        gsap.to(current, {
                            y: -1,
                            z: -8,
                            rotationX: 1,
                            scale: 1,
                            duration: 0.3,
                            ease: 'power2.out'
                        });
                        current.classList.remove('active');
                        current.classList.add('stack');
                        current.style.zIndex = currentImageIndex + 1;

                        gsap.set(next, {
                            y: '-100%',
                            z: -100,
                            rotationX: -60,
                            scale: 1,
                            opacity: 0
                        });
                        next.style.transformOrigin = 'center bottom';
                        next.classList.add('active');
                        next.style.zIndex = currentImageIndex + 10;

                        gsap.to(next, {
                            y: 0,
                            z: 0,
                            rotationX: 0,
                            scale: 1,
                            opacity: 1,
                            duration: 0.3,
                            ease: 'power2.out',
                            onComplete: () => {
                                isAnimating = false;
                            }
                        });

                        currentImageIndex++;
                    } else {
                        reelImages.forEach((img, idx) => {
                            gsap.to(img, {
                                opacity: 0,
                                y: '100%',
                                z: -100,
                                rotationX: 60,
                                scale: 1,
                                duration: 0.2,
                                ease: 'power2.in',
                                onComplete: () => {
                                    img.classList.remove('active', 'stack');
                                    if (idx === 0) {
                                        gsap.set(img, {
                                            opacity: 0,
                                            y: '-100%',
                                            z: -100,
                                            rotationX: -60,
                                            scale: 1
                                        });
                                        img.style.transformOrigin = 'center bottom';
                                        img.classList.add('active');
                                        img.style.zIndex = 10;

                                        gsap.to(img, {
                                            opacity: 1,
                                            y: 0,
                                            z: 0,
                                            rotationX: 0,
                                            scale: 1,
                                            duration: 0.3,
                                            ease: 'power2.out',
                                            onComplete: () => {
                                                isAnimating = false;
                                            }
                                        });
                                    }
                                }
                            });
                        });
                        currentImageIndex = 0;
                    }
                };

                // Mouse enter
                item.addEventListener('mouseenter', (e) => {
                    if (activeHoverItem === item && imageCycleInterval) {
                        tooltip.style.left = (e.clientX + 15) + 'px';
                        tooltip.style.top = (e.clientY - 10) + 'px';
                        return;
                    }

                    activeHoverItem = item;
                    isCurrentlyHovered = true;

                    clearTimeout(hoverDelayTimer);

                    if (isWindowScrolling || isPanning) {
                        return;
                    }

                    hoverDelayTimer = setTimeout(() => {
                        if (isWindowScrolling || isPanning || activeHoverItem !== item) return;

                        if (!activeHoverItem || activeHoverItem === item) {
                            container.classList.add('has-hover');
                        }

                        tooltipTitle.textContent = title;
                        tooltipCategory.textContent = category;
                        tooltip.style.left = (e.clientX + 15) + 'px';
                        tooltip.style.top = (e.clientY - 10) + 'px';
                        tooltip.classList.add('show');

                        if (imagesLoaded && reelImages.length > 1 && !imageCycleInterval) {
                            currentImageIndex = 0;
                            isAnimating = false;

                            reelImages.forEach((img, idx) => {
                                gsap.killTweensOf(img);
                                img.classList.remove('active', 'stack');

                                if (idx === 0) {
                                    gsap.set(img, { opacity: 1, z: 0, rotationX: 0, scale: 1, y: 0 });
                                    img.classList.add('active');
                                    img.style.zIndex = 10;
                                } else {
                                    gsap.set(img, { opacity: 0, z: -150, rotationX: -80, scale: 1, y: '-100%' });
                                }
                            });

                            imageCycleInterval = setInterval(() => {
                                if (!isWindowScrolling && activeHoverItem === item && isCurrentlyHovered) {
                                    animateToNext();
                                }
                            }, 150);

                            setTimeout(() => {
                                if (!isWindowScrolling && activeHoverItem === item && isCurrentlyHovered && reelImages.length > 1) {
                                    animateToNext();
                                }
                            }, 50);
                        }
                    }, 200);
                });

                // Mouse leave
                item.addEventListener('mouseleave', () => {
                    isCurrentlyHovered = false;
                    clearTimeout(hoverDelayTimer);

                    if (activeHoverItem === item) {
                        activeHoverItem = null;
                        container.classList.remove('has-hover');
                    }

                    tooltip.classList.remove('show');

                    if (imageCycleInterval) {
                        clearInterval(imageCycleInterval);
                        imageCycleInterval = null;
                    }

                    isAnimating = false;
                    reelImages.forEach(img => {
                        gsap.killTweensOf(img);
                    });

                    if (reelImages.length > 0) {
                        reelImages.forEach((img, idx) => {
                            img.classList.remove('active', 'stack');
                            if (idx === 0) {
                                gsap.set(img, { opacity: 1, z: 0, rotationX: 0, scale: 1, y: 0 });
                                img.classList.add('active');
                                img.style.zIndex = 10;
                            } else {
                                gsap.set(img, { opacity: 0, z: -150, rotationX: -80, scale: 1, y: '-100%' });
                            }
                        });
                        currentImageIndex = 0;
                    }
                });
            }

            // Initialize items with hover
            items.forEach((item) => {
                initializeItemHover(item);
            });
        })();
    </script>
@endsection
