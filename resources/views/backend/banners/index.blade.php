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
                        Banner Management
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
                        <li class="breadcrumb-item text-muted">Banners</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{route('admin.banners.create')}}" class="btn btn-primary btn-sm">
                        <i class="ki-outline ki-plus fs-2"></i>
                        Add New Banner
                    </a>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card shadow-sm">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6 pb-5">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search banners..." />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                    </div>
                    <!--end::Card header-->
                    
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-row-dashed align-middle gs-0 gy-4" id="kt_customers_table">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0 border-bottom border-gray-200">
                                        <th class="w-10px pe-2">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_customers_table .form-check-input" value="1" />
                                            </div>
                                        </th>
                                        <th class="min-w-200px ps-3">Banner</th>
                                        <th class="min-w-200px">Title</th>
                                        <th class="min-w-150px">Button</th>
                                        <th class="min-w-100px">Position</th>
                                        <th class="min-w-100px">Status</th>
                                        <th class="text-end min-w-100px pe-3">Actions</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                
                                <!--begin::Table body-->
                                <tbody class="fw-semibold text-gray-600">
                                    @forelse($banners as $banner)
                                    <tr class="hover-elevate">
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1" />
                                            </div>
                                        </td>
                                        <td class="ps-3">
                                            <div class="symbol symbol-50px me-3">
                                                @if($banner->image)
                                                    <img src="{{asset($banner->image)}}" alt="{{$banner->title}}" class="w-100 rounded" />
                                                @else
                                                    <div class="symbol-label bg-light-primary">
                                                        <i class="ki-outline ki-picture fs-2x text-primary"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 fw-bold mb-1">{{$banner->title}}</span>
                                                @if($banner->short_description)
                                                    <span class="text-gray-500 fs-7">{{Str::limit($banner->short_description, 60)}}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($banner->button_text && $banner->button_url)
                                                <a href="{{$banner->button_url}}" target="_blank" class="btn btn-sm btn-light-primary">
                                                    {{$banner->button_text}}
                                                </a>
                                            @else
                                                <span class="text-muted">No Button</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info fw-bold">{{$banner->position ?? 0}}</span>
                                        </td>
                                        <td>
                                            @if($banner->status == 'active')
                                                <span class="badge badge-light-success fw-bold">
                                                    <i class="ki-outline ki-check-circle fs-7 me-1"></i>
                                                    Active
                                                </span>
                                            @else
                                                <span class="badge badge-light-danger fw-bold">
                                                    <i class="ki-outline ki-cross-circle fs-7 me-1"></i>
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-3">
                                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                Actions
                                                <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                            </a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4" data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="{{route('admin.banners.edit',$banner->id)}}" class="menu-link px-3">
                                                        <i class="ki-outline ki-pencil fs-6 me-2"></i>
                                                        Edit
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a onclick="deleteItem({{$banner->id}},'{{route('admin.banners.destroy',$banner->id)}}')" class="menu-link px-3 text-danger" data-kt-customer-table-filter="delete_row">
                                                        <i class="ki-outline ki-trash fs-6 me-2"></i>
                                                        Delete
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-15">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="symbol symbol-100px mb-5">
                                                    <div class="symbol-label bg-light-primary">
                                                        <i class="ki-outline ki-file-deleted fs-3x text-primary"></i>
                                                    </div>
                                                </div>
                                                <span class="text-gray-700 fw-bold fs-4 mb-2">No Banners Found</span>
                                                <span class="text-gray-500 fs-6 mb-5">Start by creating your first banner</span>
                                                <a href="{{route('admin.banners.create')}}" class="btn btn-primary btn-sm">
                                                    <i class="ki-outline ki-plus fs-2"></i>
                                                    Add New Banner
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <!--end::Table body-->
                            </table>
                        </div>
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

@push('styles')
<style>
    .hover-elevate {
        transition: all 0.2s ease;
    }
    .hover-elevate:hover {
        background-color: #f9fafb;
        transform: translateY(-1px);
    }
    .symbol img {
        object-fit: cover;
    }
</style>
@endpush

