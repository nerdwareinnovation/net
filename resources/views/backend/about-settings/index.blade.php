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
                        About Settings
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
                        <li class="breadcrumb-item text-muted">About Settings</li>
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
                <div class="card shadow-sm mb-5">
                    <div class="card-header border-0 pt-6">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold fs-3 mb-1">Main About Page Settings</span>
                        </h3>
                    </div>
                    <div class="card-body pt-0">
                        <form class="form" action="{{route('admin.about-settings.update')}}" method="POST">@csrf
                            @method('PUT')
                            <div class="row">
                                <!--begin::Vimeo Video ID-->
                                <div class="fv-row mb-7 col-md-6">
                                    <label class="fs-6 fw-semibold mb-2">Vimeo Video ID</label>
                                    <input type="text" class="form-control form-control-solid" value="{{@$aboutSettings->vimeo_video_id}}" placeholder="e.g., 120666341" name="vimeo_video_id" />
                                    <div class="form-text">Enter only the video ID from Vimeo URL</div>
                                </div>
                                
                                <!--begin::Page Title-->
                                <div class="fv-row mb-7 col-md-6">
                                    <label class="required fs-6 fw-semibold mb-2">Page Title</label>
                                    <input type="text" class="form-control form-control-solid" value="{{@$aboutSettings->page_title}}" placeholder="Never Ending Trails" name="page_title" required />
                                </div>
                                
                                <!--begin::Subtitle-->
                                <div class="fv-row mb-7 col-md-12">
                                    <label class="fs-6 fw-semibold mb-2">Subtitle</label>
                                    <input type="text" class="form-control form-control-solid" value="{{@$aboutSettings->subtitle}}" placeholder="Sharing stories of adventure..." name="subtitle" />
                                </div>
                                
                                <!--begin::Description-->
                                <div class="fv-row mb-7 col-md-12">
                                    <label class="fs-6 fw-semibold mb-2">Description</label>
                                    <textarea id="ckeditor" class="form-control form-control-solid" name="description" rows="10">{{@$aboutSettings->description}}</textarea>
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
                
                <!--begin::Sections Card-->
                <div class="card shadow-sm">
                    <div class="card-header border-0 pt-6 pb-5">
                        <div class="card-title">
                            <h3 class="card-label fw-bold fs-3 mb-1">About Sections</h3>
                        </div>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSectionModal">
                                <i class="ki-outline ki-plus fs-2"></i>
                                Add Section
                            </button>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-row-dashed align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0 border-bottom border-gray-200">
                                        <th class="min-w-50px">Position</th>
                                        <th class="min-w-200px">Title</th>
                                        <th class="min-w-150px">Image</th>
                                        <th class="min-w-300px">Description</th>
                                        <th class="text-end min-w-100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @forelse($sections as $section)
                                    <tr>
                                        <td>
                                            <span class="badge badge-light-info fw-bold">{{$section->position}}</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-800 fw-bold">{{$section->title}}</span>
                                        </td>
                                        <td>
                                            @if($section->image)
                                                <img src="{{asset($section->image)}}" alt="{{$section->title}}" class="w-100px h-100px object-fit-cover rounded" />
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-gray-600">{{Str::limit(strip_tags($section->description), 100)}}</span>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-light btn-active-light-primary" onclick="editSection({{$section->id}}, '{{$section->title}}', '{{addslashes($section->description)}}', '{{$section->image}}', {{$section->position}})">
                                                <i class="ki-outline ki-pencil fs-6"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-light btn-active-light-danger" onclick="deleteSection({{$section->id}})">
                                                <i class="ki-outline ki-trash fs-6"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-15">
                                            <div class="d-flex flex-column align-items-center">
                                                <span class="text-gray-700 fw-bold fs-4 mb-2">No Sections Found</span>
                                                <span class="text-gray-500 fs-6 mb-5">Start by adding your first section</span>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSectionModal">
                                                    <i class="ki-outline ki-plus fs-2"></i>
                                                    Add Section
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
                    <h2 class="fw-bold" id="sectionModalTitle">Add Section</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                </div>
                <form id="sectionForm" method="POST" action="{{route('admin.about-settings.sections.store')}}">
                    @csrf
                    <div class="modal-body scroll-y px-5 py-4">
                        <div class="fv-row mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Title</label>
                            <input type="text" class="form-control form-control-solid" id="section_title" name="title" required />
                        </div>
                        
                        <div class="fv-row mb-5">
                            <label class="fs-6 fw-semibold mb-2">Description</label>
                            <textarea class="form-control form-control-solid" id="section_description" name="description" rows="4"></textarea>
                        </div>
                        
                        <div class="fv-row mb-5">
                            <label class="fs-6 fw-semibold mb-2">Image</label>
                            <button type="button" id="chooseSectionImage" class="btn btn-primary btn-sm mb-2">
                                <i class="fa fa-image"></i> Choose Image
                            </button>
                            <input id="section_image" type="hidden" name="image">
                            <div id="section_image_preview" class="mt-2"></div>
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
    let sectionImageUrl = '';
    
    // Initialize section image picker
    function initializeSectionImage() {
        sectionImageUrl = $('#section_image').val() || '';
        renderSectionImage();
    }
    
    function renderSectionImage() {
        const preview = $('#section_image_preview');
        preview.empty();
        
        if (!sectionImageUrl) {
            preview.html('<p class="text-muted">No image selected. Click "Choose Image" to select an image.</p>');
            return;
        }
        
        const imageItem = $(`
            <div class="thumbnail-item">
                <div class="thumbnail-wrapper">
                    <img src="${sectionImageUrl}" alt="Section Image">
                    <button type="button" class="btn-delete-thumb" title="Remove image">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        `);
        preview.append(imageItem);
    }
    
    $('#chooseSectionImage').on('click', function() {
        window.open('/laravel-filemanager?type=Images', 'FileManager', 'width=900,height=600');
    });
    
    $(document).on('click', '#section_image_preview .btn-delete-thumb', function() {
        sectionImageUrl = '';
        $('#section_image').val('');
        renderSectionImage();
    });
    
    // Global callback for file manager
    window.SetUrl = function(items) {
        if (typeof items === 'object' && items !== null) {
            if (Array.isArray(items) && items.length > 0) {
                sectionImageUrl = items[0].url || items[0];
            } else if (items.url) {
                sectionImageUrl = items.url;
            } else {
                sectionImageUrl = items;
            }
            $('#section_image').val(sectionImageUrl);
            renderSectionImage();
        }
    };
    
    // Set form action when modal is shown (for adding)
    $('#addSectionModal').on('show.bs.modal', function() {
        if (!isEditingSection) {
            $('#sectionForm').attr('action', '{{route("admin.about-settings.sections.store")}}');
            $('#sectionForm').find('input[name="_method"]').remove();
        }
    });
    
    // Reset modal when closed
    $('#addSectionModal').on('hidden.bs.modal', function() {
        isEditingSection = false;
        editingSectionId = null;
        $('#sectionModalTitle').text('Add Section');
        $('#sectionForm')[0].reset();
        $('#sectionForm').attr('action', '{{route("admin.about-settings.sections.store")}}');
        $('#sectionForm').find('input[name="_method"]').remove();
        sectionImageUrl = '';
        $('#section_image').val('');
        renderSectionImage();
    });
    
    // Edit section
    function editSection(id, title, description, image, position) {
        isEditingSection = true;
        editingSectionId = id;
        $('#sectionModalTitle').text('Edit Section');
        $('#section_title').val(title);
        $('#section_description').val(description);
        $('#section_position').val(position);
        sectionImageUrl = image || '';
        $('#section_image').val(sectionImageUrl);
        renderSectionImage();
        
        $('#sectionForm').attr('action', '{{route("admin.about-settings.sections.update", ":id")}}'.replace(':id', id));
        if (!$('#sectionForm').find('input[name="_method"]').length) {
            $('#sectionForm').append('<input type="hidden" name="_method" value="PUT">');
        }
        
        $('#addSectionModal').modal('show');
    }
    
    // Delete section
    function deleteSection(id) {
        if (confirm('Are you sure you want to delete this section?')) {
            const form = $('<form>', {
                'method': 'POST',
                'action': '{{route("admin.about-settings.sections.destroy", ":id")}}'.replace(':id', id)
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
    
    initializeSectionImage();
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
        width: 100px;
        height: 100px;
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

