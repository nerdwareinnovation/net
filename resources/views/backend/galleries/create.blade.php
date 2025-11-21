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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">@if(isset($gallery)) Edit @else Add @endif Gallery</h1>
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
                        <li class="breadcrumb-item text-muted">Gallery</li>
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
                        @if(isset($gallery))
                            <form class="form" action="{{route('admin.galleries.update',$gallery->id)}}" method="POST" enctype="multipart/form-data">@csrf
                                @method('PUT')
                        @else
                            <form class="form" action="{{route('admin.galleries.store')}}" method="POST" enctype="multipart/form-data">@csrf
                        @endif
                            <!--begin::Modal body-->
                            <div class="py-10">
                                <!--begin::Scroll-->
                                <div class="row me-n7 pe-7">
                                    <!--begin::Basic Information Section-->
                                    <div class="col-md-12 mb-5">
                                        <h4 class="text-gray-800 fw-bold mb-4">Basic Information</h4>
                                    </div>
                                    
                                    <!--begin::Title-->
                                    <div class="fv-row mb-7 col-md-12">
                                        <label class="required fs-6 fw-semibold mb-2">Gallery Title</label>
                                        <input type="text" class="form-control form-control-solid" value="{{@$gallery->title}}" placeholder="Enter Gallery Title" name="title" required />
                                    </div>
                                    
                                    <!--begin::Category-->
                                    <div class="fv-row mb-7 col-md-6">
                                        <label class="required fs-6 fw-semibold mb-2">Category</label>
                                        <select class="form-select form-control-solid" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($galleryCategories as $cat)
                                                <option value="{{$cat->id}}" {{@$gallery->category_id == $cat->id ? 'selected' : ''}}>{{$cat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <!--begin::Position and Status-->
                                    <div class="fv-row mb-7 col-md-3">
                                        <label class="fs-6 fw-semibold mb-2">Position</label>
                                        <input type="number" class="form-control form-control-solid" value="{{@$gallery->position ?? 0}}" placeholder="0" name="position" />
                                    </div>
                                    
                                    <div class="fv-row mb-7 col-md-3">
                                        <label class="fs-6 fw-semibold mb-2">Status</label>
                                        <select class="form-select form-control-solid" name="status">
                                            <option value="active" {{@$gallery->status == 'active' ? 'selected' : ''}}>Active</option>
                                            <option value="inactive" {{@$gallery->status == 'inactive' ? 'selected' : ''}}>Inactive</option>
                                        </select>
                                    </div>
                                    
                                    <!--begin::Description-->
                                    <div class="fv-row mb-7 col-md-12">
                                        <label class="fs-6 fw-semibold mb-2">Description</label>
                                        <textarea id="ckeditor" class="form-control form-control-solid" name="description" rows="10">{{@$gallery->description}}</textarea>
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
                                                <p class="text-muted mb-4">Main display image for the gallery</p>
                                                <button type="button" id="chooseThumbnail" class="btn btn-primary btn-sm mb-3">
                                                    <i class="fa fa-image"></i> Choose Thumbnail
                                                </button>
                                                <input id="thumbnail" value="{{@$gallery->thumbnail}}" type="hidden" name="thumbnail">
                                                
                                                <div id="holder" class="thumbnail-preview">
                                                    <!-- Thumbnail will be rendered here by JavaScript -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!--begin::Child Images (Multiple)-->
                                    <div class="fv-row mb-7 col-md-12">
                                        <div class="card card-flush py-4">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h5 class="fw-bold m-0">Gallery Images</h5>
                                                </div>
                                            </div>
                                            <div class="card-body pt-0">
                                                <p class="text-muted mb-4">Multiple images for the gallery. Drag to reorder, click X to remove.</p>
                                                <div class="mb-4">
                                                    <button type="button" id="addMoreImages" class="btn btn-primary btn-sm">
                                                        <i class="fa fa-image"></i> Add Images
                                                    </button>
                                                    <button type="button" id="clearAllImages" class="btn btn-danger btn-sm ms-2">
                                                        <i class="fa fa-trash"></i> Clear All
                                                    </button>
                                                </div>
                                                @php
                                                    $childImagesValue = old('child_images');
                                                    if (!$childImagesValue) {
                                                        $childImagesValue = isset($gallery) && $gallery->child_images
                                                            ? json_encode($gallery->child_images)
                                                            : json_encode([]);
                                                    }
                                                @endphp
                                                <input id="child_images" type="hidden" name="child_images" value="{{ $childImagesValue }}">
                                                
                                                <div id="holder1" class="image-gallery">
                                                    <!-- Images will be rendered here by JavaScript -->
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
            // Thumbnail Image Management
            let thumbnailUrl = '';
            let isSelectingThumbnail = false;
            
            function initializeThumbnail() {
                thumbnailUrl = $('#thumbnail').val() || '';
                renderThumbnail();
            }
            
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
            
            $('#chooseThumbnail').on('click', function() {
                isSelectingThumbnail = true;
                window.open('/laravel-filemanager?type=Images', 'FileManager', 'width=900,height=600');
            });
            
            $(document).on('click', '.btn-delete-thumb', function() {
                thumbnailUrl = '';
                $('#thumbnail').val('');
                renderThumbnail();
            });
            
            initializeThumbnail();
            
            // Child Images Management (Multiple) with Drag and Drop + metadata
            let currentImages = [];
            let draggedElement = null;
            
            function getEmptyMeta(url = '') {
                return {
                    url: url ? url.trim() : '',
                    title: '',
                    short_description: '',
                    date: '',
                };
            }
            
            function initializeImages() {
                currentImages = [];
                const rawValue = $('#child_images').val();
                
                if (rawValue) {
                    try {
                        const parsed = JSON.parse(rawValue);
                        if (Array.isArray(parsed)) {
                            currentImages = parsed
                                .map(item => {
                                    if (typeof item === 'string') {
                                        return getEmptyMeta(item);
                                    }
                                    
                                    if (item && typeof item === 'object') {
                                        return {
                                            url: item.url ? item.url.trim() : '',
                                            title: item.title || '',
                                            short_description: item.short_description || '',
                                            date: item.date || '',
                                        };
                                    }
                                    
                                    return null;
                                })
                                .filter(item => item && item.url);
                        }
                    } catch (error) {
                        console.error('Failed to parse child images payload', error);
                    }
                }
                
                renderImages();
            }
            
            function renderImages() {
                const holder = $('#holder1');
                holder.empty();
                
                if (currentImages.length === 0) {
                    holder.html('<p class="text-muted">No images selected. Click "Add Images" to select images.</p>');
                    $('#child_images').val('[]');
                    return;
                }
                
                currentImages.forEach((image, index) => {
                    const imageItem = $(`
                        <div class="image-item" draggable="true" data-index="${index}">
                            <div class="image-wrapper">
                                <img src="${image.url}" alt="Image ${index + 1}">
                                <button type="button" class="btn-delete" data-index="${index}" title="Remove image">
                                    <i class="fa fa-times"></i>
                                </button>
                                <div class="drag-handle" title="Drag to reorder">
                                    <i class="fa fa-grip-vertical"></i>
                                </div>
                                <div class="image-order">${index + 1}</div>
                            </div>
                            <div class="image-meta mt-3">
                                <input type="text" class="form-control form-control-sm mb-2 image-field" data-index="${index}" data-field="title" placeholder="Title (optional)">
                                <textarea class="form-control form-control-sm mb-2 image-field" data-index="${index}" data-field="short_description" rows="2" placeholder="Short description (optional)"></textarea>
                                <input type="date" class="form-control form-control-sm image-field" data-index="${index}" data-field="date" placeholder="Date (optional)">
                            </div>
                        </div>
                    `);
                    
                    imageItem.find('.image-field[data-field="title"]').val(image.title || '');
                    imageItem.find('.image-field[data-field="short_description"]').val(image.short_description || '');
                    imageItem.find('.image-field[data-field="date"]').val(image.date || '');
                    
                    holder.append(imageItem);
                });
                
                updateHiddenInput();
                attachDragEvents();
            }
            
            function updateHiddenInput() {
                $('#child_images').val(JSON.stringify(currentImages));
            }
            
            $('#addMoreImages').on('click', function() {
                isSelectingThumbnail = false;
                window.open('/laravel-filemanager?type=Images&multiple=1', 'FileManager', 'width=900,height=600');
            });
            
            $('#clearAllImages').on('click', function() {
                if (currentImages.length > 0 && confirm('Are you sure you want to remove all images?')) {
                    currentImages = [];
                    renderImages();
                }
            });
            
            $(document).on('click', '.btn-delete', function() {
                const index = $(this).data('index');
                currentImages.splice(index, 1);
                renderImages();
            });
            
            $(document).on('input change', '.image-field', function() {
                const index = $(this).data('index');
                const field = $(this).data('field');
                
                if (typeof index === 'undefined' || !currentImages[index]) {
                    return;
                }
                
                currentImages[index][field] = $(this).val();
                updateHiddenInput();
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
            
            // Global callback for file manager
            window.SetUrl = function(items) {
                if (isSelectingThumbnail) {
                    if (Array.isArray(items) && items.length > 0) {
                        thumbnailUrl = items[0].url || '';
                    } else if (items && items.url) {
                        thumbnailUrl = items.url;
                    }
                    $('#thumbnail').val(thumbnailUrl);
                    renderThumbnail();
                } else {
                    // Handle multiple images with metadata placeholder
                    let newUrls = [];
                    if (Array.isArray(items)) {
                        newUrls = items.map(item => item.url || item).filter(url => url);
                    } else if (items) {
                        newUrls = [items.url || items];
                    }
                    
                    newUrls.forEach(url => {
                        const normalizedUrl = typeof url === 'string' ? url.trim() : url;
                        if (!normalizedUrl) {
                            return;
                        }
                        
                        const exists = currentImages.some(image => image.url === normalizedUrl);
                        if (!exists) {
                            currentImages.push(getEmptyMeta(normalizedUrl));
                        }
                    });
                    
                    renderImages();
                }
            };
            
            initializeImages();
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
        
        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            min-height: 150px;
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
        
        .thumbnail-wrapper img, .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        .btn-delete-thumb, .btn-delete {
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
        
        .thumbnail-wrapper:hover .btn-delete-thumb,
        .image-wrapper:hover .btn-delete {
            opacity: 1;
        }
        
        .btn-delete:hover {
            background: #dc3545;
            transform: scale(1.1);
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
        
        .image-meta .form-control {
            font-size: 12px;
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

