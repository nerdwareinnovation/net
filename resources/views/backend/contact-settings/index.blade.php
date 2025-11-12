@extends('backend.partials.master')

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex align-items-center text-gray-900 fw-bold fs-2 my-0">
                        Contact Settings
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('home')}}" class="text-muted text-hover-primary">
                                <i class="ki-outline ki-home fs-6 text-muted me-1"></i>
                                Home
                            </a>
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
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Contact Settings</li>
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
                
                <!--begin::Main Settings Card-->
                <div class="card shadow-sm">
                    <div class="card-header border-0 pt-6">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold fs-3 mb-1">Contact Page Settings</span>
                        </h3>
                    </div>
                    <div class="card-body pt-0">
                        <form class="form" action="{{route('admin.contact-settings.update')}}" method="POST">@csrf
                            @method('PUT')
                            <div class="row">
                                <!--begin::Banner Image-->
                                <div class="fv-row mb-7 col-md-12">
                                    <div class="card card-flush py-4">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h5 class="fw-bold m-0">Banner Image</h5>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0">
                                            <p class="text-muted mb-4">Background image for the contact page banner</p>
                                            <button type="button" id="chooseBannerImage" class="btn btn-primary btn-sm mb-3">
                                                <i class="fa fa-image"></i> Choose Image
                                            </button>
                                            <input id="banner_image" value="{{@$contactSettings->banner_image}}" type="hidden" name="banner_image">
                                            
                                            <div id="holder" class="thumbnail-preview">
                                                <!-- Image will be rendered here by JavaScript -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!--begin::Title-->
                                <div class="fv-row mb-7 col-md-12">
                                    <label class="required fs-6 fw-semibold mb-2">Title</label>
                                    <input type="text" class="form-control form-control-solid" value="{{@$contactSettings->title}}" placeholder="Reach Out to Us" name="title" required />
                                </div>
                                
                                <!--begin::Short Description-->
                                <div class="fv-row mb-7 col-md-12">
                                    <label class="fs-6 fw-semibold mb-2">Short Description</label>
                                    <textarea class="form-control form-control-solid" name="short_description" rows="3" placeholder="We'd love to hear from you. Get in touch and let's start a conversation.">{{@$contactSettings->short_description}}</textarea>
                                </div>
                                
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Update Settings</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Banner Image Management
            let bannerImageUrl = '';
            let isSelectingBannerImage = false;
            
            function initializeBannerImage() {
                bannerImageUrl = $('#banner_image').val() || '';
                renderBannerImage();
            }
            
            function renderBannerImage() {
                const holder = $('#holder');
                holder.empty();
                
                if (!bannerImageUrl) {
                    holder.html('<p class="text-muted">No image selected. Click "Choose Image" to select an image.</p>');
                    return;
                }
                
                const imageItem = $(`
                    <div class="thumbnail-item">
                        <div class="thumbnail-wrapper">
                            <img src="${bannerImageUrl}" alt="Banner Image">
                            <button type="button" class="btn-delete-thumb" title="Remove image">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                `);
                holder.append(imageItem);
            }
            
            $('#chooseBannerImage').on('click', function() {
                isSelectingBannerImage = true;
                window.open('/laravel-filemanager?type=Images', 'FileManager', 'width=900,height=600');
            });
            
            $(document).on('click', '.btn-delete-thumb', function() {
                bannerImageUrl = '';
                $('#banner_image').val('');
                renderBannerImage();
            });
            
            // Global callback for file manager
            window.SetUrl = function(items) {
                if (isSelectingBannerImage) {
                    if (Array.isArray(items) && items.length > 0) {
                        bannerImageUrl = items[0].url || '';
                    } else if (items && items.url) {
                        bannerImageUrl = items.url;
                    } else {
                        bannerImageUrl = items;
                    }
                    $('#banner_image').val(bannerImageUrl);
                    renderBannerImage();
                }
            };
            
            initializeBannerImage();
        });
    </script>

    <style>
        .thumbnail-preview {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            min-height: 120px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-start;
        }
        
        .thumbnail-wrapper {
            position: relative;
            width: 200px;
            height: 150px;
            border: 2px solid #ddd;
            border-radius: 6px;
            overflow: hidden;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .thumbnail-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        .btn-delete-thumb {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 28px;
            height: 28px;
            border: none;
            border-radius: 50%;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            z-index: 10;
            transition: all 0.2s ease;
            opacity: 0;
        }
        
        .thumbnail-wrapper:hover .btn-delete-thumb {
            opacity: 1;
        }
        
        .btn-delete-thumb:hover {
            background: #dc3545;
            transform: scale(1.1);
        }
    </style>
@endpush

