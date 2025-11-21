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
        (function() {
            'use strict';
            
            const section = document.getElementById('films-listing-section');
            const container = document.getElementById('films-container');
            const items = Array.from(document.querySelectorAll('.film-item'));
            
            // Infinite scroll state
            let panX = 0;
            let panY = 0;
            let originalContainerWidth = 0;
            let originalContainerHeight = 0;
            let isPanning = false;
            let panVelocityX = 0;
            let panVelocityY = 0;
            let lastPanTime = 0;
            
            // Mouse drag state
            let isDragging = false;
            let dragStartX = 0;
            let dragStartY = 0;
            let dragStartPanX = 0;
            let dragStartPanY = 0;
            let hasMoved = false; // Track if mouse has moved to distinguish click from drag
            let currentDragX = 0;
            let currentDragY = 0;
            let dragRAF = null;
            
            // Hover state
            let isWindowScrolling = false;
            let windowScrollTimer = null;
            let activeHoverItem = null;
            let hoverDelayTimer = null;
            
            // Window scroll detection for hover
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
            
            // Simple masonry layout - 3 columns
            function layoutMasonry() {
                const containerWidth = window.innerWidth;
                const itemWidth = containerWidth / 3;
                const columns = [0, 0, 0]; // Track height of each column
                
                items.forEach((item, index) => {
                    const col = index % 3;
                    
                    item.style.width = itemWidth + 'px';
                    item.style.left = (col * itemWidth) + 'px';
                    item.style.top = columns[col] + 'px';
                    item.style.position = 'absolute';
                    
                    // Wait for image to load to get accurate height
                    const thumbnail = item.querySelector('.film-thumbnail');
                    if (thumbnail && thumbnail.complete && thumbnail.naturalHeight > 0) {
                        const aspectRatio = thumbnail.naturalWidth / thumbnail.naturalHeight;
                        const itemHeight = itemWidth / aspectRatio;
                        columns[col] += itemHeight;
                    } else {
                        // Fallback height
                        const itemHeight = item.offsetHeight || 400;
                        columns[col] += itemHeight;
                    }
                });
                
                const maxHeight = Math.max(...columns);
                originalContainerWidth = containerWidth;
                originalContainerHeight = maxHeight;
                
                // Ensure container has minimum size before creating clones
                if (originalContainerWidth > 0 && originalContainerHeight > 0) {
                    // Create infinite scroll area (3x3 grid of content)
                    createInfiniteScrollArea();
                }
            }
            
            // Store original item positions
            let originalItemPositions = [];
            
            // Create infinite scroll by cloning items in a grid
            function createInfiniteScrollArea() {
                // Remove existing clones
                const existingClones = container.querySelectorAll('.film-item-clone');
                existingClones.forEach(clone => clone.remove());
                
                // Store original positions
                originalItemPositions = [];
                items.forEach((item) => {
                    originalItemPositions.push({
                        left: parseFloat(item.style.left) || 0,
                        top: parseFloat(item.style.top) || 0,
                        width: item.offsetWidth || window.innerWidth / 3,
                        height: item.offsetHeight || 400
                    });
                });
                
                // Clone items in a 3x3 grid pattern with exact positioning
                const viewportWidth = originalContainerWidth;
                const viewportHeight = originalContainerHeight;
                
                // Ensure we have enough padding to prevent gaps
                const padding = 100; // Extra padding to prevent white gaps
                
                // Create clones in a 3x3 grid plus extra right column for coverage
                for (let row = -1; row <= 1; row++) {
                    for (let col = -1; col <= 2; col++) { // col <= 2 to include extra right column
                        // Skip center (original items)
                        if (row === 0 && col === 0) continue;
                        
                        items.forEach((originalItem, index) => {
                            const clone = originalItem.cloneNode(true);
                            clone.classList.add('film-item-clone');
                            
                            const pos = originalItemPositions[index];
                            
                            // Position clone in grid with exact pixel precision
                            const leftPos = pos.left + col * viewportWidth;
                            const topPos = pos.top + row * viewportHeight;
                            
                            clone.style.left = Math.round(leftPos) + 'px';
                            clone.style.top = Math.round(topPos) + 'px';
                            clone.style.position = 'absolute';
                            clone.style.width = Math.round(pos.width) + 'px';
                            
                            container.appendChild(clone);
                            
                            // Initialize hover for cloned items
                            initializeItemHover(clone);
                        });
                    }
                }
                
                // Make container larger to accommodate clones with padding to prevent gaps
                // Ensure container covers full viewport width initially - must be at least 4x viewport width
                const minContainerWidth = Math.max(viewportWidth * 4, window.innerWidth * 4) + padding * 2;
                const minContainerHeight = Math.max(viewportHeight * 3, window.innerHeight * 3) + padding * 2;
                
                container.style.width = minContainerWidth + 'px';
                container.style.height = minContainerHeight + 'px';
                container.style.left = -padding + 'px';
                container.style.top = -padding + 'px';
                
                // Start at center (accounting for padding)
                panX = -viewportWidth - padding;
                panY = -viewportHeight - padding;
                applyPanTransform();
                
                // Force a reflow to ensure container is rendered
                container.offsetHeight;
            }
            
            // Apply pan transform with seamless wrapping (no visible jumps)
            function applyPanTransform(skipWrapping = false) {
                const viewportWidth = originalContainerWidth || window.innerWidth;
                const viewportHeight = originalContainerHeight || window.innerHeight;
                const padding = 100;
                
                // Don't wrap during active dragging to prevent glitches
                // Only wrap when not actively dragging
                if (!skipWrapping && !isDragging) {
                    // Smooth wrapping without visible jumps
                    // Only wrap when we're well past the boundary to avoid glitches
                    // Account for padding in wrapping calculations
                    if (viewportWidth > 0) {
                        const minX = -viewportWidth - padding;
                        const maxX = -padding;
                        
                        // Wrap panX to stay within bounds
                        if (panX > maxX + 50) {
                            panX -= viewportWidth;
                        } else if (panX < minX - 50) {
                            panX += viewportWidth;
                        }
                    }
                    
                    if (viewportHeight > 0) {
                        const minY = -viewportHeight - padding;
                        const maxY = -padding;
                        
                        // Wrap panY to stay within bounds
                        if (panY > maxY + 50) {
                            panY -= viewportHeight;
                        } else if (panY < minY - 50) {
                            panY += viewportHeight;
                        }
                    }
                }
                
                // Apply transform immediately without transition for smooth scrolling
                // Use translate3d for hardware acceleration with 3deg rotation
                container.style.transform = `translate3d(${panX}px, ${panY}px, 0) rotate(3deg)`;
            }
            
            // Trackpad scroll handler for infinite panning
            section.addEventListener('wheel', (e) => {
                // Detect trackpad (two-finger scroll)
                const isTrackpad = Math.abs(e.deltaX) > 0 || (Math.abs(e.deltaY) < 100 && Math.abs(e.deltaY) > 0);
                
                if (isTrackpad && !e.ctrlKey && !e.metaKey) {
                    e.preventDefault();
                    isPanning = true;
                    
                    // Remove overlay when scrolling starts
                    container.classList.remove('has-hover');
                    
                    const now = Date.now();
                    const timeDelta = now - lastPanTime;
                    lastPanTime = now;
                    
                    // Pan speed (negative for natural scrolling direction)
                    const panSpeed = 1.0;
                    panX -= e.deltaX * panSpeed;
                    panY -= e.deltaY * panSpeed;
                    
                    // Calculate velocity for momentum
                    if (timeDelta > 0) {
                        panVelocityX = -e.deltaX / timeDelta;
                        panVelocityY = -e.deltaY / timeDelta;
                    }
                    
                    applyPanTransform();
                    
                    // Apply momentum after scrolling stops
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
                                isPanning = false; // Ensure panning is false when momentum stops
                                return;
                            }
                            
                            isPanning = true; // Still panning during momentum
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
            
            // Mouse drag handler for panning
            section.addEventListener('mousedown', (e) => {
                // Don't start drag on right-click
                if (e.button !== 0) {
                    return;
                }
                
                // Store initial positions
                dragStartX = e.clientX;
                dragStartY = e.clientY;
                dragStartPanX = panX;
                dragStartPanY = panY;
                hasMoved = false;
                
                // Prevent text selection and other default behaviors
                e.preventDefault();
            });
            
            // Use document for mousemove to work even if mouse leaves section
            // Use capture phase to ensure we catch the event early
            document.addEventListener('mousemove', (e) => {
                // Check if mouse has moved enough to start dragging (threshold: 3px)
                if (!isDragging && (dragStartX !== 0 || dragStartY !== 0)) {
                    const moveDistance = Math.sqrt(
                        Math.pow(e.clientX - dragStartX, 2) + 
                        Math.pow(e.clientY - dragStartY, 2)
                    );
                    
                    if (moveDistance > 3) {
                        // Start dragging
                        isDragging = true;
                        isPanning = true;
                        hasMoved = true;
                        
                        // Remove overlay when dragging starts
                        container.classList.remove('has-hover');
                        
                        // Change cursor to indicate dragging
                        section.style.cursor = 'grabbing';
                        
                        // Update pan position immediately when drag starts
                        const deltaX = e.clientX - dragStartX;
                        const deltaY = e.clientY - dragStartY;
                        panX = dragStartPanX + deltaX;
                        panY = dragStartPanY + deltaY;
                        container.style.transform = `translate3d(${panX}px, ${panY}px, 0) rotate(3deg)`;
                        container.style.transition = 'none'; // Disable transitions during drag
                    }
                }
                
                if (isDragging) {
                    // Calculate drag distance
                    const deltaX = e.clientX - dragStartX;
                    const deltaY = e.clientY - dragStartY;
                    
                    // Update pan position
                    panX = dragStartPanX + deltaX;
                    panY = dragStartPanY + deltaY;
                    
                    // Apply transform immediately - no delays, no RAF, direct synchronous update
                    container.style.transition = 'none';
                    container.style.transform = `translate3d(${panX}px, ${panY}px, 0) rotate(3deg)`;
                    
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
            
            // Use document for mouseup to work even if mouse leaves section
            document.addEventListener('mouseup', (e) => {
                if (isDragging) {
                    // Cancel any pending animation frame
                    if (dragRAF) {
                        cancelAnimationFrame(dragRAF);
                        dragRAF = null;
                    }
                    
                    // Apply final position immediately
                    const deltaX = e.clientX - dragStartX;
                    const deltaY = e.clientY - dragStartY;
                    panX = dragStartPanX + deltaX;
                    panY = dragStartPanY + deltaY;
                    container.style.transform = `translate3d(${panX}px, ${panY}px, 0) rotate(3deg)`;
                    
                    isDragging = false;
                    isPanning = false;
                    
                    // Re-enable transitions after drag
                    container.style.transition = '';
                    
                    // Apply final transform with wrapping enabled
                    applyPanTransform(false);
                    
                    // Reset cursor
                    section.style.cursor = '';
                    
                    e.preventDefault();
                }
                
                // Reset drag start positions
                dragStartX = 0;
                dragStartY = 0;
                hasMoved = false;
            });
            
            // Also handle mouse leave to stop dragging if mouse leaves the section
            section.addEventListener('mouseleave', (e) => {
                if (isDragging) {
                    isDragging = false;
                    isPanning = false;
                    section.style.cursor = '';
                }
            });
            
            // Quick initial layout to cover viewport immediately
            function initQuickLayout() {
                const containerWidth = window.innerWidth;
                const itemWidth = containerWidth / 3;
                const padding = 100;
                
                // Set container size immediately - make it wide enough to cover viewport
                const initialWidth = containerWidth * 4 + padding * 2;
                const initialHeight = window.innerHeight * 3 + padding * 2;
                
                container.style.width = initialWidth + 'px';
                container.style.height = initialHeight + 'px';
                container.style.left = -padding + 'px';
                container.style.top = -padding + 'px';
                
                // Quick layout items with estimated heights
                items.forEach((item, index) => {
                    const col = index % 3;
                    item.style.width = itemWidth + 'px';
                    item.style.left = (col * itemWidth) + 'px';
                    item.style.top = (Math.floor(index / 3) * 400) + 'px';
                    item.style.position = 'absolute';
                });
                
                // Store initial dimensions
                originalContainerWidth = containerWidth;
                originalContainerHeight = Math.max(window.innerHeight, 800);
                
                // Create clones immediately to fill space - use a simplified version
                createQuickClones();
                
                // Set initial pan position to show center content
                panX = -containerWidth - padding;
                panY = -originalContainerHeight - padding;
                applyPanTransform();
            }
            
            // Create quick clones without waiting for hover initialization
            function createQuickClones() {
                const existingClones = container.querySelectorAll('.film-item-clone');
                existingClones.forEach(clone => clone.remove());
                
                const viewportWidth = originalContainerWidth;
                const viewportHeight = originalContainerHeight;
                const padding = 100;
                
                // Create clones in a 3x3 grid plus extra right column
                for (let row = -1; row <= 1; row++) {
                    for (let col = -1; col <= 2; col++) { // col <= 2 to include extra right column
                        if (row === 0 && col === 0) continue; // Skip center
                        
                        items.forEach((originalItem, index) => {
                            const clone = originalItem.cloneNode(true);
                            clone.classList.add('film-item-clone');
                            
                            const itemWidth = parseFloat(originalItem.style.width) || viewportWidth / 3;
                            const itemLeft = parseFloat(originalItem.style.left) || 0;
                            const itemTop = parseFloat(originalItem.style.top) || 0;
                            
                            clone.style.left = Math.round(itemLeft + col * viewportWidth) + 'px';
                            clone.style.top = Math.round(itemTop + row * viewportHeight) + 'px';
                            clone.style.position = 'absolute';
                            clone.style.width = Math.round(itemWidth) + 'px';
                            
                            container.appendChild(clone);
                        });
                    }
                }
            }
            
            // Initialize layout
            function init() {
                // Do quick layout immediately to cover viewport
                initQuickLayout();
                
                const images = container.querySelectorAll('.film-thumbnail');
                let loaded = 0;
                const total = images.length;
                
                const onComplete = () => {
                    setTimeout(() => {
                        // Recalculate with accurate dimensions after images load
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
            
            // Initialize immediately when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
            window.addEventListener('resize', () => {
                clearTimeout(window.resizeTimer);
                window.resizeTimer = setTimeout(() => {
                    layoutMasonry();
                    // Reset pan to center after resize (accounting for padding)
                    const padding = 100;
                    panX = -originalContainerWidth - padding;
                    panY = -originalContainerHeight - padding;
                    applyPanTransform();
                }, 100);
            });
            
            // Tooltip
            const tooltip = document.createElement('div');
            tooltip.className = 'film-tooltip';
            tooltip.innerHTML = '<div class="film-tooltip-title"></div><div class="film-tooltip-category"></div>';
            document.body.appendChild(tooltip);
            const tooltipTitle = tooltip.querySelector('.film-tooltip-title');
            const tooltipCategory = tooltip.querySelector('.film-tooltip-category');
            
            // Initialize hover for item
            function initializeItemHover(item) {
                const title = item.dataset.title || '';
                const category = item.dataset.category || '';
                const imagesData = item.dataset.images || '';
                const freshReel = item.querySelector('.film-reel');
                const freshThumbnail = item.querySelector('.film-thumbnail');
                const freshPoster = item.querySelector('.film-poster');
                
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
                        
                        // Get exact dimensions from thumbnail
                        const thumbWidth = freshThumbnail.offsetWidth;
                        const thumbHeight = freshThumbnail.offsetHeight;
                        
                        if (thumbWidth === 0 || thumbHeight === 0) {
                            setTimeout(setupReel, 50);
                            return;
                        }
                        
                        // Set reel to exact thumbnail size
                        freshReel.style.width = thumbWidth + 'px';
                        freshReel.style.height = thumbHeight + 'px';
                        
                        let loadedCount = 0;
                        imagePaths.forEach((path, idx) => {
                            const img = document.createElement('img');
                            img.src = path;
                            img.alt = title;
                            
                            // Set exact size to match thumbnail
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
                    
                    // Don't show overlay or effects while scrolling/panning
                    if (isWindowScrolling || isPanning) {
                        return;
                    }
                    
                    hoverDelayTimer = setTimeout(() => {
                        // Double check we're still not scrolling/panning
                        if (isWindowScrolling || isPanning || activeHoverItem !== item) return;
                        
                        // Only add has-hover class when user has stopped scrolling and is hovering
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
            
            // Initialize items
            items.forEach((item) => {
                initializeItemHover(item);
            });
        })();
    </script>
@endsection
