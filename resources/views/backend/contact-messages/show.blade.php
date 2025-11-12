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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Contact Message Details</h1>
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
                        <li class="breadcrumb-item text-muted"><a href="{{route('admin.contact-messages.index')}}" class="text-muted text-hover-primary">Contact Messages</a></li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">View Message</li>
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
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <div>
                                    <span class="badge {{$message->is_read ? 'badge-light-success' : 'badge-light-warning'}} mb-2">
                                        {{$message->is_read ? 'Read' : 'New'}}
                                    </span>
                                    <h3 class="mb-0">Message from {{$message->name}}</h3>
                                </div>
                                <div>
                                    <a href="{{route('admin.contact-messages.index')}}" class="btn btn-light me-3">
                                        <i class="fa fa-arrow-left me-2"></i>Back to Messages
                                    </a>
                                    @if(!$message->is_read)
                                    <a href="{{route('admin.contact-messages.mark-read',$message->id)}}" class="btn btn-primary me-3">
                                        <i class="fa fa-check me-2"></i>Mark as Read
                                    </a>
                                    @endif
                                    <a onclick="deleteItem({{$message->id}},'{{route('admin.contact-messages.destroy',$message->id)}}')" class="btn btn-danger">
                                        <i class="fa fa-trash me-2"></i>Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-7">
                                    <label class="fs-6 fw-semibold mb-2 text-gray-500">Name</label>
                                    <div class="fs-5 fw-bold text-gray-800">{{$message->name}}</div>
                                </div>
                                <div class="mb-7">
                                    <label class="fs-6 fw-semibold mb-2 text-gray-500">Email</label>
                                    <div class="fs-5">
                                        <a href="mailto:{{$message->email}}" class="text-primary text-hover-primary">{{$message->email}}</a>
                                    </div>
                                </div>
                                @if($message->phone)
                                <div class="mb-7">
                                    <label class="fs-6 fw-semibold mb-2 text-gray-500">Phone</label>
                                    <div class="fs-5">
                                        <a href="tel:{{$message->phone}}" class="text-primary text-hover-primary">{{$message->phone}}</a>
                                    </div>
                                </div>
                                @endif
                                @if($message->subject)
                                <div class="mb-7">
                                    <label class="fs-6 fw-semibold mb-2 text-gray-500">Subject</label>
                                    <div class="fs-5 fw-bold text-gray-800">{{$message->subject}}</div>
                                </div>
                                @endif
                                <div class="mb-7">
                                    <label class="fs-6 fw-semibold mb-2 text-gray-500">Message</label>
                                    <div class="fs-5 text-gray-800" style="white-space: pre-wrap; line-height: 1.8;">{{$message->message}}</div>
                                </div>
                                <div class="mb-7">
                                    <label class="fs-6 fw-semibold mb-2 text-gray-500">Submitted</label>
                                    <div class="fs-5 text-gray-600">{{$message->created_at->format('d M Y, h:i A')}}</div>
                                </div>
                            </div>
                        </div>
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

