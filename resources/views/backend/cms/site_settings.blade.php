@extends('backend.partials.master')

@section('content')
    <style>
        .thumbnail-preview {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        .thumbnail-item {
            position: relative;
            width: 80px;
            height: 80px;
            border: 1px solid #e4e6ef;
            border-radius: 6px;
            overflow: hidden;
            background: #f9f9f9;
        }

        .thumbnail-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumbnail-item .delete-btn {
            position: absolute;
            top: 3px;
            right: 3px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 4px;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.2s;
            padding: 0;
            font-size: 10px;
            color: #f1416c;
        }

        .thumbnail-item:hover .delete-btn {
            opacity: 1;
        }

        .thumbnail-item .delete-btn:hover {
            background: #f1416c;
            color: white;
        }

        .card-flush .card-header {
            min-height: 30px;
            padding: 10px 20px;
        }

        .card-flush .card-title h5 {
            font-size: 14px;
            margin: 0;
        }
    </style>

    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Site Settings</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">CMS</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card body-->
                    <div class="card-body">
                        <form class="form" action="{{route('admin.site-settings.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Basic Information Section -->
                            <h4 class="text-gray-800 mb-6">Basic Information</h4>
                            
                            <div class="row mb-8">
                                <div class="col-md-12">
                                    <div class="fv-row mb-7">
                                        <label class="required fs-6 fw-semibold mb-2">Site Title</label>
                                        <input type="text" class="form-control form-control-solid" value="{{@$settings['site_title']}}" placeholder="Enter Site Title" name="site_title" />
                                    </div>
                                </div>
                            </div>

                            <!-- Site Logo Section -->
                            <h4 class="text-gray-800 mb-6 mt-10" style="border-top: 1px solid #e4e6ef; padding-top: 20px;">Site Branding</h4>
                            
                            <div class="row mb-8">
                                <div class="col-md-12">
                                    <!--begin::Card-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h5>Site Logo</h5>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body text-center pt-0">
                                            <div class="thumbnail-preview" id="holder" style="justify-content: flex-start;">
                                                @if(isset($settings['site_logo']) && $settings['site_logo'])
                                                    <div class="thumbnail-item">
                                                        <img src="{{asset($settings['site_logo'])}}" alt="Logo">
                                                        <button type="button" class="delete-btn" onclick="deleteThumbnail()">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="mt-4">
                                                <button type="button" class="btn btn-sm btn-primary" onclick="chooseThumbnail()">
                                                    <i class="fa fa-image"></i> Choose Logo
                                                </button>
                                            </div>
                                            <input type="hidden" id="thumbnail" name="site_logo" value="{{@$settings['site_logo']}}">
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                            </div>

                            <!-- Contact Information Section -->
                            <h4 class="text-gray-800 mb-6 mt-10" style="border-top: 1px solid #e4e6ef; padding-top: 20px;">Contact Information</h4>
                            
                            <div class="row mb-8">
                                <div class="col-md-4">
                                    <div class="fv-row mb-7">
                                        <label class="required fs-6 fw-semibold mb-2">Contact Number</label>
                                        <input type="text" class="form-control form-control-solid" value="{{@$settings['contact_number']}}" placeholder="Enter Contact Number" name="contact_number" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="fv-row mb-7">
                                        <label class="required fs-6 fw-semibold mb-2">Email</label>
                                        <input type="email" class="form-control form-control-solid" value="{{@$settings['email']}}" placeholder="Enter Email Address" name="email" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="fv-row mb-7">
                                        <label class="required fs-6 fw-semibold mb-2">Address</label>
                                        <input type="text" class="form-control form-control-solid" value="{{@$settings['address']}}" placeholder="Enter Address" name="address" />
                                    </div>
                                </div>
                            </div>

                            <!-- Social Media Section -->
                            <h4 class="text-gray-800 mb-6 mt-10" style="border-top: 1px solid #e4e6ef; padding-top: 20px;">Social Media Links</h4>
                            
                            <div class="row mb-8">
                                <div class="col-md-6">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold mb-2">Facebook URL</label>
                                        <input type="url" class="form-control form-control-solid" value="{{@$settings['fb_url']}}" placeholder="Enter Facebook URL" name="fb_url" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold mb-2">Instagram URL</label>
                                        <input type="url" class="form-control form-control-solid" value="{{@$settings['insta_url']}}" placeholder="Enter Instagram URL" name="insta_url" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold mb-2">Twitter URL</label>
                                        <input type="url" class="form-control form-control-solid" value="{{@$settings['twitter_url']}}" placeholder="Enter Twitter URL" name="twitter_url" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold mb-2">LinkedIn URL</label>
                                        <input type="url" class="form-control form-control-solid" value="{{@$settings['linkedin_url']}}" placeholder="Enter LinkedIn URL" name="linkedin_url" />
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Settings Section -->
                            <h4 class="text-gray-800 mb-6 mt-10" style="border-top: 1px solid #e4e6ef; padding-top: 20px;">SEO Settings</h4>
                            
                            <div class="row mb-8">
                                <div class="col-md-12">
                                    <!--begin::Card-->
                                    <div class="card card-flush py-4 mb-7">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h5>Favicon</h5>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body text-center pt-0">
                                            <div class="thumbnail-preview" id="favicon-holder" style="justify-content: flex-start;">
                                                @if(isset($settings['favicon']) && $settings['favicon'])
                                                    <div class="thumbnail-item">
                                                        <img src="{{asset($settings['favicon'])}}" alt="Favicon">
                                                        <button type="button" class="delete-btn" onclick="deleteFavicon()">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="mt-4">
                                                <button type="button" class="btn btn-sm btn-primary" onclick="chooseFavicon()">
                                                    <i class="fa fa-image"></i> Choose Favicon
                                                </button>
                                            </div>
                                            <input type="hidden" id="favicon" name="favicon" value="{{@$settings['favicon']}}">
                                            <div class="form-text mt-2">Recommended size: 32x32px or 16x16px. Formats: .ico, .png, .svg</div>
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                <div class="col-md-12">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold mb-2">Default Meta Title</label>
                                        <input type="text" class="form-control form-control-solid" value="{{@$settings['meta_title']}}" placeholder="Enter default meta title" name="meta_title" />
                                        <div class="form-text">This will be used as the default page title if not specified on individual pages</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold mb-2">Default Meta Description</label>
                                        <textarea class="form-control form-control-solid" name="meta_description" rows="3" placeholder="Enter default meta description">{{@$settings['meta_description']}}</textarea>
                                        <div class="form-text">Recommended length: 150-160 characters. This will be used as the default meta description if not specified on individual pages</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold mb-2">Default Meta Keywords</label>
                                        <input type="text" class="form-control form-control-solid" value="{{@$settings['meta_keywords']}}" placeholder="keyword1, keyword2, keyword3" name="meta_keywords" />
                                        <div class="form-text">Enter keywords separated by commas. This will be used as the default meta keywords if not specified on individual pages</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold mb-2">Open Graph Image</label>
                                        <!--begin::Card-->
                                        <div class="card card-flush py-4">
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h5 class="fw-bold m-0">Social Media Preview Image</h5>
                                                </div>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body text-center pt-0">
                                                <p class="text-muted mb-4">Image shown when sharing on social media (Facebook, Twitter, etc.)</p>
                                                <div class="thumbnail-preview" id="og-image-holder" style="justify-content: flex-start;">
                                                    @if(isset($settings['og_image']) && $settings['og_image'])
                                                        <div class="thumbnail-item">
                                                            <img src="{{asset($settings['og_image'])}}" alt="OG Image">
                                                            <button type="button" class="delete-btn" onclick="deleteOgImage()">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="mt-4">
                                                    <button type="button" class="btn btn-sm btn-primary" onclick="chooseOgImage()">
                                                        <i class="fa fa-image"></i> Choose Image
                                                    </button>
                                                </div>
                                                <input type="hidden" id="og_image" name="og_image" value="{{@$settings['og_image']}}">
                                                <div class="form-text mt-2">Recommended size: 1200x630px</div>
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Settings Section -->
                            <h4 class="text-gray-800 mb-6 mt-10" style="border-top: 1px solid #e4e6ef; padding-top: 20px;">Additional Settings</h4>
                            
                            <div class="row mb-8">
                                <div class="col-md-12">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold mb-2">MAP URL</label>
                                        <input type="url" class="form-control form-control-solid" value="{{@$settings['map_url']}}" placeholder="Enter Google Maps Embed URL" name="map_url" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold mb-2">Footer Description</label>
                                        <textarea type="text" id="ckeditor" class="form-control form-control-solid" name="footer_description" rows="4">{{@$settings['footer_description']}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end mt-10" style="border-top: 1px solid #e4e6ef; padding-top: 20px;">
                                <button type="reset" class="btn btn-light me-3">
                                    <i class="fa fa-times me-2"></i>Discard
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">
                                        <i class="fa fa-save me-2"></i>Save Changes
                                    </span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>

    <script>
        let isSelectingThumbnail = false;
        let isSelectingFavicon = false;
        let isSelectingOgImage = false;
        let currentThumbnail = '{{@$settings['site_logo']}}';
        let currentFavicon = '{{@$settings['favicon']}}';
        let currentOgImage = '{{@$settings['og_image']}}';

        // Initialize thumbnail preview
        function initializeThumbnail() {
            if (currentThumbnail) {
                renderThumbnail();
            }
            if (currentFavicon) {
                renderFavicon();
            }
            if (currentOgImage) {
                renderOgImage();
            }
        }

        // Render thumbnail preview
        function renderThumbnail() {
            const holder = document.getElementById('holder');
            if (currentThumbnail) {
                holder.innerHTML = `
                    <div class="thumbnail-item">
                        <img src="${currentThumbnail}" alt="Logo">
                        <button type="button" class="delete-btn" onclick="deleteThumbnail()">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                `;
            } else {
                holder.innerHTML = '';
            }
        }

        // Render favicon preview
        function renderFavicon() {
            const holder = document.getElementById('favicon-holder');
            if (currentFavicon) {
                holder.innerHTML = `
                    <div class="thumbnail-item">
                        <img src="${currentFavicon}" alt="Favicon">
                        <button type="button" class="delete-btn" onclick="deleteFavicon()">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                `;
            } else {
                holder.innerHTML = '';
            }
        }

        // Render OG image preview
        function renderOgImage() {
            const holder = document.getElementById('og-image-holder');
            if (currentOgImage) {
                holder.innerHTML = `
                    <div class="thumbnail-item">
                        <img src="${currentOgImage}" alt="OG Image">
                        <button type="button" class="delete-btn" onclick="deleteOgImage()">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                `;
            } else {
                holder.innerHTML = '';
            }
        }

        // Choose thumbnail
        function chooseThumbnail() {
            isSelectingThumbnail = true;
            window.open('/laravel-filemanager?type=Images', 'FileManager', 'width=900,height=600');
        }

        // Choose favicon
        function chooseFavicon() {
            isSelectingFavicon = true;
            window.open('/laravel-filemanager?type=Images', 'FileManager', 'width=900,height=600');
        }

        // Choose OG image
        function chooseOgImage() {
            isSelectingOgImage = true;
            window.open('/laravel-filemanager?type=Images', 'FileManager', 'width=900,height=600');
        }

        // Delete thumbnail
        function deleteThumbnail() {
            currentThumbnail = '';
            document.getElementById('thumbnail').value = '';
            renderThumbnail();
        }

        // Delete favicon
        function deleteFavicon() {
            currentFavicon = '';
            document.getElementById('favicon').value = '';
            renderFavicon();
        }

        // Delete OG image
        function deleteOgImage() {
            currentOgImage = '';
            document.getElementById('og_image').value = '';
            renderOgImage();
        }

        // Override window.SetUrl for file manager
        window.SetUrl = function (items) {
            if (isSelectingThumbnail) {
                // Handle thumbnail image
                if (items.length > 0 || (typeof items === 'object' && items.url)) {
                    const url = items.length > 0 ? items[0].url : items.url;
                    currentThumbnail = url;
                    document.getElementById('thumbnail').value = currentThumbnail;
                    renderThumbnail();
                }
                isSelectingThumbnail = false;
            } else if (isSelectingFavicon) {
                // Handle favicon
                if (items.length > 0 || (typeof items === 'object' && items.url)) {
                    const url = items.length > 0 ? items[0].url : items.url;
                    currentFavicon = url;
                    document.getElementById('favicon').value = currentFavicon;
                    renderFavicon();
                }
                isSelectingFavicon = false;
            } else if (isSelectingOgImage) {
                // Handle OG image
                if (items.length > 0 || (typeof items === 'object' && items.url)) {
                    const url = items.length > 0 ? items[0].url : items.url;
                    currentOgImage = url;
                    document.getElementById('og_image').value = currentOgImage;
                    renderOgImage();
                }
                isSelectingOgImage = false;
            }
        };

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeThumbnail();
        });
    </script>
@endsection
