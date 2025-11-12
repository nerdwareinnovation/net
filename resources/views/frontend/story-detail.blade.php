@extends('frontend.partials.master')

@section('title', ($story->title ?? 'Story Detail') . ' - Never Ending Trails')

@section('content')
        <!-- Story Detail Content -->
        <div class="story-detail-section" style="padding-top: 0px;" id="story-gallery-container">
            
            <!-- 1. Full Width Banner Image -->
            <div class="story-banner-image">
                @php
                    $bannerImage = $story->thumbnail ?? (is_array($story->story_images) && count($story->story_images) > 0 ? $story->story_images[0] : 'assets/images/specials/1.webp');
                @endphp
                <a href="{{asset($bannerImage)}}" class="lightgallery-item story-gallery-item" data-src="{{asset($bannerImage)}}">
                    <img src="{{asset($bannerImage)}}" alt="{{$story->title}}">
                </a>
            </div>

            <!-- 2. Story Title and Meta -->
            <div class="story-header">
                <div class="wrap">
                    <div class="wrap_float">
                        <h1 class="story-title">{{$story->title}}</h1>
                        <div class="story-meta">
                            <span class="story-author">By {{$story->user->name ?? 'Admin'}}</span>
                            <span class="story-date">{{$story->created_at->format('F d, Y')}}</span>
                            <span class="story-category">{{$story->category->name ?? 'Uncategorized'}}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Story Description -->
            @if($story->description)
            <div class="story-content">
                <div class="wrap">
                    <div class="wrap_float">
                        <div class="story-description">
                            {!! $story->description !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Story Images Slider -->
            @php
                // Show all story images in the slider
                $sliderImages = [];
                if (is_array($story->story_images) && count($story->story_images) > 0) {
                    $sliderImages = array_filter($story->story_images, function($img) {
                        return !empty($img);
                    });
                }
            @endphp
            
            @if(count($sliderImages) > 0)
            <div class="story-images-slider-section">
                <div class="wrap">
                    <div class="wrap_float">
                        <div class="story-images-slider" id="story-images-slider">
                            @foreach($sliderImages as $index => $image)
                            <div class="story-slide">
                                <a href="{{asset($image)}}" class="lightgallery-item story-gallery-item" data-src="{{asset($image)}}">
                                    <img src="{{asset($image)}}" alt="{{$story->title}} - Image {{$index + 1}}">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- 8. You Might Be Interested In Section -->
            @if($relatedStories && $relatedStories->count() > 0)
            <div class="related-stories-section" style="margin-top: 0">
                <div class="wrap">
                    <div class="wrap_float">
                        <h2 class="related-stories-title">You Might Be Interested In</h2>
                        <div class="related-stories-grid">
                            @foreach($relatedStories as $relatedStory)
                            <div class="related-story-item">
                                <a href="{{route('front.story.detail', $relatedStory->slug)}}" class="related-story-link">
                                    <div class="related-story-image">
                                        <img src="{{$relatedStory->thumbnail ? asset($relatedStory->thumbnail) : asset('assets/images/specials/4.webp')}}" alt="{{$relatedStory->title}}">
                                    </div>
                                    <div class="related-story-content">
                                        <h3 class="related-story-title">{{$relatedStory->title}}</h3>
                                        <div class="related-story-meta">
                                            <span class="related-story-category">{{$relatedStory->category->name ?? 'Uncategorized'}}</span>
                                            <span class="related-story-date">{{$relatedStory->created_at->format('M d')}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
@endsection

@push('styles')
<style>
    .story-images-slider-section {
        padding: 60px 0;
        background: #f8f9fa;
    }
    
    .story-images-slider {
        width: 100%;
        overflow: hidden;
    }
    
    .story-slide {
        width: 100%;
        height: 600px;
        position: relative;
    }
    
    .story-slide a {
        display: block;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .story-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    
    .story-images-slider .slick-dots {
        bottom: 20px;
        z-index: 10;
    }
    
    .story-images-slider .slick-dots li button:before {
        color: #fff;
        font-size: 12px;
        opacity: 0.5;
    }
    
    .story-images-slider .slick-dots li.slick-active button:before {
        opacity: 1;
    }
    
    @media (max-width: 768px) {
        .story-slide {
            height: 400px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    (function() {
        if (typeof jQuery !== 'undefined' && jQuery.fn.slick) {
            jQuery(document).ready(function($) {
                // Initialize Slick Slider for story images
                $('#story-images-slider').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    arrows: true,
                    dots: true,
                    fade: true,
                    speed: 600,
                    infinite: true,
                    pauseOnHover: true,
                    pauseOnFocus: false,
                    cssEase: 'ease-in-out',
                    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>'
                });
                
                // Initialize Light Gallery for all story images (banner + slider images)
                // Group all images together so clicking any image opens gallery with all images
                if ($.fn.lightGallery) {
                    // Initialize on the container that includes both banner and slider
                    $('#story-gallery-container').lightGallery({
                        selector: '.story-gallery-item',
                        mode: 'lg-slide',
                        speed: 600,
                        download: false,
                        share: false,
                        actualSize: true,
                        enableTouch: true,
                        enableDrag: true
                    });
                }
            });
        }
    })();
</script>
@endpush
