@extends('frontend.partials.master')

@section('title', 'About - Never Ending Trails')

@push('styles')
<style>
    .about-banner-section {
        margin-top: 0 !important;
        position: relative;
    }
    body:has(.about-banner-section) .container {
        padding-top: 0;
    }
</style>
@endpush

@section('content')
<!-- About Section with Video Banner -->
        <div class="about-banner-section">
            <!-- Full Width Video Background -->
            <div class="about-video-background">
                <div class="vimeo-wrapper" id="vimeo-player-wrapper">
                    <div class="vimeo-player" id="vimeo-player">
                        @if(@$aboutSettings && @$aboutSettings->vimeo_video_id)
                            <iframe
                                    src="https://player.vimeo.com/video/{{$aboutSettings->vimeo_video_id}}?autoplay=1&loop=1&muted=1&controls=0&background=1&byline=0&title=0"
                                    frameborder="0"
                                    allow="autoplay; fullscreen; picture-in-picture"
                                    allowfullscreen
                                    id="vimeo-iframe">
                            </iframe>
                        @else
                            <iframe
                                    src="https://player.vimeo.com/video/120666341?autoplay=1&loop=1&muted=1&controls=0&background=1&byline=0&title=0"
                                    frameborder="0"
                                    allow="autoplay; fullscreen; picture-in-picture"
                                    allowfullscreen
                                    id="vimeo-iframe">
                            </iframe>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Glass Card Overlay -->
            <div class="about-glass-card">
                <div class="about-glass-content">
                    <div class="about-banner-title-wrapper">
                        <h1 class="about-banner-title">{{@$aboutSettings->page_title ?? 'Never Ending Trails'}}</h1>
                        <div class="about-banner-divider"></div>
                    </div>
                    <p class="about-banner-tagline">{{@$aboutSettings->subtitle ?? 'Sharing stories of adventure, exploration, and the profound connections we make with nature and cultures around the world'}}</p>
                </div>
            </div>
        </div>

        <!-- Description Section After Video -->
{{--        @if(@$aboutSettings && @$aboutSettings->description)--}}
        @if(!empty($aboutSettings?->description))
        <div class="about-description-section">
            <div class="wrap">
                <div class="wrap_float">
                    <div class="about-description">
                        <div class="about-description-item">
                            {!! @$aboutSettings->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Dynamic Sections -->
        @foreach($sections as $index => $section)
            <div class="about-mission-section {{$index % 2 == 1 ? 'about-vision-section' : ''}}">
                <div class="wrap">
                    <div class="wrap_float">
                        <div class="{{$index % 2 == 1 ? 'vision-content-wrapper' : 'mission-content-wrapper'}}">
                            @if($index % 2 == 0)
                                <!-- Image on left for even sections -->
                                @if($section->image)
                                <div class="mission-image">
                                    <img src="{{asset($section->image)}}" alt="{{$section->title}}">
                                </div>
                                @endif
                                <div class="mission-text">
                                    <h2 class="mission-title">{{$section->title}}</h2>
                                    <p>{!! $section->description !!}</p>
                                </div>
                            @else
                                <!-- Image on right for odd sections -->
                                <div class="vision-text">
                                    <h2 class="vision-title">{{$section->title}}</h2>
                                    <p>{!! $section->description !!}</p>
                                </div>
                                @if($section->image)
                                <div class="vision-image">
                                    <img src="{{asset($section->image)}}" alt="{{$section->title}}">
                                </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
@endsection

