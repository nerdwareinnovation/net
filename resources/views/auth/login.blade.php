{{--@extends('layouts.app')--}}
{{--@extends('frontend.partials.master')--}}


{{--@section('content')--}}
{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">{{ __('Login') }}</div>--}}

{{--                <div class="card-body">--}}
{{--                    <form method="POST" action="{{ route('login') }}">--}}
{{--                        @csrf--}}

{{--                        <div class="row mb-3">--}}
{{--                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

{{--                                @error('email')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row mb-3">--}}
{{--                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">--}}

{{--                                @error('password')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row mb-3">--}}
{{--                            <div class="col-md-6 offset-md-4">--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--                                    <label class="form-check-label" for="remember">--}}
{{--                                        {{ __('Remember Me') }}--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row mb-0">--}}
{{--                            <div class="col-md-8 offset-md-4">--}}
{{--                                <button type="submit" class="btn btn-primary">--}}
{{--                                    {{ __('Login') }}--}}
{{--                                </button>--}}

{{--                                @if (Route::has('password.request'))--}}
{{--                                    <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                        {{ __('Forgot Your Password?') }}--}}
{{--                                    </a>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endsection--}}

<!DOCTYPE html>

<html lang="en" >
<!--begin::Head-->
<head>
    <title>Happy Lemon Tree - Backoffice</title>
    <meta charset="utf-8"/>
    <meta name="description" content="
            The most advanced Tailwind CSS & Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo,
            Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions.
            Grab your copy now and get life-time updates for free.
        "/>
    <meta name="keywords" content="
            tailwind, tailwindcss, metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js,
            Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates,
            free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button,
            bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon
        "/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Metronic - The World's #1 Selling Tailwind CSS & Bootstrap Admin Template by KeenThemes" />
    <meta property="og:url" content="https://keenthemes.com/metronic"/>
    <meta property="og:site_name" content="Metronic by Keenthemes" />
    <link rel="canonical" href="https://preview.keenthemes.com{{asset('backend/assets/authentication/layouts/fancy/sign-up.html')}}"/>
    <link rel="shortcut icon" href="{{asset('backend/assets/media/logos/favicon.ico')}}"/>

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>        <!--end::Fonts-->



    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{asset('backend/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('backend/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <!--end::Global Stylesheets Bundle-->

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-52YZ3XGZJ6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-52YZ3XGZJ6');
    </script>
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>
<!--end::Head-->

<!--begin::Body-->
<body  id="kt_body"  class="app-blank" >
<!--begin::Theme mode setup on page load-->
<script>
    var defaultThemeMode = "light";
    var themeMode;

    if ( document.documentElement ) {
        if ( document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if ( localStorage.getItem("data-bs-theme") !== null ) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }

        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }

        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
</script>
<!--end::Theme mode setup on page load-->

<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">

    <!--begin::Authentication - Sign-up -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Logo-->
        <a href="#" class="d-block d-lg-none mx-auto py-20">
            <img alt="Logo" src="{{asset('backend/assets/media/logos/default.svg')}}" class="theme-light-show h-25px"/>
            <img alt="Logo" src="{{asset('backend/assets/media/logos/default-dark.svg')}}" class="theme-dark-show h-25px"/>
        </a>
        <!--end::Logo-->

        <!--begin::Aside-->
        <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
            <!--begin::Wrapper-->
            <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                <!--begin::Header-->
                <div class="d-flex flex-stack py-2">
                    <!--begin::Back link-->
                    <div class="me-2">
                        <a href="{{url('/')}}" class="btn btn-icon bg-light rounded-circle" title="Back to Home">
                            <i class="ki-outline ki-black-left fs-2 text-gray-800"></i>
                        </a>
                    </div>
                    <!--end::Back link-->


                    <!--begin::Sign Up link-->
                    <div class="m-0">
                        <span class="text-gray-500 fw-bold fs-5 me-2">
                            Not a member yet?
                        </span>

                        <a href="{{route('register')}}" class="link-primary fw-bold fs-5">
                            Sign Up
                        </a>
                    </div>
                    <!--end::Sign Up link--->




                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="py-10">

                    <!--begin::Form-->
                    <form class="form w-100"  method="POST" enctype="multipart/form-data">@csrf
                        <!--begin::Heading-->
                        <div class="text-start mb-10">
                            <!--begin::Title-->
                            <h5 class="text-gray-900 mb-3 fs-2x" data-kt-translate="sign-up-title">
                             Login to Happy Lemon Tree
                            </h5>
                            <!--end::Title-->

                            <!--begin::Text-->
{{--                            <div class="text-gray-500 fw-semibold fs-6" data-kt-translate="general-desc">--}}
{{--                                Get unlimited access & earn money--}}
{{--                            </div>--}}
                            <!--end::Link-->
                        </div>
                        <!--end::Heading-->


                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <input class="form-control form-control-lg form-control-solid" type="email" placeholder="Email" name="email" autocomplete="off" data-kt-translate="sign-up-input-email"/>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-10" data-kt-password-meter="true">
                            <!--begin::Wrapper-->
                            <div class="mb-1">
                                <!--begin::Input wrapper-->
                                <div class="position-relative mb-3">
                                    <input class="form-control form-control-lg form-control-solid" type="password" placeholder="Password" name="password" autocomplete="off" data-kt-translate="sign-up-input-password"/>

                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                    <i class="ki-outline ki-eye-slash fs-2"></i>                    <i class="ki-outline ki-eye fs-2 d-none"></i>                </span>
                                </div>
                                <!--end::Input wrapper-->


                            </div>
                            <!--end::Wrapper-->

                        </div>
                        <!--end::Input group--->


                        <!--begin::Actions-->
                        <div class="d-flex flex-stack">
                            <!--begin::Submit-->
                            <button id="kt_sign_up_submit" class="btn btn-primary" data-kt-translate="sign-up-submit">

                                <!--begin::Indicator label-->
                                <span class="indicator-label">
    Submit</span>
                                <!--end::Indicator label-->

                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">
    Please wait...    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
                                <!--end::Indicator progress-->        </button>
                            <!--end::Submit-->


                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Body-->

                <!--begin::Footer-->
                <div class="m-0">
                    <!--begin::Toggle-->

                    <!--end::Toggle-->

                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4" data-kt-menu="true" id="kt_auth_lang_menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{asset('backend/assets/media/flags/united-states.svg')}}" alt=""/>
                                </span>
                                <span data-kt-element="lang-name">English</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{asset('backend/assets/media/flags/spain.svg')}}" alt=""/>
                                </span>
                                <span data-kt-element="lang-name">Spanish</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{asset('backend/assets/media/flags/germany.svg')}}" alt=""/>
                                </span>
                                <span data-kt-element="lang-name">German</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{asset('backend/assets/media/flags/japan.svg')}}" alt=""/>
                                </span>
                                <span data-kt-element="lang-name">Japanese</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{asset('backend/assets/media/flags/france.svg')}}" alt=""/>
                                </span>
                                <span data-kt-element="lang-name">French</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Aside-->

        <!--begin::Body-->
        <div class="d-none d-lg-flex flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat position-relative"
             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);">
            <!-- Overlay Pattern -->
            <div class="position-absolute w-100 h-100" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.05&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); opacity: 0.3;"></div>
            
            <!-- Content Overlay -->
            <div class="d-flex flex-column justify-content-center align-items-center w-100 px-10 position-relative" style="z-index: 1;">
                <div class="text-center mb-10">
                    <i class="fa fa-tree" style="font-size: 80px; color: rgba(255,255,255,0.9); margin-bottom: 20px;"></i>
                    <h2 class="text-white fw-bold fs-2x mb-5">Welcome to Happy Lemon Tree</h2>
                    <p class="text-white fs-4 fw-semibold" style="opacity: 0.9; max-width: 500px; line-height: 1.6;">
                        Your gateway to unforgettable stays, amazing tours, and unique experiences
                    </p>
                </div>
                
                <!-- Feature Pills -->
                <div class="d-flex flex-wrap justify-content-center gap-3 mt-5">
                    <div class="badge badge-light-primary" style="padding: 12px 20px; font-size: 14px; background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.3);">
                        <i class="fa fa-bed me-2"></i>Luxury Stays
                    </div>
                    <div class="badge badge-light-success" style="padding: 12px 20px; font-size: 14px; background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.3);">
                        <i class="fa fa-map-marker-alt me-2"></i>Guided Tours
                    </div>
                    <div class="badge badge-light-info" style="padding: 12px 20px; font-size: 14px; background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.3);">
                        <i class="fa fa-compass me-2"></i>Experiences
                    </div>
                    <div class="badge badge-light-warning" style="padding: 12px 20px; font-size: 14px; background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.3);">
                        <i class="fa fa-shopping-cart me-2"></i>Products
                    </div>
                </div>
            </div>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-up-->
</div>
<!--end::Root-->

<!--begin::Javascript-->
<script>
    var hostUrl = "#";        </script>

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('backend/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('backend/assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->


<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('backend/assets/js/custom/authentication/sign-up/general.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/authentication/sign-in/i18n.js')}}"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
