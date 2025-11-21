@extends('frontend.partials.master')

@section('title', 'Films - Never Ending Trails')

@php
    $hideFooter = true;
@endphp

@section('content')
<!-- Films Poster Slider Section -->
        <div class="films-slider-section">
            <div class="scroll-indicator scroll-indicator-right">
                <span class="scroll-arrow">»</span>
            </div>
            <div class="films-slider-container" id="films-slider-container">
                @forelse($films as $film)
                    <div class="film-poster-item">
                        <div class="film-poster-image" onclick="location.href='{{ route('front.film.detail', $film->slug) }}'">
                            @if($film->film_poster)
                                <img src="{{asset($film->film_poster)}}" alt="{{$film->title}}">
                            @else
                                <img src="{{asset('assets/images/specials/1.webp')}}" alt="{{$film->title}}">
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="film-poster-item">
                        <div class="film-poster-image">
                            <img src="{{asset('assets/images/specials/1.webp')}}" alt="No Films Available">
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
    
    <!-- Films Slider Script -->
    <script>
        (function() {
            const sliderContainer = document.getElementById('films-slider-container');
            let posterItems = document.querySelectorAll('.film-poster-item');
            const sliderSection = document.querySelector('.films-slider-section');
            
            // Clone all poster items for infinite scroll
            function clonePosterItems() {
                posterItems.forEach((item) => {
                    const clone = item.cloneNode(true);
                    clone.classList.add('cloned-item');
                    sliderContainer.appendChild(clone);
                });
            }
            
            // Calculate total width - CSS flexbox with gap handles spacing automatically
            function calculateSliderWidth() {
                // Container width is automatically calculated by flexbox
                return sliderContainer.scrollWidth;
            }
            
            // Get the width of original items only (for loop detection)
            function getOriginalItemsWidth() {
                // Measure from first original item to the start of first cloned item
                if (posterItems.length === 0) return 0;
                
                const firstOriginal = posterItems[0];
                const firstCloned = document.querySelector('.cloned-item');
                
                if (firstCloned) {
                    // Width is the position of first cloned item
                    return firstCloned.offsetLeft;
                } else {
                    // Fallback: measure original items directly
                    const lastOriginal = posterItems[posterItems.length - 1];
                    return lastOriginal.offsetLeft + lastOriginal.offsetWidth;
                }
            }
            
            // Set up scrollable area - allow scrolling through original + cloned (2x width)
            function setupScrollArea() {
                const viewportWidth = window.innerWidth;
                const originalWidth = getOriginalItemsWidth();
                
                // Create scrollable height to allow scrolling through both original and cloned sections
                // This gives us room to scroll through cloned items before resetting
                const scrollHeight = (originalWidth * 2) + window.innerHeight;
                document.documentElement.style.height = scrollHeight + 'px';
                document.body.style.height = scrollHeight + 'px';
            }
            
            // Convert vertical scroll to horizontal scroll with smooth infinite loop
            let isResetting = false;
            
            window.addEventListener('scroll', () => {
                if (isResetting) return;
                
                const scrollY = window.pageYOffset || document.documentElement.scrollTop;
                const maxScroll = document.documentElement.scrollHeight - window.innerHeight;
                const originalWidth = getOriginalItemsWidth();
                
                if (maxScroll > 0 && originalWidth > 0) {
                    // Calculate horizontal scroll - allow it to go up to 2x originalWidth
                    // This lets us scroll through both original and cloned sections
                    const scrollPercentage = scrollY / maxScroll;
                    let horizontalScroll = scrollPercentage * (originalWidth * 2);
                    
                    // Smooth infinite loop: when we're well into the cloned section (past 1.5x),
                    // reset scroll position to equivalent position in original section
                    // This is invisible because cloned items are identical to originals
                    if (horizontalScroll >= originalWidth * 1.5) {
                        isResetting = true;
                        // Calculate wrapped position (equivalent in original section)
                        const wrappedPosition = horizontalScroll % originalWidth;
                        // Convert wrapped position to scrollY
                        // Since maxScroll represents 2x originalWidth, we need to map wrappedPosition correctly
                        const equivalentScrollY = (wrappedPosition / (originalWidth * 2)) * maxScroll;
                        
                        // Reset scroll position instantly (no animation)
                        window.scrollTo(0, equivalentScrollY);
                        
                        // Use wrapped position for transform to maintain perfect visual continuity
                        // This ensures the visual content doesn't change during reset
                        horizontalScroll = wrappedPosition;
                        
                        // Re-enable scrolling after reset completes
                        requestAnimationFrame(() => {
                            isResetting = false;
                        });
                    }
                    
                    // Apply transform - shows cloned items when scrolling past originalWidth
                    sliderContainer.style.transform = `translateX(-${horizontalScroll}px)`;
                }
            }, { passive: true });
            
            // Initialize on load
            window.addEventListener('load', () => {
                setTimeout(() => {
                    clonePosterItems();
                    setupScrollArea();
                    // Scroll to top initially
                    window.scrollTo(0, 0);
                }, 100);
            });
            
            // Recalculate on resize
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    // Remove cloned items and re-clone
                    document.querySelectorAll('.cloned-item').forEach(item => item.remove());
                    clonePosterItems();
                    setupScrollArea();
                }, 100);
            });
        })();
    </script>
{{--</body>--}}
{{--</html>--}}
@endsection
