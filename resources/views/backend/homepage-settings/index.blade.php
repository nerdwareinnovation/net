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
                        Homepage Settings
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
                        <li class="breadcrumb-item text-muted">Homepage Settings</li>
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
                
                <!--begin::Slider Section Card (Below Banner)-->
                <div class="card shadow-sm mb-5">
                    <div class="card-header border-0 pt-6 pb-5">
                        <div class="card-title">
                            <h3 class="card-label fw-bold fs-3 mb-1">Slider Section (Below Banner)</h3>
                        </div>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSectionModal" onclick="setSectionName('slider_section')">
                                <i class="ki-outline ki-plus fs-2"></i>
                                Add Item
                            </button>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-row-dashed align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0 border-bottom border-gray-200">
                                        <th class="min-w-50px">Position</th>
                                        <th class="min-w-150px">Type</th>
                                        <th class="min-w-200px">Item</th>
                                        <th class="text-end min-w-100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @forelse($sliderSections as $section)
                                    <tr>
                                        <td>
                                            <span class="badge badge-light-info fw-bold">{{$section->position}}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-primary fw-bold text-capitalize">{{$section->item_type}}</span>
                                        </td>
                                        <td>
                                            @php
                                                $item = null;
                                                $itemImage = null;
                                                if($section->item_type == 'story') {
                                                    $item = \App\Models\Stories::find($section->item_id);
                                                    if($item) {
                                                        $itemImage = $item->thumbnail ?? (is_array($item->story_images) && count($item->story_images) > 0 ? $item->story_images[0] : null);
                                                    }
                                                } elseif($section->item_type == 'film') {
                                                    $item = \App\Models\Films::find($section->item_id);
                                                    if($item) {
                                                        $itemImage = $item->film_poster ?? null;
                                                    }
                                                } elseif($section->item_type == 'gallery') {
                                                    $item = \App\Models\Galleries::find($section->item_id);
                                                    if($item) {
                                                        $itemImage = $item->thumbnail ?? (is_array($item->child_images) && count($item->child_images) > 0 ? $item->child_images[0] : null);
                                                    }
                                                }
                                            @endphp
                                            <div class="d-flex align-items-center gap-3">
                                                @if($item && $itemImage)
                                                <div class="symbol symbol-50px">
                                                    <img src="{{asset($itemImage)}}" alt="{{$item->title}}" class="symbol-label" style="object-fit: cover; border-radius: 4px;">
                                                </div>
                                                @else
                                                <div class="symbol symbol-50px bg-light" style="border-radius: 4px;">
                                                    <div class="symbol-label text-gray-400 d-flex align-items-center justify-content-center">
                                                        <i class="ki-outline ki-picture fs-2"></i>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <span class="text-gray-800 fw-bold">{{$item ? $item->title : 'Item Not Found (ID: ' . $section->item_id . ')'}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-light btn-active-light-primary" onclick="editSection({{$section->id}}, '{{$section->section_name}}', '{{$section->item_type}}', {{$section->item_id}}, {{$section->position}})">
                                                <i class="ki-outline ki-pencil fs-6"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-light btn-active-light-danger" onclick="deleteSection({{$section->id}})">
                                                <i class="ki-outline ki-trash fs-6"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-15">
                                            <span class="text-gray-500 fs-6">No items in slider section. Click "Add Item" to add.</span>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!--begin::Vimeo Section Settings Card-->
                <div class="card shadow-sm mb-5">
                    <div class="card-header border-0 pt-6">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold fs-3 mb-1">Dive Into Our Films Section</span>
                        </h3>
                    </div>
                    <div class="card-body pt-0">
                        <form class="form" action="{{route('admin.homepage-settings.update')}}" method="POST" id="homepageSettingsForm">@csrf
                            @method('PUT')
                            <div class="row">
                                <!--begin::Vimeo Video ID-->
                                <div class="fv-row mb-7 col-md-6">
                                    <label class="fs-6 fw-semibold mb-2">Vimeo Video ID</label>
                                    <input type="text" class="form-control form-control-solid" value="{{@$homepageSettings->vimeo_video_id}}" placeholder="e.g., 945809677" name="vimeo_video_id" />
                                    <div class="form-text">Enter only the video ID from Vimeo URL</div>
                                </div>
                                
                                <!--begin::Vimeo Title-->
                                <div class="fv-row mb-7 col-md-6">
                                    <label class="fs-6 fw-semibold mb-2">Title</label>
                                    <input type="text" class="form-control form-control-solid" value="{{@$homepageSettings->vimeo_title}}" placeholder="Dive Into Our Films" name="vimeo_title" />
                                </div>
                                
                                <!--begin::Vimeo Description-->
                                <div class="fv-row mb-7 col-md-12">
                                    <label class="fs-6 fw-semibold mb-2">Description</label>
                                    <textarea class="form-control form-control-solid" name="vimeo_description" rows="3" placeholder="Experience the world through our lens">{{@$homepageSettings->vimeo_description}}</textarea>
                                </div>
                                
                                <!--begin::Vimeo Button Text and URL-->
                                <div class="fv-row mb-7 col-md-6">
                                    <label class="fs-6 fw-semibold mb-2">Button Text</label>
                                    <input type="text" class="form-control form-control-solid" value="{{@$homepageSettings->vimeo_button_text}}" placeholder="Explore Films" name="vimeo_button_text" />
                                </div>
                                
                                <div class="fv-row mb-7 col-md-6">
                                    <label class="fs-6 fw-semibold mb-2">Button URL</label>
                                    <input type="url" class="form-control form-control-solid" value="{{@$homepageSettings->vimeo_button_url}}" placeholder="https://..." name="vimeo_button_url" />
                                </div>
                                
                                <!--begin::Vimeo Film IDs-->
                                <div class="fv-row mb-7 col-md-12">
                                    <label class="fs-6 fw-semibold mb-2">Films for Poster Slider</label>
                                    <select class="form-select form-control-solid" name="vimeo_film_ids[]" id="vimeo_film_ids" multiple="multiple" data-control="select2" data-placeholder="Select films for poster slider">
                                        @foreach($films as $film)
                                        <option value="{{$film->id}}" {{isset($homepageSettings) && $homepageSettings->vimeo_film_ids && in_array($film->id, $homepageSettings->vimeo_film_ids) ? 'selected' : ''}}>
                                            {{$film->title}}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">Select multiple films. These films will appear in the poster slider below the Vimeo video.</div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!--begin::Content Section Card (Below Vimeo)-->
                <div class="card shadow-sm mb-5">
                    <div class="card-header border-0 pt-6 pb-5">
                        <div class="card-title">
                            <h3 class="card-label fw-bold fs-3 mb-1">Content Section (Below Vimeo)</h3>
                        </div>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSectionModal" onclick="setSectionName('content_section')">
                                <i class="ki-outline ki-plus fs-2"></i>
                                Add Item
                            </button>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-row-dashed align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0 border-bottom border-gray-200">
                                        <th class="min-w-50px">Position</th>
                                        <th class="min-w-150px">Type</th>
                                        <th class="min-w-200px">Item</th>
                                        <th class="text-end min-w-100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @forelse($contentSections as $section)
                                    <tr>
                                        <td>
                                            <span class="badge badge-light-info fw-bold">{{$section->position}}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-primary fw-bold text-capitalize">{{$section->item_type}}</span>
                                        </td>
                                        <td>
                                            @php
                                                $item = null;
                                                $itemImage = null;
                                                if($section->item_type == 'story') {
                                                    $item = \App\Models\Stories::find($section->item_id);
                                                    if($item) {
                                                        $itemImage = $item->thumbnail ?? (is_array($item->story_images) && count($item->story_images) > 0 ? $item->story_images[0] : null);
                                                    }
                                                } elseif($section->item_type == 'film') {
                                                    $item = \App\Models\Films::find($section->item_id);
                                                    if($item) {
                                                        $itemImage = $item->film_poster ?? null;
                                                    }
                                                } elseif($section->item_type == 'gallery') {
                                                    $item = \App\Models\Galleries::find($section->item_id);
                                                    if($item) {
                                                        $itemImage = $item->thumbnail ?? (is_array($item->child_images) && count($item->child_images) > 0 ? $item->child_images[0] : null);
                                                    }
                                                }
                                            @endphp
                                            <div class="d-flex align-items-center gap-3">
                                                @if($item && $itemImage)
                                                <div class="symbol symbol-50px">
                                                    <img src="{{asset($itemImage)}}" alt="{{$item->title}}" class="symbol-label" style="object-fit: cover; border-radius: 4px;">
                                                </div>
                                                @else
                                                <div class="symbol symbol-50px bg-light" style="border-radius: 4px;">
                                                    <div class="symbol-label text-gray-400 d-flex align-items-center justify-content-center">
                                                        <i class="ki-outline ki-picture fs-2"></i>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <span class="text-gray-800 fw-bold">{{$item ? $item->title : 'Item Not Found (ID: ' . $section->item_id . ')'}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-light btn-active-light-primary" onclick="editSection({{$section->id}}, '{{$section->section_name}}', '{{$section->item_type}}', {{$section->item_id}}, {{$section->position}})">
                                                <i class="ki-outline ki-pencil fs-6"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-light btn-active-light-danger" onclick="deleteSection({{$section->id}})">
                                                <i class="ki-outline ki-trash fs-6"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-15">
                                            <span class="text-gray-500 fs-6">No items in content section. Click "Add Item" to add.</span>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!--begin::Featured Story Section Card-->
                <div class="card shadow-sm mb-5">
                    <div class="card-header border-0 pt-6">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold fs-3 mb-1">Featured Story Section</span>
                        </h3>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <!--begin::Featured Story Banner Image-->
                            <div class="fv-row mb-7 col-md-12">
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h5 class="fw-bold m-0">Banner Image</h5>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <p class="text-muted mb-4">Background image for the featured story section</p>
                                        <button type="button" id="chooseFeaturedStoryImage" class="btn btn-primary btn-sm mb-3">
                                            <i class="fa fa-image"></i> Choose Image
                                        </button>
                                        <input id="featured_story_banner_image" value="{{@$homepageSettings->featured_story_banner_image}}" type="hidden" name="featured_story_banner_image">
                                        
                                        <div id="holder-featured-story" class="thumbnail-preview">
                                            <!-- Image will be rendered here by JavaScript -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!--begin::Featured Story Title-->
                            <div class="fv-row mb-7 col-md-12">
                                <label class="fs-6 fw-semibold mb-2">Title</label>
                                <input type="text" class="form-control form-control-solid" value="{{@$homepageSettings->featured_story_title}}" placeholder="Featured Story Title" name="featured_story_title" />
                            </div>
                            
                            <!--begin::Featured Story Description-->
                            <div class="fv-row mb-7 col-md-12">
                                <label class="fs-6 fw-semibold mb-2">Description</label>
                                <textarea class="form-control form-control-solid" name="featured_story_description" rows="4" placeholder="Your compelling story description goes here...">{{@$homepageSettings->featured_story_description}}</textarea>
                            </div>
                            
                            <!--begin::Featured Story Button Text and URL-->
                            <div class="fv-row mb-7 col-md-6">
                                <label class="fs-6 fw-semibold mb-2">Button Text</label>
                                <input type="text" class="form-control form-control-solid" value="{{@$homepageSettings->featured_story_button_text}}" placeholder="Read Story" name="featured_story_button_text" />
                            </div>
                            
                            <div class="fv-row mb-7 col-md-6">
                                <label class="fs-6 fw-semibold mb-2">Button URL</label>
                                <input type="url" class="form-control form-control-solid" value="{{@$homepageSettings->featured_story_button_url}}" placeholder="https://..." name="featured_story_button_url" />
                            </div>
                            
                            <div class="col-md-12">
                                <button type="button" onclick="updateHomepageSettings()" class="btn btn-primary">
                                    <span class="indicator-label">Update All Settings</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    
    <!--begin::Add/Edit Section Modal-->
    <div class="modal fade" id="addSectionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold" id="sectionModalTitle">Add Section Item</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                </div>
                <form id="sectionForm" method="POST" action="{{route('admin.homepage-settings.sections.store')}}">
                    @csrf
                    <div class="modal-body scroll-y px-5 py-4">
                        <div class="fv-row mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Section</label>
                            <select class="form-select form-control-solid" id="section_name" name="section_name" required>
                                <option value="slider_section">Slider Section</option>
                                <option value="content_section">Content Section</option>
                            </select>
                        </div>
                        
                        <div class="fv-row mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Item Type</label>
                            <select class="form-select form-control-solid" id="item_type" name="item_type" required onchange="loadItems()">
                                <option value="">Select Type</option>
                                <option value="story">Story</option>
                                <option value="film">Film</option>
                                <option value="gallery">Gallery</option>
                            </select>
                        </div>
                        
                        <div class="fv-row mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Item</label>
                            <select class="form-select form-control-solid" id="item_id" name="item_id" required>
                                <option value="">Select Item Type First</option>
                            </select>
                        </div>
                        
                        <div class="fv-row mb-0">
                            <label class="fs-6 fw-semibold mb-2">Position</label>
                            <input type="number" class="form-control form-control-solid" id="section_position" name="position" value="0" />
                        </div>
                    </div>
                    <div class="modal-footer px-5 py-3">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Add/Edit Section Modal-->
@endsection

@push('scripts')
<script>
    let isEditingSection = false;
    let editingSectionId = null;
    let currentSectionName = 'slider_section';
    let featuredStoryImageUrl = '';
    
    // Stories, Films, Galleries data
    const stories = @json($stories);
    const films = @json($films);
    const galleries = @json($galleries);
    
    function setSectionName(sectionName) {
        currentSectionName = sectionName;
        const sectionSelect = $('#section_name');
        sectionSelect.val(sectionName);
        
        // Disable the other option and enable the selected one
        sectionSelect.find('option').each(function() {
            if ($(this).val() === sectionName) {
                $(this).prop('disabled', false).prop('selected', true);
            } else {
                $(this).prop('disabled', true);
            }
        });
    }
    
    function resetSectionSelect() {
        // Re-enable all options
        $('#section_name').find('option').prop('disabled', false);
    }
    
    function loadItems() {
        const itemType = $('#item_type').val();
        const itemSelect = $('#item_id');
        itemSelect.empty();
        
        if (!itemType) {
            itemSelect.append('<option value="">Select Item Type First</option>');
            return;
        }
        
        let items = [];
        if (itemType === 'story') {
            items = stories;
        } else if (itemType === 'film') {
            items = films;
        } else if (itemType === 'gallery') {
            items = galleries;
        }
        
        itemSelect.append('<option value="">Select ' + itemType.charAt(0).toUpperCase() + itemType.slice(1) + '</option>');
        items.forEach(item => {
            itemSelect.append('<option value="' + item.id + '">' + item.title + '</option>');
        });
    }
    
    // Featured Story Image Management
    function initializeFeaturedStoryImage() {
        featuredStoryImageUrl = $('#featured_story_banner_image').val() || '';
        renderFeaturedStoryImage();
    }
    
    function renderFeaturedStoryImage() {
        const holder = $('#holder-featured-story');
        holder.empty();
        
        if (!featuredStoryImageUrl) {
            holder.html('<p class="text-muted">No image selected. Click "Choose Image" to select an image.</p>');
            return;
        }
        
        const imageItem = $(`
            <div class="thumbnail-item">
                <div class="thumbnail-wrapper">
                    <img src="${featuredStoryImageUrl}" alt="Featured Story Image">
                    <button type="button" class="btn-delete-thumb" title="Remove image">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        `);
        holder.append(imageItem);
    }
    
    $('#chooseFeaturedStoryImage').on('click', function() {
        window.open('/laravel-filemanager?type=Images', 'FileManager', 'width=900,height=600');
    });
    
    $(document).on('click', '#holder-featured-story .btn-delete-thumb', function() {
        featuredStoryImageUrl = '';
        $('#featured_story_banner_image').val('');
        renderFeaturedStoryImage();
    });
    
    // Global callback for file manager
    window.SetUrl = function(items) {
        if (typeof items === 'object' && items !== null) {
            if (Array.isArray(items) && items.length > 0) {
                featuredStoryImageUrl = items[0].url || items[0];
            } else if (items.url) {
                featuredStoryImageUrl = items.url;
            } else {
                featuredStoryImageUrl = items;
            }
            $('#featured_story_banner_image').val(featuredStoryImageUrl);
            renderFeaturedStoryImage();
        }
    };
    
    // Update homepage settings
    function updateHomepageSettings() {
        const form = $('#homepageSettingsForm');
        const featuredStoryImage = $('#featured_story_banner_image').val();
        const featuredStoryTitle = $('input[name="featured_story_title"]').val();
        const featuredStoryDescription = $('textarea[name="featured_story_description"]').val();
        const featuredStoryButtonText = $('input[name="featured_story_button_text"]').val();
        const featuredStoryButtonUrl = $('input[name="featured_story_button_url"]').val();
        
        // Add featured story fields to form
        if (!form.find('input[name="featured_story_banner_image"]').length) {
            form.append('<input type="hidden" name="featured_story_banner_image" value="' + featuredStoryImage + '">');
        } else {
            form.find('input[name="featured_story_banner_image"]').val(featuredStoryImage);
        }
        
        if (!form.find('input[name="featured_story_title"]').length) {
            form.append('<input type="hidden" name="featured_story_title" value="' + (featuredStoryTitle || '') + '">');
        } else {
            form.find('input[name="featured_story_title"]').val(featuredStoryTitle);
        }
        
        if (!form.find('textarea[name="featured_story_description"]').length) {
            form.append('<textarea name="featured_story_description" style="display:none">' + (featuredStoryDescription || '') + '</textarea>');
        } else {
            form.find('textarea[name="featured_story_description"]').val(featuredStoryDescription);
        }
        
        if (!form.find('input[name="featured_story_button_text"]').length) {
            form.append('<input type="hidden" name="featured_story_button_text" value="' + (featuredStoryButtonText || '') + '">');
        } else {
            form.find('input[name="featured_story_button_text"]').val(featuredStoryButtonText);
        }
        
        if (!form.find('input[name="featured_story_button_url"]').length) {
            form.append('<input type="hidden" name="featured_story_button_url" value="' + (featuredStoryButtonUrl || '') + '">');
        } else {
            form.find('input[name="featured_story_button_url"]').val(featuredStoryButtonUrl);
        }
        
        form.submit();
    }
    
    // Reset modal when closed
    $('#addSectionModal').on('hidden.bs.modal', function() {
        isEditingSection = false;
        editingSectionId = null;
        $('#sectionModalTitle').text('Add Section Item');
        $('#sectionForm')[0].reset();
        $('#sectionForm').attr('action', '{{route("admin.homepage-settings.sections.store")}}');
        $('#sectionForm').find('input[name="_method"]').remove();
        $('#item_id').empty().append('<option value="">Select Item Type First</option>');
        resetSectionSelect(); // Re-enable all section options
    });
    
    // Edit section
    function editSection(id, sectionName, itemType, itemId, position) {
        isEditingSection = true;
        editingSectionId = id;
        $('#sectionModalTitle').text('Edit Section Item');
        
        // Set section and disable other option
        const sectionSelect = $('#section_name');
        sectionSelect.val(sectionName);
        sectionSelect.find('option').each(function() {
            if ($(this).val() === sectionName) {
                $(this).prop('disabled', false).prop('selected', true);
            } else {
                $(this).prop('disabled', true);
            }
        });
        
        $('#item_type').val(itemType);
        loadItems();
        setTimeout(() => {
            $('#item_id').val(itemId);
        }, 100);
        $('#section_position').val(position);
        
        $('#sectionForm').attr('action', '{{route("admin.homepage-settings.sections.update", ":id")}}'.replace(':id', id));
        if (!$('#sectionForm').find('input[name="_method"]').length) {
            $('#sectionForm').append('<input type="hidden" name="_method" value="PUT">');
        }
        
        $('#addSectionModal').modal('show');
    }
    
    // Delete section
    function deleteSection(id) {
        if (confirm('Are you sure you want to delete this item?')) {
            const form = $('<form>', {
                'method': 'POST',
                'action': '{{route("admin.homepage-settings.sections.destroy", ":id")}}'.replace(':id', id)
            });
            form.append($('<input>', {
                'type': 'hidden',
                'name': '_method',
                'value': 'DELETE'
            }));
            form.append($('<input>', {
                'type': 'hidden',
                'name': '_token',
                'value': '{{csrf_token()}}'
            }));
            $('body').append(form);
            form.submit();
        }
    }
    
    // Initialize Select2 for multiple film selection
    $(document).ready(function() {
        if (typeof KTSelect2 !== 'undefined') {
            $('#vimeo_film_ids').select2({
                placeholder: 'Select films for poster slider',
                allowClear: true,
                width: '100%'
            });
        } else if (typeof $ !== 'undefined' && $.fn.select2) {
            $('#vimeo_film_ids').select2({
                placeholder: 'Select films for poster slider',
                allowClear: true,
                width: '100%'
            });
        }
    });
    
    initializeFeaturedStoryImage();
</script>

<style>
    .thumbnail-preview {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        min-height: 80px;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: flex-start;
    }
    
    .thumbnail-item {
        position: relative;
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

