<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    @php
        $defaultTitle = @$site_settings['meta_title'] ?? @$site_settings['site_title'] ?? 'Never Ending Trails';
        $defaultMetaDescription = @$site_settings['meta_description'] ?? '';
        $defaultMetaKeywords = @$site_settings['meta_keywords'] ?? '';
        $defaultOgImage = @$site_settings['og_image'] ?? '';
        $favicon = @$site_settings['favicon'] ?? null;
        
        // Get page-specific values or use defaults
        $pageTitle = $__env->hasSection('title') ? trim($__env->yieldContent('title')) : $defaultTitle;
        $pageMetaDescription = $__env->hasSection('meta_description') ? trim($__env->yieldContent('meta_description')) : $defaultMetaDescription;
        $pageMetaKeywords = $__env->hasSection('meta_keywords') ? trim($__env->yieldContent('meta_keywords')) : $defaultMetaKeywords;
        $pageOgImage = $__env->hasSection('og_image') ? trim($__env->yieldContent('og_image')) : $defaultOgImage;
    @endphp
    
    <title>{{$pageTitle}}</title>
    
    @if($pageMetaDescription)
    <meta name="description" content="{{$pageMetaDescription}}">
    @endif
    
    @if($pageMetaKeywords)
    <meta name="keywords" content="{{$pageMetaKeywords}}">
    @endif
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="og:title" content="{{$pageTitle}}">
    @if($pageMetaDescription)
    <meta property="og:description" content="{{$pageMetaDescription}}">
    @endif
    @if($pageOgImage)
    <meta property="og:image" content="{{asset($pageOgImage)}}">
    @endif
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{url()->current()}}">
    <meta property="twitter:title" content="{{$pageTitle}}">
    @if($pageMetaDescription)
    <meta property="twitter:description" content="{{$pageMetaDescription}}">
    @endif
    @if($pageOgImage)
    <meta property="twitter:image" content="{{asset($pageOgImage)}}">
    @endif
    
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Prata&amp;display=swap" rel="stylesheet">
    <meta name="robots" content="noindex, nofollow">
{{--    @if(\Request::route()->getName() != 'front.gallery')--}}
    <link rel="stylesheet" href="{{asset('assets/css/css-style.css')}}">
{{--    @endif--}}
    
    <!-- Mobile Menu Styles - Simple and Clean -->
    <style>
        /* Desktop: Hide mobile menu */
        @media (min-width: 901px) {
            .mobile-menu-toggle,
            .mobile-side-menu {
                display: none !important;
            }
        }
        
        /* Mobile: Show hamburger, hide main nav */
        @media (max-width: 900px) {
            .main-navbar-left,
            .main-navbar-right {
                display: none !important;
            }
            
            .mobile-menu-toggle {
                display: flex;
                flex-direction: column;
                justify-content: space-around;
                width: 30px;
                height: 30px;
                background: transparent;
                border: none;
                cursor: pointer;
                padding: 0;
                position: absolute;
                right: 20px;
                top: 50%;
                transform: translateY(-50%);
                z-index: 1001;
            }
            
            .mobile-menu-toggle span {
                width: 100%;
                height: 3px;
                background: #ffffff;
                border-radius: 3px;
                display: block;
            }
            
            /* Mobile Menu */
            .mobile-side-menu {
                visibility: hidden;
                opacity: 0;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 10000;
                pointer-events: none;
                transition: visibility 0s linear 0.5s, opacity 0.3s ease;
            }
            
            .mobile-side-menu.active {
                visibility: visible;
                opacity: 1;
                pointer-events: auto;
                transition: visibility 0s linear 0s, opacity 0.3s ease;
            }
            
            /* Overlay - only for background, doesn't block menu */
            .mobile-side-menu-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0);
                opacity: 0;
                transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1), background 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 10001;
            }
            
            .mobile-side-menu.active .mobile-side-menu-overlay {
                background: rgba(0, 0, 0, 0.6);
                opacity: 1;
            }
            
            /* Menu Content - slides from right with elegant animation */
            .mobile-side-menu-content {
                position: fixed;
                top: 0;
                right: 0;
                width: 320px;
                max-width: 85%;
                height: 100%;
                background: #000000;
                box-shadow: -2px 0 20px rgba(0, 0, 0, 0.5);
                transform: translateX(100%);
                transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) 0s;
                overflow-y: auto;
                z-index: 10002;
                will-change: transform;
            }
            
            .mobile-side-menu.active .mobile-side-menu-content {
                transform: translateX(0);
                transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) 0s;
            }
            
            /* Staggered animation for menu items */
            .mobile-side-menu-nav {
                opacity: 0;
                transform: translateY(20px);
                transition: opacity 0.4s ease 0.2s, transform 0.4s ease 0.2s;
            }
            
            .mobile-side-menu.active .mobile-side-menu-nav {
                opacity: 1;
                transform: translateY(0);
            }
            
            .mobile-nav-link {
                opacity: 0;
                transform: translateX(20px);
                transition: opacity 0.3s ease, transform 0.3s ease, background 0.3s ease, padding 0.3s ease;
            }
            
            .mobile-side-menu.active .mobile-nav-link {
                opacity: 1;
                transform: translateX(0);
            }
            
            .mobile-side-menu.active .mobile-nav-link:nth-child(1) {
                transition-delay: 0.1s;
            }
            
            .mobile-side-menu.active .mobile-nav-link:nth-child(2) {
                transition-delay: 0.15s;
            }
            
            .mobile-side-menu.active .mobile-nav-link:nth-child(3) {
                transition-delay: 0.2s;
            }
            
            .mobile-side-menu.active .mobile-nav-link:nth-child(4) {
                transition-delay: 0.25s;
            }
            
            .mobile-side-menu.active .mobile-nav-link:nth-child(5) {
                transition-delay: 0.3s;
            }
            
            .mobile-side-menu.active .mobile-nav-link:nth-child(6) {
                transition-delay: 0.35s;
            }
            
            /* Header with close button */
            .mobile-side-menu-header {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                padding: 25px 20px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .mobile-menu-close {
                width: 35px;
                height: 35px;
                background: transparent;
                border: none;
                cursor: pointer;
                padding: 0;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .mobile-menu-close span {
                position: absolute;
                width: 22px;
                height: 2px;
                background: #ffffff;
                border-radius: 2px;
            }
            
            .mobile-menu-close span:first-child {
                transform: rotate(45deg);
            }
            
            .mobile-menu-close span:last-child {
                transform: rotate(-45deg);
            }
            
            /* Navigation Links */
            .mobile-side-menu-nav {
                display: flex;
                flex-direction: column;
                padding: 30px 0;
            }
            
            .mobile-nav-link {
                display: block;
                padding: 18px 25px;
                color: #ffffff;
                text-decoration: none;
                font-size: 16px;
                font-weight: 500;
                letter-spacing: 0.5px;
                text-transform: uppercase;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }
            
            .mobile-nav-link:hover {
                background: rgba(255, 255, 255, 0.05);
                padding-left: 30px;
            }
            
            body.mobile-menu-open {
                overflow: hidden;
            }
        }
    </style>
    
    @if($favicon)
    <link rel="icon" type="image/png" href="{{asset($favicon)}}">
    <link rel="shortcut icon" href="{{asset($favicon)}}">
    @else
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/favicons/favicons-apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/favicons/favicons-favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicons/favicons-favicon-16x16.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicons/favicons-android-chrome-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicons/favicons-android-chrome-512x512.png')}}">
    <link rel="icon" type="image/png" href="{{asset('assets/favicons/favicons-favicon-32x32.png')}}" sizes="32x32">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicons/favicons-favicon.ico')}}">
    @endif
    
    <meta name="msapplication-TileColor" content="#151515">
    <meta name="theme-color" content="#151515">
    
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
       (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
       m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
       (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

       ym(54999082, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
       });
    </script>
    <noscript><div><img src="{{asset('assets/images/watch-54999082')}}" style="position:absolute; left:-9999px;" alt=""></div></noscript>
    <!-- /Yandex.Metrika counter -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-158726751-4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-158726751-4');
</script>
    @stack('styles')
</head>
<body @yield('body-class', '')>
    <div class="container">
        @include('frontend.partials.header')

        @yield('content')

        @if(!isset($hideFooter) || !$hideFooter)
            @include('frontend.partials.footer')
        @endif
</div>

    @stack('modals')
    
    <script src="{{asset('assets/js/818-js-jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/9044-js-jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/js/5348-js-lightgallery.js')}}"></script>
	<script src="{{asset('assets/js/5619-js-jquery.mousewheel.min.js')}}"></script> 
    <script src="{{asset('assets/js/1096-js-slick.min.js')}}"></script>
    <script src="{{asset('assets/js/5706-js-hammer.js')}}"></script>
    <script src="{{asset('assets/js/4412-js-scripts.min.js')}}"></script>
    
    @stack('scripts')
</body>
</html>
