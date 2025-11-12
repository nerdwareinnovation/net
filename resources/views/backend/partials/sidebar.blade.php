<style>
    /* Active state for child menu items - Simple and elegant */
    .menu-sub-accordion .menu-item .menu-link.active {
        background-color: #e8f4fd !important;
        color: #009ef7 !important;
        font-weight: 600;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    
    .menu-sub-accordion .menu-item .menu-link.active .bullet {
        background-color: #009ef7 !important;
    }
    
    .menu-sub-accordion .menu-item .menu-link.active .menu-title {
        color: #009ef7 !important;
    }
    
    /* Hover effect for inactive child items */
    .menu-sub-accordion .menu-item .menu-link:not(.active):hover {
        background-color: #f5f8fa;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    
    /* Active state for top-level menu items - match existing here/show styling */
    .menu-item:not(.menu-accordion).here .menu-link,
    .menu-item:not(.menu-accordion) .menu-link.active {
        background-color: #252f4a !important;
        color: #ffffff !important;
        transition: color .2s ease;
    }
    
    .menu-item:not(.menu-accordion).here .menu-link .menu-icon,
    .menu-item:not(.menu-accordion) .menu-link.active .menu-icon,
    .menu-item:not(.menu-accordion).here .menu-link:hover .menu-icon,
    .menu-item:not(.menu-accordion) .menu-link.active:hover .menu-icon {
        color: #ffffff !important;
    }
    
    .menu-item:not(.menu-accordion).here .menu-link .menu-title,
    .menu-item:not(.menu-accordion) .menu-link.active .menu-title,
    .menu-item:not(.menu-accordion).here .menu-link:hover .menu-title,
    .menu-item:not(.menu-accordion) .menu-link.active:hover .menu-title {
        color: #ffffff !important;
    }
    
    /* Hover state for active top-level menu items */
    .menu-item:not(.menu-accordion).here .menu-link:hover,
    .menu-item:not(.menu-accordion) .menu-link.active:hover {
        background-color: #252f4a !important;
        color: #ffffff !important;
    }
    
    /* Ensure icon is white for here/show menu items - match existing rule */
    .app-sidebar .menu > .menu-item.here > .menu-link .menu-icon i,
    .app-sidebar .menu > .menu-item.here > .menu-link.active .menu-icon i {
        color: var(--bs-white) !important;
    }
</style>
<div id="kt_app_sidebar" class="app-sidebar flex-column mt-lg-4 ps-2 pe-2 ps-lg-7 pe-lg-4" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo flex-shrink-0 d-none d-lg-flex flex-center align-items-center w-100 px-4" id="kt_app_sidebar_logo">
        <!--begin::Logo-->
        <a href="{{route('home')}}" class="w-100 d-flex justify-content-center">
            <img alt="Logo" src="{{asset('assets/images/logo-net.png')}}" class="w-100 h-auto d-none d-sm-inline app-sidebar-logo-default theme-light-show" style="max-height: 100px; object-fit: contain;" />
            <img alt="Logo" src="{{asset('assets/images/logo-net.png')}}" class="w-100 h-auto theme-dark-show" style="max-height: 100px; object-fit: contain;" />
        </a>
        <!--end::Logo-->
        <!--begin::Aside toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
            <div class="btn btn-icon btn-active-color-primary w-30px h-30px" id="kt_aside_mobile_toggle">
                <i class="ki-outline ki-abstract-14 fs-1"></i>
            </div>
        </div>
        <!--end::Aside toggle-->
    </div>
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px">
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-sub-indention fw-bold px-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <div class="menu-item {{Route::is('home') ? 'here show' : ''}} ">
                    <!--begin:Menu link-->
                    <a class="menu-link" href="{{route('home')}}">
												<span class="menu-icon">
													<i class="bi bi-speedometer2 fs-2"></i>
												</span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                @if(!auth()->user()->hasRole('Customer'))
                <!-- Stories -->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{Route::is('admin.story-categories.*') || Route::is('admin.stories.*') ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-book fs-2"></i>
                        </span>
                        <span class="menu-title">Stories</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{Route::is('admin.story-categories.*') ? 'active' : ''}}" href="{{route('admin.story-categories.index')}}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Story Categories</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{Route::is('admin.stories.*') ? 'active' : ''}}" href="{{route('admin.stories.index')}}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Stories</span>
                            </a>
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                
                <!-- Gallery -->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{Route::is('admin.gallery-categories.*') || Route::is('admin.galleries.*') ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-images fs-2"></i>
                        </span>
                        <span class="menu-title">Gallery</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{Route::is('admin.gallery-categories.*') ? 'active' : ''}}" href="{{route('admin.gallery-categories.index')}}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Gallery Categories</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{Route::is('admin.galleries.*') ? 'active' : ''}}" href="{{route('admin.galleries.index')}}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Galleries</span>
                            </a>
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                
                <!-- Films -->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{Route::is('admin.film-categories.*') || Route::is('admin.films.*') ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-film fs-2"></i>
                        </span>
                        <span class="menu-title">Films</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{Route::is('admin.film-categories.*') ? 'active' : ''}}" href="{{route('admin.film-categories.index')}}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Film Categories</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{Route::is('admin.films.*') ? 'active' : ''}}" href="{{route('admin.films.index')}}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Films</span>
                            </a>
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                
                <!-- Products -->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{Route::is('admin.product-categories.*') || Route::is('admin.products.*') ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-box fs-2"></i>
                        </span>
                        <span class="menu-title">Products</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{Route::is('admin.product-categories.*') ? 'active' : ''}}" href="{{route('admin.product-categories.index')}}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Product Categories</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{Route::is('admin.products.*') ? 'active' : ''}}" href="{{route('admin.products.index')}}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Products</span>
                            </a>
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                
                <!-- CMS -->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{Route::is('admin.site-settings.*') || Route::is('admin.site-page-settings.*') || Route::is('admin.custom-fields.*') || Route::is('admin.about-settings.*') || Route::is('admin.contact-settings.*') || Route::is('admin.homepage-settings.*') || Route::is('admin.banners.*') ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-sliders fs-2"></i>
                        </span>
                        <span class="menu-title">CMS</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{Route::is('admin.site-settings.*') ? 'active' : ''}}" href="{{route('admin.site-settings.index')}}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Site Settings</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{Route::is('admin.site-page-settings.*') ? 'active' : ''}}" href="{{route('admin.site-page-settings.index')}}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Custom Pages</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{Route::is('admin.homepage-settings.*') ? 'active' : ''}}" href="{{route('admin.homepage-settings.index')}}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Homepage Settings</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{Route::is('admin.about-settings.*') ? 'active' : ''}}" href="{{route('admin.about-settings.index')}}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">About Settings</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{Route::is('admin.contact-settings.*') ? 'active' : ''}}" href="{{route('admin.contact-settings.index')}}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Contact Settings</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{Route::is('admin.banners.*') ? 'active' : ''}}" href="{{route('admin.banners.index')}}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Banners</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{Route::is('admin.custom-fields.*') ? 'active' : ''}}" href="{{route('admin.custom-fields.index')}}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Custom Fields</span>
                            </a>
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                
                <!-- Contact Messages -->
                <div class="menu-item {{Route::is('admin.contact-messages.*') ? 'here show' : ''}} ">
                    <!--begin:Menu link-->
                    <a class="menu-link" href="{{route('admin.contact-messages.index')}}">
                        <span class="menu-icon">
                            <i class="bi bi-envelope fs-2"></i>
                        </span>
                        <span class="menu-title">Contact Messages</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                @else
                    <div class="menu-item">
                        <a class="menu-link" href="{{route('front.index')}}" target="_blank">
                            <span class="menu-icon">
                                <i class="bi bi-globe fs-2"></i>
                            </span>
                            <span class="menu-title">Visit Website</span>
                        </a>
                    </div>
                @endif
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
    <!--begin::Footer-->
    <div class="app-sidebar-footer d-flex align-items-center px-8 pb-10" id="kt_app_sidebar_footer">
        <!--begin::User-->
        <div class="">
            <!--begin::User info-->
            <div class="d-flex align-items-center" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-overflow="true" data-kt-menu-placement="top-start">
                <div class="d-flex flex-center cursor-pointer symbol symbol-circle symbol-40px">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=009ef7&color=fff&size=40&font-size=0.5" alt="{{ auth()->user()->name ?? 'User' }}" />
                </div>
                <!--begin::Name-->
                <div class="d-flex flex-column align-items-start justify-content-center ms-3">
                    <span class="text-gray-500 fs-8 fw-semibold">Welcome back!</span>
                    <a href="#" class="text-gray-800 fs-7 fw-bold text-hover-primary">{{ auth()->user()->name ?? 'User' }}</a>
                </div>
                <!--end::Name-->
            </div>
            <!--end::User info-->
            <!--begin::User account menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <div class="menu-content d-flex align-items-center px-3">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-50px me-5">
                            <img alt="{{ auth()->user()->name ?? 'User' }}" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=009ef7&color=fff&size=50&font-size=0.5" />
                        </div>
                        <!--end::Avatar-->
                        <!--begin::Username-->
                        <div class="d-flex flex-column">
                            <div class="fw-bold d-flex align-items-center fs-5">{{ strtoupper(auth()->user()->name ?? 'USER') }}</div>
                            <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ auth()->user()->email ?? '' }}</a>
                        </div>
                        <!--end::Username-->
                    </div>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu separator-->
                <div class="separator my-2"></div>
                <!--end::Menu separator-->
                <!--begin::Menu item-->
                <div class="menu-item px-5">
                    <a href="{{route('customer.profile')}}" class="menu-link px-5">My Profile</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->

                <!--end::Menu separator-->
                <!--begin::Menu item-->
                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                    <a href="#" class="menu-link px-5">
											<span class="menu-title position-relative">Mode
											<span class="ms-5 position-absolute translate-middle-y top-50 end-0">
												<i class="ki-outline ki-night-day theme-light-show fs-2"></i>
												<i class="ki-outline ki-moon theme-dark-show fs-2"></i>
											</span></span>
                    </a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-outline ki-night-day fs-2"></i>
													</span>
                                <span class="menu-title">Light</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-outline ki-moon fs-2"></i>
													</span>
                                <span class="menu-title">Dark</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-outline ki-screen fs-2"></i>
													</span>
                                <span class="menu-title">System</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Menu item-->

                <div class="menu-item px-5">
                    <a class="menu-link px-5" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </div>


                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                <!--end::Menu item-->
            </div>
            <!--end::User account menu-->
        </div>
        <!--end::User-->
    </div>
    <!--end::Footer-->
</div>
