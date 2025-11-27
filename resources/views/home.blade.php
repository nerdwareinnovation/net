@extends('backend.partials.master')

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                
                <!--begin::Welcome Banner-->
                <div class="card bg-gradient-primary mb-8" style="background: linear-gradient(135deg, #050505 0%, #0a0f1f 45%, #1c2a3a 100%);">
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

                @php
                    $stats = [
                        [
                            'count' => $stories_count ?? 0,
                            'label' => 'Total Stories',
                            'icon' => 'ki-book-open',
                            'bg' => 'bg-light-primary',
                            'badge' => 'badge-light-primary',
                            'color' => 'text-primary',
                        ],
                        [
                            'count' => $gallery_count ?? 0,
                            'label' => 'Total Photo Album',
                            'icon' => 'ki-picture',
                            'bg' => 'bg-light-info',
                            'badge' => 'badge-light-info',
                            'color' => 'text-info',
                        ],
                        [
                            'count' => $film_count ?? 0,
                            'label' => 'Total Films',
                            'icon' => 'ki-video',
                            'bg' => 'bg-light-success',
                            'badge' => 'badge-light-success',
                            'color' => 'text-success',
                        ],
                          [
                            'count' => $products_count ?? 0,
                            'label' => 'Total Products',
                            'icon' => 'ki-basket',
                            'bg' => 'bg-light-warning',
                            'badge' => 'badge-light-warning',
                            'color' => 'text-warning',
                        ],
                    ];
                @endphp


                <div class="row g-5 g-xl-8 mb-5 mb-xl-8">
                    @foreach($stats as $item)
                        <div class="col-sm-6 col-xl-3">
                            <div class="card card-flush h-100 shadow-sm hover-elevate-up">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex align-items-center justify-content-between mb-5">
                                        <div class="symbol symbol-50px {{ $item['bg'] }}">
                                            <i class="ki-outline {{ $item['icon'] }} fs-2x {{ $item['color'] }}"></i>
                                        </div>
                                        <span class="{{ $item['badge'] }} fs-7 fw-bold">Active</span>
                                    </div>

                                    <span class="text-gray-900 fw-bold fs-2x mb-2">{{ $item['count'] }}</span>
                                    <span class="text-gray-500 fw-semibold fs-6">{{ $item['label'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


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
