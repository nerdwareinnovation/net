<div class="main-navbar">
    <div class="main-navbar-container">
        <div class="main-navbar-left">
            <a href="{{route('front.index')}}" class="main-nav-link">Home</a>
            <a href="{{route('front.gallery')}}" class="main-nav-link">Gallery</a>
            <a href="{{route('front.films')}}" class="main-nav-link">Films</a>
        </div>
        <div class="main-navbar-center">
            <a href="{{route('front.index')}}" class="main-navbar-logo">
                <img src="{{asset('assets/images/logo-net.png')}}" alt="Logo">
            </a>
        </div>
        <div class="main-navbar-right">
            <a href="{{route('front.stories')}}" class="main-nav-link">Stories</a>
            <a href="{{route('front.about')}}" class="main-nav-link">About</a>
            <a href="{{route('front.contact')}}" class="main-nav-link">Contact</a>
        </div>
        <!-- Mobile Hamburger Menu -->
        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</div>

<!-- Mobile Side Menu -->
<div class="mobile-side-menu" id="mobileSideMenu">
    <div class="mobile-side-menu-overlay" id="mobileMenuOverlay"></div>
    <div class="mobile-side-menu-content">
        <div class="mobile-side-menu-header">
            <button class="mobile-menu-close" id="mobileMenuClose" aria-label="Close menu">
                <span></span>
                <span></span>
            </button>
        </div>
        <nav class="mobile-side-menu-nav">
            <a href="{{route('front.index')}}" class="mobile-nav-link">Home</a>
            <a href="{{route('front.gallery')}}" class="mobile-nav-link">Gallery</a>
            <a href="{{route('front.films')}}" class="mobile-nav-link">Films</a>
            <a href="{{route('front.stories')}}" class="mobile-nav-link">Stories</a>
            <a href="{{route('front.about')}}" class="mobile-nav-link">About</a>
            <a href="{{route('front.contact')}}" class="mobile-nav-link">Contact</a>
        </nav>
    </div>
</div>


@push('scripts')
<script>
    (function() {
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenuClose = document.getElementById('mobileMenuClose');
        const mobileSideMenu = document.getElementById('mobileSideMenu');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        const body = document.body;
        
        function openMenu() {
            mobileSideMenu.classList.add('active');
            body.classList.add('mobile-menu-open');
        }
        
        function closeMenu() {
            mobileSideMenu.classList.remove('active');
            body.classList.remove('mobile-menu-open');
        }
        
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', openMenu);
        }
        
        if (mobileMenuClose) {
            mobileMenuClose.addEventListener('click', closeMenu);
        }
        
        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', closeMenu);
        }
        
        // Close menu when clicking on a nav link
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Small delay to allow navigation
                setTimeout(closeMenu, 100);
            });
        });
        
        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileSideMenu.classList.contains('active')) {
                closeMenu();
            }
        });
    })();
</script>
@endpush
