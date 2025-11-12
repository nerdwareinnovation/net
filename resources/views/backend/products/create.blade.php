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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Products</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Product</li>
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
                        @if(isset($product))
                            <form class="form" action="{{route('admin.products.update',$product->id)}}" method="POST" enctype="multipart/form-data">@csrf
                                @method('PUT')
                        @else
                            <form class="form" action="{{route('admin.products.store')}}" method="POST" enctype="multipart/form-data">@csrf
                        @endif
                            <!--begin::Modal body-->
                            <div class="py-10">
                                <!--begin::Scroll-->
                              <div class="row me-n7 pe-7">
                                    <!--begin::Basic Information Section-->
                                    <div class="col-md-12 mb-5">
                                        <h4 class="text-gray-800 fw-bold mb-4">Product Information</h4>
                                    </div>

                                    <!--begin::Row 1-->
                                    <div class="fv-row mb-7 col-md-6">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Product Title</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text"  value="{{@$product->name}}" class="form-control form-control-solid" placeholder="Enter Product Title" name="name" />
                                        <!--end::Input-->
                                    </div>

                                    <div class="fv-row mb-7 col-md-6">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Category</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select type="text" class="form-select form-control-solid"  name="category_id">
                                            <option>Select Category</option>
                                            @foreach($categories as $sCT)
                                                <option value="{{$sCT->id}}" {{@$product->category_id == $sCT->id ?
                                                    'selected' : ''}}>{{$sCT->name}}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>

                                    <!--begin::Row 2-->
                                    <div class="fv-row mb-7 col-md-6">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Price</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" value="{{@$product->price}}" class="form-control form-control-solid" placeholder="Enter Price" name="price" />
                                        <!--end::Input-->
                                    </div>

                                    <!--begin::Description-->
                                    <div class="fv-row mb-7 col-md-12">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">Description</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <textarea type="text" id="ckeditor" class="form-control form-control-solid" name="description" >{{@$product->description}}</textarea>
                                        <!--end::Input-->
                                    </div>
                                    
                                    <!--begin::Image Management Section-->
                                    <div class="col-md-12 mb-5 mt-7">
                                        <div class="separator separator-dashed mb-6"></div>
                                        <h4 class="text-gray-800 fw-bold mb-0">Image Management</h4>
                                    </div>
                                    
                                    <!--begin::Thumbnail Image-->
                                    <div class="fv-row mb-7 col-md-12">
                                        <div class="card card-flush py-4">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h5 class="fw-bold m-0">Thumbnail Image</h5>
                                                </div>
                                            </div>
                                            <div class="card-body pt-0">
                                                <p class="text-muted mb-4">Main display image for the product listing</p>
                                                <button type="button" id="chooseThumbnail" class="btn btn-primary btn-sm mb-3">
                                                    <i class="fa fa-image"></i> Choose Thumbnail
                                                </button>
                                                <input id="thumbnail" value="{{@$product->image}}" type="hidden" name="image">
                                                
                                                <div id="holder" class="thumbnail-preview">
                                                    <!-- Thumbnail will be rendered here by JavaScript -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!--begin::Multiple Images-->
                                    <div class="fv-row mb-7 col-md-12">
                                        <div class="card card-flush py-4">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h5 class="fw-bold m-0">Gallery Images</h5>
                                                </div>
                                            </div>
                                            <div class="card-body pt-0">
                                                <p class="text-muted mb-4">Multiple images for the product gallery. Drag to reorder, click X to remove.</p>
                                                <div class="mb-4">
                                                    <button type="button" id="addMoreImages" class="btn btn-primary btn-sm">
                                                        <i class="fa fa-image"></i> Add Images
                                                    </button>
                                                    <button type="button" id="manualAddImage" class="btn btn-info btn-sm ms-2">
                                                        <i class="fa fa-link"></i> Add URL
                                                    </button>
                                                    <button type="button" id="clearAllImages" class="btn btn-danger btn-sm ms-2">
                                                        <i class="fa fa-trash"></i> Clear All
                                                    </button>
                                                </div>
                                                <input id="thumbnail1" value="{{isset($product) && $product->images ? implode(',', $product->images) : ''}}" type="hidden" name="images">
                                                
                                                <div id="holder1" class="image-gallery">
                                                    <!-- Images will be rendered here by JavaScript -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--end::Input group-->
                                    @if(isset($product))
                                        @php
                                            $custom_field_response = $product;
                                        @endphp
                                    @endif
                                    @include('backend.custom-fields')

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
    
    <!-- Manual Image URL Modal -->
    <div class="modal fade" id="manualImageModal" tabindex="-1" aria-labelledby="manualImageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manualImageModalLabel">Add Image URL Manually</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="manualImageForm">
                        <div class="mb-3">
                            <label for="imageUrl" class="form-label">Image URL</label>
                            <input type="url" id="imageUrl" class="form-control" placeholder="https://example.com/image.jpg" required>
                            <small class="text-muted">Enter the full URL of the image</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Preview</label>
                            <div id="manualImagePreview" style="min-height: 100px; border: 1px dashed #ddd; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                <span class="text-muted">Preview will appear here</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveManualImage">Add Image</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Thumbnail Image Management
            let thumbnailUrl = '';
            let isSelectingThumbnail = false;
            
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
                    holder.html('<p class="text-muted">No thumbnail selected. Click "Choose Thumbnail" to select an image.</p>');
                    return;
                }
                
                const thumbnailItem = $(`
                    <div class="thumbnail-item">
                        <div class="thumbnail-wrapper">
                            <img src="${thumbnailUrl}" alt="Thumbnail">
                            <button type="button" class="btn-delete-thumb" title="Remove thumbnail">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                `);
                holder.append(thumbnailItem);
            }
            
            // Choose thumbnail via file manager
            $('#chooseThumbnail').on('click', function() {
                isSelectingThumbnail = true;
                window.open('/laravel-filemanager?type=Images', 'FileManager', 'width=900,height=600');
            });
            
            // Delete thumbnail
            $(document).on('click', '.btn-delete-thumb', function() {
                thumbnailUrl = '';
                $('#thumbnail').val('');
                renderThumbnail();
            });
            
            // Initialize thumbnail on page load
            initializeThumbnail();
            
            // Image Management System (Multiple Images)
            let currentImages = [];
            let draggedElement = null;
            
            // Initialize images from hidden input
            function initializeImages() {
                const imageUrls = $('#thumbnail1').val();
                if (imageUrls) {
                    currentImages = imageUrls.split(',').filter(url => url.trim() !== '');
                }
                renderImages();
            }
            
            // Render images with delete buttons and drag handles
            function renderImages() {
                const holder = $('#holder1');
                holder.empty();
                
                if (currentImages.length === 0) {
                    holder.html('<p class="text-muted">No images selected. Click "Add Images" to select images.</p>');
                    return;
                }
                
                currentImages.forEach((url, index) => {
                    const imageItem = $(`
                        <div class="image-item" draggable="true" data-index="${index}">
                            <div class="image-wrapper">
                                <img src="${url.trim()}" alt="Image ${index + 1}">
                                <button type="button" class="btn-delete" data-index="${index}" title="Remove image">
                                    <i class="fa fa-times"></i>
                                </button>
                                <div class="drag-handle" title="Drag to reorder">
                                    <i class="fa fa-grip-vertical"></i>
                                </div>
                                <div class="image-order">${index + 1}</div>
                            </div>
                        </div>
                    `);
                    holder.append(imageItem);
                });
                
                updateHiddenInput();
                attachDragEvents();
            }
            
            // Update hidden input with current image URLs
            function updateHiddenInput() {
                $('#thumbnail1').val(currentImages.join(','));
            }
            
            // Delete image
            $(document).on('click', '.btn-delete', function() {
                const index = $(this).data('index');
                currentImages.splice(index, 1);
                renderImages();
            });
            
            // Clear all images
            $('#clearAllImages').on('click', function() {
                if (currentImages.length > 0) {
                    if (confirm('Are you sure you want to remove all images?')) {
                        currentImages = [];
                        renderImages();
                    }
                }
            });
            
            // Add more images via file manager
            $('#addMoreImages').on('click', function() {
                isSelectingThumbnail = false;
                window.open('/laravel-filemanager?type=Images&multiple=1', 'FileManager', 'width=900,height=600');
            });
            
            // Global callback for file manager
            window.SetUrl = function(items) {
                if (isSelectingThumbnail) {
                    // Handle thumbnail (single image)
                    // items is an array of objects with .url property
                    if (Array.isArray(items) && items.length > 0) {
                        thumbnailUrl = items[0].url || '';
                    } else if (items && items.url) {
                        thumbnailUrl = items.url;
                    }
                    $('#thumbnail').val(thumbnailUrl);
                    renderThumbnail();
                } else {
                    // Handle multiple images
                    // Extract URLs from items array
                    let newUrls = [];
                    if (Array.isArray(items)) {
                        newUrls = items.map(item => item.url || item).filter(url => url);
                    } else if (items) {
                        newUrls = [items.url || items];
                    }
                    
                    // Add new images to existing ones
                    newUrls.forEach(url => {
                        if (url && !currentImages.includes(url)) {
                            currentImages.push(url);
                        }
                    });
                    
                    renderImages();
                }
            };
            
            // Manual Image URL Addition
            $('#manualAddImage').on('click', function() {
                $('#imageUrl').val('');
                $('#manualImagePreview').html('<span class="text-muted">Preview will appear here</span>');
                $('#manualImageModal').modal('show');
            });
            
            // Preview manual image URL
            $('#imageUrl').on('input', function() {
                const url = $(this).val().trim();
                if (url) {
                    $('#manualImagePreview').html(`
                        <img src="${url}" style="max-width: 100%; max-height: 200px; object-fit: contain;" 
                             onerror="this.parentElement.innerHTML='<span class=\\'text-danger\\'>Invalid image URL</span>'">
                    `);
                } else {
                    $('#manualImagePreview').html('<span class="text-muted">Preview will appear here</span>');
                }
            });
            
            // Save manual image
            $('#saveManualImage').on('click', function() {
                const url = $('#imageUrl').val().trim();
                if (url) {
                    if (!currentImages.includes(url)) {
                        currentImages.push(url);
                        renderImages();
                        $('#manualImageModal').modal('hide');
                    } else {
                        alert('This image URL is already added.');
                    }
                } else {
                    alert('Please enter a valid image URL.');
                }
            });
            
            // Drag and Drop functionality
            function attachDragEvents() {
                const items = document.querySelectorAll('.image-item');
                
                items.forEach(item => {
                    item.addEventListener('dragstart', handleDragStart);
                    item.addEventListener('dragover', handleDragOver);
                    item.addEventListener('drop', handleDrop);
                    item.addEventListener('dragend', handleDragEnd);
                    item.addEventListener('dragenter', handleDragEnter);
                    item.addEventListener('dragleave', handleDragLeave);
                });
            }
            
            function handleDragStart(e) {
                draggedElement = this;
                this.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/html', this.innerHTML);
            }
            
            function handleDragOver(e) {
                if (e.preventDefault) {
                    e.preventDefault();
                }
                e.dataTransfer.dropEffect = 'move';
                return false;
            }
            
            function handleDragEnter(e) {
                if (this !== draggedElement) {
                    this.classList.add('drag-over');
                }
            }
            
            function handleDragLeave(e) {
                this.classList.remove('drag-over');
            }
            
            function handleDrop(e) {
                if (e.stopPropagation) {
                    e.stopPropagation();
                }
                
                if (draggedElement !== this) {
                    const draggedIndex = parseInt(draggedElement.dataset.index);
                    const targetIndex = parseInt(this.dataset.index);
                    
                    // Reorder array
                    const draggedItem = currentImages[draggedIndex];
                    currentImages.splice(draggedIndex, 1);
                    currentImages.splice(targetIndex, 0, draggedItem);
                    
                    renderImages();
                }
                
                return false;
            }
            
            function handleDragEnd(e) {
                this.classList.remove('dragging');
                document.querySelectorAll('.image-item').forEach(item => {
                    item.classList.remove('drag-over');
                });
            }
            
            // Initialize on page load
            initializeImages();
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
        
        /* Image Gallery Styles */
        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            min-height: 150px;
        }
        
        .image-item {
            position: relative;
            cursor: move;
            transition: all 0.3s ease;
        }
        
        .image-item.dragging {
            opacity: 0.5;
            transform: scale(0.95);
        }
        
        .image-item.drag-over {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(0, 123, 255, 0.5);
        }
        
        .image-wrapper {
            position: relative;
            width: 150px;
            height: 150px;
            border: 3px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .image-wrapper:hover {
            border-color: #007bff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        .btn-delete {
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
        
        .image-wrapper:hover .btn-delete {
            opacity: 1;
        }
        
        .btn-delete:hover {
            background: #dc3545;
            transform: scale(1.1);
        }
        
        .drag-handle {
            position: absolute;
            top: 5px;
            left: 5px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(108, 117, 125, 0.9);
            color: white;
            cursor: move;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            z-index: 10;
            transition: all 0.2s ease;
            opacity: 0;
        }
        
        .image-wrapper:hover .drag-handle {
            opacity: 1;
        }
        
        .drag-handle:hover {
            background: #6c757d;
            transform: scale(1.1);
        }
        
        .image-order {
            position: absolute;
            bottom: 5px;
            left: 5px;
            background: rgba(0, 123, 255, 0.9);
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            z-index: 5;
        }
    </style>
@endpush
