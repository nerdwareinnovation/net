@extends('backend.partials.master')

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                
                <!--begin::Welcome Banner-->
                <div class="card bg-gradient-primary mb-8" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body py-8">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h1 class="text-white fw-bold mb-2">Welcome Back, {{ auth()->user()->name ?? 'Admin' }}! 👋</h1>
                                <p class="text-white opacity-75 fs-5 mb-0">Here's what's happening with your business today.</p>
                            </div>
                            <div class="d-none d-md-block">
                                <i class="ki-outline ki-chart-line-up text-white" style="font-size: 5rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Welcome Banner-->
                
                <!--begin::Main Stats-->
                <div class="row g-5 g-xl-8 mb-5 mb-xl-8">
                    <!--begin::Products-->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-flush h-100 shadow-sm hover-elevate-up">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-center justify-content-between mb-5">
                                    <div class="symbol symbol-50px bg-light-warning">
                                        <i class="ki-outline ki-basket fs-2x text-warning"></i>
                                    </div>
                                    <span class="badge badge-light-warning fs-7 fw-bold">Active</span>
                                </div>
                                <span class="text-gray-900 fw-bold fs-2x mb-2">{{$products_count ?? 0}}</span>
                                <span class="text-gray-500 fw-semibold fs-6">Total Products</span>
                            </div>
                        </div>
                    </div>
                    <!--end::Products-->
                </div>
                <!--end::Main Stats-->
                
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
@endsection

@push('styles')
<style>
    .hover-elevate-up {
        transition: all 0.3s ease;
    }
    .hover-elevate-up:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    .shadow-sm {
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .card-flush {
        border: none;
    }
</style>
@endpush
