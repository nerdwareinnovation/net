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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">@if(isset($site_page)) Edit @else Add @endif Page Settings</h1>
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
                        <li class="breadcrumb-item text-muted">Page Settings</li>
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
                    <!--begin::Card header-->
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        @if(isset($site_page))
                            <form class="form" action="{{route('admin.site-page-settings.update',$site_page->id)}}" method="POST" enctype="multipart/form-data">@csrf
                                @method('PUT')
                        @else
                            <form class="form" action="{{route('admin.site-page-settings.store')}}" method="POST" enctype="multipart/form-data">@csrf
                        @endif
                            <!--begin::Modal body-->
                            <div class="py-10">
                                <!--begin::Scroll-->
                                <div class="row me-n7 pe-7">
                                    <!--begin::Basic Information Section-->
                                    <div class="col-md-12 mb-5">
                                        <h4 class="text-gray-800 fw-bold mb-4">Page Information</h4>
                                    </div>

                                    <!--begin::Title-->
                                    <div class="fv-row mb-7 col-md-12">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Page Title</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" value="{{@$site_page->name}}" placeholder="Enter Page Title" name="name" />
                                        <!--end::Input-->
                                    </div>

                                    <!--begin::Description-->
                                    <div class="fv-row mb-7 col-md-12">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">Page Description</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <textarea type="text" id="ckeditor" class="form-control form-control-solid" name="description" >{{@$site_page->description}}</textarea>
                                        <!--end::Input-->
                                    </div>
                                    
                                    <!--begin::Image Management Section-->
                                    <div class="col-md-12 mb-5 mt-7">
                                        <div class="separator separator-dashed mb-6"></div>
                                        <h4 class="text-gray-800 fw-bold mb-0">Page Banner</h4>
                                    </div>
                                    
                                    <!--begin::Page Image-->
                                    <div class="fv-row mb-7 col-md-12">
                                        <div class="card card-flush py-4">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h5 class="fw-bold m-0">Banner Image</h5>
                                                </div>
                                            </div>
                                            <div class="card-body pt-0">
                                                <p class="text-muted mb-4">Banner image for the page header</p>
                                                <button type="button" id="chooseThumbnail" class="btn btn-primary btn-sm mb-3">
                                                    <i class="fa fa-image"></i> Choose Banner
                                                </button>
                                                <input id="thumbnail" value="{{@$site_page->image}}" type="hidden" name="image">
                                                
                                                <div id="holder" class="thumbnail-preview">
                                                    <!-- Banner will be rendered here by JavaScript -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="modal-footer flex-center">
                                    <!--begin::Button-->
                                    <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3">Discard</button>
                                    <!--end::Button-->
                                    <!--begin::Button-->
                                    <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
                                        <span class="indicator-label">Submit</span>
                                        <span class="indicator-progress">Please wait...
															<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <!--end::Button-->
                                </div>
                                <!--end::Scroll-->
                            </div>
                            <!--end::Modal body-->
                        </form>

                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Page Banner Image Management
            let thumbnailUrl = '';
            
            // Initialize thumbnail from hidden input
            function initializeThumbnail() {
                thumbnailUrl = $('#thumbnail').val() || '';
                renderThumbnail();
            }
            
            // Render thumbnail with delete button
            function renderThumbnail() {
                const holder = $('#holder');
                holder.empty();
                
                if (!thumbnailUrl) {
                    holder.html('<p class="text-muted">No banner selected. Click "Choose Banner" to select a banner image.</p>');
                    return;
                }
                
                const thumbnailItem = $(`
                    <div class="thumbnail-item">
                        <div class="thumbnail-wrapper">
                            <img src="${thumbnailUrl}" alt="Page Banner">
                            <button type="button" class="btn-delete-thumb" title="Remove banner">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                `);
                holder.append(thumbnailItem);
            }
            
            // Choose thumbnail via file manager
            $('#chooseThumbnail').on('click', function() {
                window.open('/laravel-filemanager?type=Images', 'FileManager', 'width=900,height=600');
            });
            
            // Global callback for file manager
            window.SetUrl = function(items) {
                // items is an array of objects with .url property
                if (Array.isArray(items) && items.length > 0) {
                    thumbnailUrl = items[0].url || '';
                } else if (items && items.url) {
                    thumbnailUrl = items.url;
                }
                $('#thumbnail').val(thumbnailUrl);
                renderThumbnail();
            };
            
            // Delete thumbnail
            $(document).on('click', '.btn-delete-thumb', function() {
                thumbnailUrl = '';
                $('#thumbnail').val('');
                renderThumbnail();
            });
            
            // Initialize thumbnail on page load
            initializeThumbnail();
        });
    </script>

    <style>
        /* Card Header Styles */
        .card-flush .card-header {
            min-height: 30px;
            padding: 10px 20px;
        }
        
        .card-flush .card-title h5 {
            font-size: 14px;
            margin: 0;
        }
        
        /* Thumbnail Preview Styles */
        .thumbnail-preview {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }
        
        .thumbnail-item {
            position: relative;
        }
        
        .thumbnail-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
            border: 2px solid #ddd;
            border-radius: 6px;
            overflow: hidden;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .thumbnail-wrapper:hover {
            border-color: #007bff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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
            width: 24px;
            height: 24px;
            border: none;
            border-radius: 50%;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
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
