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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">@if(isset($banner)) Edit @else Add @endif Banner</h1>
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
                        <li class="breadcrumb-item text-muted">Banners</li>
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
                    <div class="card-body pt-0">
                        @if(isset($banner))
                            <form class="form" action="{{route('admin.banners.update',$banner->id)}}" method="POST" enctype="multipart/form-data">@csrf
                                @method('PUT')
                        @else
                            <form class="form" action="{{route('admin.banners.store')}}" method="POST" enctype="multipart/form-data">@csrf
                        @endif
                            <!--begin::Modal body-->
                            <div class="py-10">
                                <!--begin::Scroll-->
                                <div class="row me-n7 pe-7">
                                    <!--begin::Basic Information Section-->
                                    <div class="col-md-12 mb-5">
                                        <h4 class="text-gray-800 fw-bold mb-4">Banner Information</h4>
                                    </div>
                                    
                                    <!--begin::Title-->
                                    <div class="fv-row mb-7 col-md-12">
                                        <label class="required fs-6 fw-semibold mb-2">Title</label>
                                        <input type="text" class="form-control form-control-solid" value="{{@$banner->title}}" placeholder="Enter Banner Title" name="title" required />
                                    </div>
                                    
                                    <!--begin::Short Description-->
                                    <div class="fv-row mb-7 col-md-12">
                                        <label class="fs-6 fw-semibold mb-2">Short Description</label>
                                        <textarea class="form-control form-control-solid" name="short_description" rows="3" placeholder="Enter short description">{{@$banner->short_description}}</textarea>
                                    </div>
                                    
                                    <!--begin::Image-->
                                    <div class="fv-row mb-7 col-md-12">
                                        <div class="card card-flush py-4">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h5 class="fw-bold m-0">Banner Image</h5>
                                                </div>
                                            </div>
                                            <div class="card-body pt-0">
                                                <p class="text-muted mb-4">Main image for the banner</p>
                                                <button type="button" id="chooseBannerImage" class="btn btn-primary btn-sm mb-3">
                                                    <i class="fa fa-image"></i> Choose Image
                                                </button>
                                                <input id="banner_image" value="{{@$banner->image}}" type="hidden" name="image">
                                                
                                                <div id="holder" class="thumbnail-preview">
                                                    <!-- Image will be rendered here by JavaScript -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!--begin::Button Text and URL-->
                                    <div class="fv-row mb-7 col-md-6">
                                        <label class="fs-6 fw-semibold mb-2">Button Text</label>
                                        <input type="text" class="form-control form-control-solid" value="{{@$banner->button_text}}" placeholder="e.g., Learn More" name="button_text" />
                                    </div>
                                    
                                    <div class="fv-row mb-7 col-md-6">
                                        <label class="fs-6 fw-semibold mb-2">Button URL</label>
                                        <input type="url" class="form-control form-control-solid" value="{{@$banner->button_url}}" placeholder="https://..." name="button_url" />
                                    </div>
                                    
                                    <!--begin::Position and Status-->
                                    <div class="fv-row mb-7 col-md-3">
                                        <label class="fs-6 fw-semibold mb-2">Position</label>
                                        <input type="number" class="form-control form-control-solid" value="{{@$banner->position ?? 0}}" placeholder="0" name="position" />
                                    </div>
                                    
                                    <div class="fv-row mb-7 col-md-3">
                                        <label class="fs-6 fw-semibold mb-2">Status</label>
                                        <select class="form-select form-control-solid" name="status">
                                            <option value="active" {{@$banner->status == 'active' ? 'selected' : ''}}>Active</option>
                                            <option value="inactive" {{@$banner->status == 'inactive' ? 'selected' : ''}}>Inactive</option>
                                        </select>
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
            width: 150px;
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

