<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->
<head>
    <title>Backend Console -{{@$site_settings['site_title']}}</title>
    <meta charset="utf-8" />
    <meta name="description" content="The most advanced Tailwind CSS & Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords" content="tailwind, tailwindcss, metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Metronic - The World's #1 Selling Tailwind CSS & Bootstrap Admin Template by KeenThemes" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Metronic by Keenthemes" />
    <link rel="canonical" href="http://preview.keenthemes.comindex.html" />
    <link rel="shortcut icon" href="{{asset('backend/assets/media/logos/favicon.ico')}}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{asset('backend/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{asset('backend/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
{{--    <link href="{{asset('ckeditor5/ckeditor5.css')}}" rel="stylesheet" type="text/css" />--}}
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @stack('styles')
    
    <!--begin::Professional Toolbar Styles-->
    <style>
        /* Professional Toolbar Styling */
        #kt_app_toolbar {
            background: #ffffff;
            margin-bottom: 0;
        }
        
        #kt_app_toolbar_container {
            padding: 1.5rem 0;
        }
        
        .page-heading {
            color: #181c32;
            font-weight: 600;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }
        
        .breadcrumb {
            margin-bottom: 0;
        }
        
        .breadcrumb-item a {
            color: #7e8299;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .breadcrumb-item a:hover {
            color: #009ef7;
        }
        
        .breadcrumb-item.text-muted {
            color: #7e8299;
        }
        
        .btn-primary {
            box-shadow: 0 2px 8px rgba(0, 158, 247, 0.25);
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            box-shadow: 0 4px 12px rgba(0, 158, 247, 0.35);
            transform: translateY(-1px);
        }
        
        @media (max-width: 991.98px) {
            #kt_app_toolbar {
                padding: 1rem 0;
            }
            
            #kt_app_toolbar_container {
                padding: 0.75rem 0;
            }
        }
    </style>
    <!--end::Professional Toolbar Styles-->

    <!--end::Global Stylesheets Bundle-->
    <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Page-->
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <!--begin::Header-->
        <div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-animation="false" data-kt-sticky-offset="{default: '0px', lg: '0px'}">
            <!--begin::Header container-->
            <div class="app-container container-fluid d-flex align-items-stretch flex-stack mt-lg-8" id="kt_app_header_container">
                <!--begin::Sidebar toggle-->
                <div class="d-flex align-items-center d-block d-lg-none ms-n3" title="Show sidebar menu">
                    <div class="btn btn-icon btn-active-color-primary w-35px h-35px me-1" id="kt_app_sidebar_mobile_toggle">
                        <i class="ki-outline ki-abstract-14 fs-2"></i>
                    </div>
                    <!--begin::Logo image-->
                    <a href="{{route('home')}}">
                        <img alt="Logo" src="{{asset('assets/images/logo-net.png')}}" class="h-25px theme-light-show" />
                        <img alt="Logo" src="{{asset('assets/images/logo-net.png')}}" class="h-25px theme-dark-show" />
                    </a>
                    <!--end::Logo image-->
                </div>
                <!--end::Sidebar toggle-->
                <!--begin::Navbar-->
                <div class="app-navbar flex-lg-grow-1" id="kt_app_header_navbar">

                    <!--end::Action-->
                </div>
                <!--end::Navbar-->
            </div>
            <!--end::Header container-->
        </div>
        <!--end::Header-->
        <!--begin::Wrapper-->
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            <!--begin::Sidebar-->
            @include('backend.partials.sidebar')
            <!--end::Sidebar-->
            <!--begin::Main-->
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <!--begin::Content wrapper-->
                @yield('content')
                <!--end::Content wrapper-->
                <!--begin::Footer-->
                <div id="kt_app_footer" class="app-footer">
                    <!--begin::Footer container-->
                    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                        <!--begin::Copyright-->
                        <div class="text-gray-900 order-2 order-md-1">
                            <span class="text-muted fw-semibold me-1">2025&copy;</span>
                            <a href="https://nerdware.com.np" target="_blank" class="text-gray-800 text-hover-primary">NERDWARE</a>
                        </div>
                        <!--end::Copyright-->
                        <!--begin::Menu-->
                        <!--end::Menu-->
                    </div>
                    <!--end::Footer container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end:::Main-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::App-->

<!--end::Drawers-->
<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-outline ki-arrow-up"></i>
</div>
<!--end::Scrolltop-->

<!--end::Modal - Invite Friend-->
<!--end::Modals-->
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('backend/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('backend/assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('backend/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js')}}"></script>
<script src="{{asset('backend/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('backend/assets/js/widgets.bundle.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/widgets.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/apps/chat/chat.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/utilities/modals/users-search.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function () {

        // ✅ Setup CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
    });
</script>
<script>
    @if(session('success'))
    toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
    toastr.error("{{ session('error') }}");
    @endif

    @if(session('warning'))
    toastr.warning("{{ session('warning') }}");
    @endif

    @if(session('info'))
    toastr.info("{{ session('info') }}");
    @endif
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    toastr.error("{{ $error }}");
    @endforeach
    @endif
</script>
<script>
    function deleteItem(id,url){
        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.action = url;
                form.method = 'POST';

                // CSRF token
                let token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = document.querySelector('meta[name="csrf-token"]').content;
                form.appendChild(token);

                // Spoof DELETE method
                let method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>

<script>
    $('#lfm').filemanager('image');
    $('#lfm1').filemanager('image', {multiple: true});
</script>
@stack('scripts')

<script>
    var options = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
        extraAllowedContent: 'img[src,alt,width,height]{*}(*);',
        imageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
        uploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
    };
    // Only initialize if not already initialized (allows page-specific initializations to take precedence)
    if (typeof CKEDITOR !== 'undefined' && !CKEDITOR.instances.ckeditor) {
        CKEDITOR.replace( 'ckeditor', options );
        // Allow webp images in CKEditor
        CKEDITOR.on('instanceReady', function(ev) {
            ev.editor.dataProcessor.htmlFilter.addRules({
                elements: {
                    img: function(element) {
                        // Allow webp images
                        if (element.attributes.src) {
                            var src = element.attributes.src;
                            if (src.match(/\.webp$/i)) {
                                element.attributes.src = src;
                            }
                        }
                    }
                }
            });
        });
    }
</script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
