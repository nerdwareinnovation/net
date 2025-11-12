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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">@if(isset($film)) Edit @else Add @endif Film</h1>
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
                        <li class="breadcrumb-item text-muted">Films</li>
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
                        @if(isset($film))
                            <form class="form" action="{{route('admin.films.update',$film->id)}}" method="POST" enctype="multipart/form-data">@csrf
                                @method('PUT')
                        @else
                            <form class="form" action="{{route('admin.films.store')}}" method="POST" enctype="multipart/form-data">@csrf
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
                                        <label class="required fs-6 fw-semibold mb-2">Film Title</label>
                                        <input type="text" class="form-control form-control-solid" value="{{@$film->title}}" placeholder="Enter Film Title" name="title" required />
                                    </div>
                                    
                                    <!--begin::Category-->
                                    <div class="fv-row mb-7 col-md-6">
                                        <label class="required fs-6 fw-semibold mb-2">Category</label>
                                        <select class="form-select form-control-solid" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($filmCategories as $cat)
                                                <option value="{{$cat->id}}" {{@$film->category_id == $cat->id ? 'selected' : ''}}>{{$cat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <!--begin::Release Date and Watch Time-->
                                    <div class="fv-row mb-7 col-md-3">
                                        <label class="fs-6 fw-semibold mb-2">Release Date</label>
                                        <input type="date" class="form-control form-control-solid" value="{{@$film->release_date ? $film->release_date->format('Y-m-d') : ''}}" name="release_date" />
                                    </div>
                                    
                                    <div class="fv-row mb-7 col-md-3">
                                        <label class="fs-6 fw-semibold mb-2">Watch Time</label>
                                        <input type="text" class="form-control form-control-solid" value="{{@$film->watch_time}}" placeholder="e.g., 120 min" name="watch_time" />
                                    </div>
                                    
                                    <!--begin::Position and Status-->
                                    <div class="fv-row mb-7 col-md-3">
                                        <label class="fs-6 fw-semibold mb-2">Position</label>
                                        <input type="number" class="form-control form-control-solid" value="{{@$film->position ?? 0}}" placeholder="0" name="position" />
                                    </div>
                                    
                                    <div class="fv-row mb-7 col-md-3">
                                        <label class="fs-6 fw-semibold mb-2">Status</label>
                                        <select class="form-select form-control-solid" name="status">
                                            <option value="active" {{@$film->status == 'active' ? 'selected' : ''}}>Active</option>
                                            <option value="inactive" {{@$film->status == 'inactive' ? 'selected' : ''}}>Inactive</option>
                                        </select>
                                    </div>
                                    
                                    <!--begin::Trailer Link and Watch Link-->
                                    <div class="fv-row mb-7 col-md-6">
                                        <label class="fs-6 fw-semibold mb-2">Trailer Link</label>
                                        <input type="url" class="form-control form-control-solid" value="{{@$film->trailer_link}}" placeholder="https://youtube.com/watch?v=..." name="trailer_link" />
                                    </div>
                                    
                                    <div class="fv-row mb-7 col-md-6">
                                        <label class="fs-6 fw-semibold mb-2">Watch Link</label>
                                        <input type="url" class="form-control form-control-solid" value="{{@$film->watch_link}}" placeholder="https://..." name="watch_link" />
                                    </div>
                                    
                                    <!--begin::Genre and Tags-->
                                    <div class="fv-row mb-7 col-md-6">
                                        <label class="fs-6 fw-semibold mb-2">Genre (comma-separated)</label>
                                        <input type="text" class="form-control form-control-solid" value="{{isset($film) && $film->genre ? implode(', ', $film->genre) : ''}}" placeholder="Action, Drama, Comedy" name="genre" />
                                        <div class="form-text">Enter multiple genres separated by commas</div>
                                    </div>
                                    
                                    <div class="fv-row mb-7 col-md-6">
                                        <label class="fs-6 fw-semibold mb-2">Tags (comma-separated)</label>
                                        <input type="text" class="form-control form-control-solid" value="{{isset($film) && $film->tags ? implode(', ', $film->tags) : ''}}" placeholder="adventure, thriller, award-winning" name="tags" />
                                        <div class="form-text">Enter multiple tags separated by commas</div>
                                    </div>
                                    
                                    <!--begin::Synopsis-->
                                    <div class="fv-row mb-7 col-md-12">
                                        <label class="fs-6 fw-semibold mb-2">Synopsis</label>
                                        <textarea class="form-control form-control-solid" name="synopsis" rows="4" placeholder="Brief summary of the film">{{@$film->synopsis}}</textarea>
                                    </div>
                                    
                                    <!--begin::Description-->
                                    <div class="fv-row mb-7 col-md-12">
                                        <label class="fs-6 fw-semibold mb-2">Description</label>
                                        <textarea id="ckeditor" class="form-control form-control-solid" name="description" rows="10">{{@$film->description}}</textarea>
                                    </div>
                                    
                                    <!--begin::Image Management Section-->
                                    <div class="col-md-12 mb-5 mt-7">
                                        <div class="separator separator-dashed mb-6"></div>
                                        <h4 class="text-gray-800 fw-bold mb-0">Image Management</h4>
                                    </div>
                                    
                                    <!--begin::Film Poster-->
                                    <div class="fv-row mb-7 col-md-6">
                                        <div class="card card-flush py-4">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h5 class="fw-bold m-0">Film Poster</h5>
                                                </div>
                                            </div>
                                            <div class="card-body pt-0">
                                                <p class="text-muted mb-4">Main poster image for the film</p>
                                                <button type="button" id="choosePoster" class="btn btn-primary btn-sm mb-3">
                                                    <i class="fa fa-image"></i> Choose Poster
                                                </button>
                                                <input id="film_poster" value="{{@$film->film_poster}}" type="hidden" name="film_poster">
                                                
                                                <div id="holder-poster" class="thumbnail-preview">
                                                    <!-- Poster will be rendered here by JavaScript -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!--begin::Film Banner-->
                                    <div class="fv-row mb-7 col-md-6">
                                        <div class="card card-flush py-4">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h5 class="fw-bold m-0">Film Banner</h5>
                                                </div>
                                            </div>
                                            <div class="card-body pt-0">
                                                <p class="text-muted mb-4">Banner image for the film</p>
                                                <button type="button" id="chooseBanner" class="btn btn-primary btn-sm mb-3">
                                                    <i class="fa fa-image"></i> Choose Banner
                                                </button>
                                                <input id="film_banner" value="{{@$film->film_banner}}" type="hidden" name="film_banner">
                                                
                                                <div id="holder-banner" class="thumbnail-preview">
                                                    <!-- Banner will be rendered here by JavaScript -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!--begin::Film Images (Multiple)-->
                                    <div class="fv-row mb-7 col-md-12">
                                        <div class="card card-flush py-4">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h5 class="fw-bold m-0">Film Images</h5>
                                                </div>
                                            </div>
                                            <div class="card-body pt-0">
                                                <p class="text-muted mb-4">Multiple images for the film. Drag to reorder, click X to remove.</p>
                                                <div class="mb-4">
                                                    <button type="button" id="addMoreFilmImages" class="btn btn-primary btn-sm">
                                                        <i class="fa fa-image"></i> Add Images
                                                    </button>
                                                    <button type="button" id="clearAllFilmImages" class="btn btn-danger btn-sm ms-2">
                                                        <i class="fa fa-trash"></i> Clear All
                                                    </button>
                                                </div>
                                                <input id="film_images" type="hidden" name="film_images" value="{{isset($film) && $film->film_images ? implode(',', $film->film_images) : ''}}">
                                                
                                                <div id="holder-film-images" class="image-gallery">
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
            // Film Poster Management
            let posterUrl = '';
            let isSelectingPoster = false;
            
            function initializePoster() {
                posterUrl = $('#film_poster').val() || '';
                renderPoster();
            }
            
            function renderPoster() {
                const holder = $('#holder-poster');
                holder.empty();
                
                if (!posterUrl) {
                    holder.html('<p class="text-muted">No poster selected. Click "Choose Poster" to select an image.</p>');
                    return;
                }
                
                const posterItem = $(`
                    <div class="thumbnail-item">
                        <div class="thumbnail-wrapper">
                            <img src="${posterUrl}" alt="Poster">
                            <button type="button" class="btn-delete-thumb" title="Remove poster">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                `);
                holder.append(posterItem);
            }
            
            $('#choosePoster').on('click', function() {
                isSelectingPoster = true;
                window.open('/laravel-filemanager?type=Images', 'FileManager', 'width=900,height=600');
            });
            
            $(document).on('click', '#holder-poster .btn-delete-thumb', function() {
                posterUrl = '';
                $('#film_poster').val('');
                renderPoster();
            });
            
            initializePoster();
            
            // Film Banner Management
            let bannerUrl = '';
            let isSelectingBanner = false;
            
            function initializeBanner() {
                bannerUrl = $('#film_banner').val() || '';
                renderBanner();
            }
            
            function renderBanner() {
                const holder = $('#holder-banner');
                holder.empty();
                
                if (!bannerUrl) {
                    holder.html('<p class="text-muted">No banner selected. Click "Choose Banner" to select an image.</p>');
                    return;
                }
                
                const bannerItem = $(`
                    <div class="thumbnail-item">
                        <div class="thumbnail-wrapper">
                            <img src="${bannerUrl}" alt="Banner">
                            <button type="button" class="btn-delete-thumb" title="Remove banner">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                `);
                holder.append(bannerItem);
            }
            
            $('#chooseBanner').on('click', function() {
                isSelectingBanner = true;
                window.open('/laravel-filemanager?type=Images', 'FileManager', 'width=900,height=600');
            });
            
            $(document).on('click', '#holder-banner .btn-delete-thumb', function() {
                bannerUrl = '';
                $('#film_banner').val('');
                renderBanner();
            });
            
            initializeBanner();
            
            // Film Images Management (Multiple) with Drag and Drop
            let currentFilmImages = [];
            let draggedElement = null;
            
            function initializeFilmImages() {
                const imageUrls = $('#film_images').val();
                if (imageUrls) {
                    currentFilmImages = imageUrls.split(',').filter(url => url.trim() !== '');
                }
                renderFilmImages();
            }
            
            function renderFilmImages() {
                const holder = $('#holder-film-images');
                holder.empty();
                
                if (currentFilmImages.length === 0) {
                    holder.html('<p class="text-muted">No images selected. Click "Add Images" to select images.</p>');
                    $('#film_images').val('');
                    return;
                }
                
                currentFilmImages.forEach((url, index) => {
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
                
                updateFilmImagesInput();
                attachDragEvents();
            }
            
            function updateFilmImagesInput() {
                $('#film_images').val(currentFilmImages.join(','));
            }
            
            $('#addMoreFilmImages').on('click', function() {
                isSelectingPoster = false;
                isSelectingBanner = false;
                window.open('/laravel-filemanager?type=Images&multiple=1', 'FileManager', 'width=900,height=600');
            });
            
            $('#clearAllFilmImages').on('click', function() {
                if (currentFilmImages.length > 0) {
                    if (confirm('Are you sure you want to remove all images?')) {
                        currentFilmImages = [];
                        renderFilmImages();
                    }
                }
            });
            
            $(document).on('click', '#holder-film-images .btn-delete', function() {
                const index = $(this).data('index');
                currentFilmImages.splice(index, 1);
                renderFilmImages();
            });
            
            // Drag and Drop functionality
            function attachDragEvents() {
                const items = document.querySelectorAll('#holder-film-images .image-item');
                
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
                    const draggedItem = currentFilmImages[draggedIndex];
                    currentFilmImages.splice(draggedIndex, 1);
                    currentFilmImages.splice(targetIndex, 0, draggedItem);
                    
                    renderFilmImages();
                }
                
                return false;
            }
            
            function handleDragEnd(e) {
                this.classList.remove('dragging');
                document.querySelectorAll('#holder-film-images .image-item').forEach(item => {
                    item.classList.remove('drag-over');
                });
            }
            
            // Global callback for file manager
            window.SetUrl = function(items) {
                if (isSelectingPoster) {
                    if (Array.isArray(items) && items.length > 0) {
                        posterUrl = items[0].url || '';
                    } else if (items && items.url) {
                        posterUrl = items.url;
                    }
                    $('#film_poster').val(posterUrl);
                    renderPoster();
                } else if (isSelectingBanner) {
                    if (Array.isArray(items) && items.length > 0) {
                        bannerUrl = items[0].url || '';
                    } else if (items && items.url) {
                        bannerUrl = items.url;
                    }
                    $('#film_banner').val(bannerUrl);
                    renderBanner();
                } else {
                    // Handle multiple images
                    let newUrls = [];
                    if (Array.isArray(items)) {
                        newUrls = items.map(item => item.url || item).filter(url => url);
                    } else if (items) {
                        newUrls = [items.url || items];
                    }
                    
                    // Add new images to existing ones
                    newUrls.forEach(url => {
                        if (url && !currentFilmImages.includes(url)) {
                            currentFilmImages.push(url);
                        }
                    });
                    
                    renderFilmImages();
                }
            };
            
            initializeFilmImages();
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

