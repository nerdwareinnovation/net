@extends('frontend.partials.master')

@section('title', 'Never Ending Trails')

@section('content')
<div class="main_slider js_height">
           <div class="slider_wrap" id="main_slider_wrap">
               @foreach($banners as $index => $banner)
               <div class="slide">
                   <div class="bg-img" style="background-image: url('{{$banner->image ? asset($banner->image) : asset('assets/images/main-banner.webp')}}')"></div>
                   <div class="wrap">
                       <div class="wrap_float js_height">
                           <div class="slide_content">
                               <div class="title_wrap">
                                   <h2 class="slide_title">{{$banner->title}}</h2>
                               </div>
                               @if($banner->short_description)
                               <p class="text">
                                   {{$banner->short_description}}
                               </p>
                               @endif
                               @if($banner->button_text && $banner->button_url)
                               <div class="buttons">
                                   <a href="{{$banner->button_url}}" class="btn button">{{$banner->button_text}}</a>
                               </div>
                               @endif
{{--                               @if(isset($banners[$index + 1]))--}}
{{--                               <div class="next_title">{{$banners[$index + 1]->title}}</div>--}}
{{--                               @endif--}}
                           </div>
                       </div>
                   </div>
               </div>
               @endforeach
           </div>
           <div class="arrows">
               <div class="arrow prev"></div>
               <div class="arrow next"></div>
           </div>
       </div>
       @if(count($sliderItems) > 0)
       <div class="most_popular" style="padding-top: 40px;">
           <div class="wrap">
               <div class="wrap_float">
                   <div class="title_wrap" style="display: none;">
                       <h2 class="title">Specials</h2>
                       <p class="subtitle">
                           Latest From Never Ending Trails
                       </p>
                       <div class="controls">
                           <a href="#" class="link">View All</a>
                           <div class="arrows">
                               <div class="arrow prev"></div>
                               <div class="arrow next"></div>
                           </div>
                       </div>
                   </div>
                   <div class="section_content">
                       <div class="tour-slider" id="tour-slider">
                           @php
                               $getFirstGalleryChildImage = function($childImages) {
                                   if (!$childImages || !is_array($childImages)) {
                                       return null;
                                   }
                                   foreach ($childImages as $image) {
                                       $path = is_array($image) ? ($image['url'] ?? null) : $image;
                                       if ($path) {
                                           return $path;
                                       }
                                   }
                                   return null;
                               };
                           @endphp
                           @foreach($sliderItems as $sliderItem)
                           <div class="tour_item_wrapper">
                               @php
                                   $item = $sliderItem['item'];
                                   $image = '';
                                   $title = '';
                                   $description = '';
                                   $link = '#';
                                   $date = '';
                                   
                                   if($sliderItem['type'] == 'story') {
                                       $image = $item->thumbnail ?? (is_array($item->story_images) && count($item->story_images) > 0 ? $item->story_images[0] : 'assets/images/specials/1.webp');
                                       $title = $item->title;
                                       $description = Str::limit(strip_tags($item->description ?? ''), 120);
                                       $link = route('front.story.detail', $item->slug);
                                       $date = $item->created_at->format('M d, Y');
                                   } elseif($sliderItem['type'] == 'film') {
                                       $image = $item->film_poster ?? 'assets/images/specials/1.webp';
                                       $title = $item->title;
                                       $description = Str::limit(strip_tags($item->synopsis ?? $item->description ?? ''), 120);
                                       $link = route('front.films');
                                       $date = $item->release_date ? \Carbon\Carbon::parse($item->release_date)->format('M d, Y') : '';
                                   } elseif($sliderItem['type'] == 'gallery') {
                                       $firstChildImage = $getFirstGalleryChildImage($item->child_images ?? []);
                                       $image = $item->thumbnail ?? ($firstChildImage ?: 'assets/images/specials/1.webp');
                                       $title = $item->title;
                                       $description = Str::limit(strip_tags($item->description ?? ''), 80);
                                       $link = route('front.gallery');
                                       $date = $item->created_at->format('M d, Y');
                                   }
                               @endphp
                               <a href="{{$link}}" class="tour_item" style="background-image: url('{{asset($image)}}')">
                                   <div class="shadow js-shadow" style="background-image: url('{{asset($image)}}')"></div>
                               </a>
                               <div class="tour_item_bottom">
                                   <h3 class="_title">
                                       <a href="{{$link}}" style="color: inherit; text-decoration: none;">{{$title}}</a>
                                   </h3>
                                   @if($description)
                                   <p class="_description">{{$description}}</p>
                                   @endif
                                   @if($date)
                                   <div class="_info">
                                       <div class="_info_left">
                                           <div class="cost">
                                               <svg class="date-icon" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                   <path d="M7 0C3.13 0 0 3.13 0 7C0 10.87 3.13 14 7 14C10.87 14 14 10.87 14 7C14 3.13 10.87 0 7 0ZM7 12.6C4.06 12.6 1.6 10.14 1.6 7.2C1.6 4.26 4.06 1.8 7 1.8C9.94 1.8 12.4 4.26 12.4 7.2C12.4 10.14 9.94 12.6 7 12.6ZM7.7 3.5H6.3V7.7L9.45 9.35L10.05 8.15L7.7 6.95V3.5Z" fill="currentColor"/>
                                               </svg>
                                               <span>{{$date}}</span>
                                           </div>
                                       </div>
                                   </div>
                                   @endif
                               </div>
                           </div>
                           @endforeach
                       </div>
                   </div>
               </div>
           </div>
       </div>
       @endif
        @if(@$homepageSettings && @$homepageSettings->vimeo_video_id)
        <!-- Vimeo Fullscreen Player Section -->
        <div class="vimeo-fullscreen-section">
            <div class="vimeo-container">
                <div class="vimeo-wrapper" id="vimeo-player-wrapper">
                    <div class="vimeo-player" id="vimeo-player">
                        <iframe
                                src="https://player.vimeo.com/video/{{$homepageSettings->vimeo_video_id}}?autoplay=1&loop=1&muted=1&controls=0&background=1&byline=0&title=0"
                                frameborder="0"
                                allow="autoplay; fullscreen; picture-in-picture"
                                allowfullscreen
                                id="vimeo-iframe">
                        </iframe>
                    </div>
                </div>
                @if(count($vimeoFilms) > 0)
                <div class="vimeo-poster-wrapper">
                    <div class="vimeo-poster-slider" id="vimeo-poster-slider">
                        @foreach($vimeoFilms as $film)
                        <div class="vimeo-poster-slide">
                            <div class="vimeo-poster">
                                <img src="{{$film->film_poster ? asset($film->film_poster) : asset('assets/images/specials/1.webp')}}" alt="{{$film->title}} Film Poster" class="vimeo-poster-image">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="vimeo-overlay" id="vimeo-overlay">
                    <div class="vimeo-content">
                        <h2 class="vimeo-title">{{@$homepageSettings->vimeo_title ?? 'Dive Into Our Films'}}</h2>
                        @if(@$homepageSettings->vimeo_description)
                        <p class="vimeo-subtitle">{{@$homepageSettings->vimeo_description}}</p>
                        @endif
                        @if(@$homepageSettings->vimeo_button_text && @$homepageSettings->vimeo_button_url)
                        <a href="{{@$homepageSettings->vimeo_button_url}}" class="btn vimeo-button-fixed" id="explore-films-btn">{{@$homepageSettings->vimeo_button_text}}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
       @if(count($contentItems) > 0)
       <div class="page_body" style="padding-top: 30px; padding-bottom: 30px;">
           <div class="wrap">
               <div class="wrap_float">
                   <div class="title_wrap" style="display: none">
                       <h2 class="title">Latest Stories</h2>
                   </div>
                   <div class="posts">
                           @foreach($contentItems as $contentItem)
                       @php
                           $item = $contentItem['item'];
                           $image = '';
                           $title = '';
                           $description = '';
                           $link = '#';
                           
                           if($contentItem['type'] == 'story') {
                               $image = $item->thumbnail ?? (is_array($item->story_images) && count($item->story_images) > 0 ? $item->story_images[0] : 'assets/images/specials/3.webp');
                               $title = $item->title;
                               $description = Str::limit(strip_tags($item->description ?? ''), 120);
                               $link = route('front.story.detail', $item->slug);
                           } elseif($contentItem['type'] == 'film') {
                               $image = $item->film_poster ?? 'assets/images/specials/3.webp';
                               $title = $item->title;
                               $description = Str::limit(strip_tags($item->synopsis ?? $item->description ?? ''), 120);
                               $link = route('front.films');
                           } elseif($contentItem['type'] == 'gallery') {
                               $firstChildImage = $getFirstGalleryChildImage($item->child_images ?? []);
                               $image = $item->thumbnail ?? ($firstChildImage ?: 'assets/images/specials/3.webp');
                               $title = $item->title;
                               $description = Str::limit(strip_tags($item->description ?? ''), 120);
                               $link = route('front.gallery');
                           }
                       @endphp
                       <div class="latest_stories_item_wrapper">
                           <a href="{{$link}}" class="tour_item" style="background-image: url('{{asset($image)}}')">
                               <div class="shadow js-shadow" style="background-image: url('{{asset($image)}}')"></div>
                           </a>
                           <div class="tour_item_bottom">
                               <h3 class="_title">
                                   <a href="{{$link}}" style="color: inherit; text-decoration: none;">{{$title}}</a>
                               </h3>
                               @if($description)
                               <p class="_description">{{$description}}</p>
                               @endif
                           </div>
                       </div>
                       @endforeach
                   </div>
               </div>
           </div>
       </div>
       @endif

    </div>
    
    @if(@$homepageSettings && (@$homepageSettings->featured_story_banner_image || @$homepageSettings->featured_story_title))
    <!-- Hero Banner Section -->
    <div class="hero-banner-section" style="margin-top: 20px;">
        <div class="hero-banner-wrapper">
            <figure class="hero-banner-image">
                <img src="{{@$homepageSettings->featured_story_banner_image ? asset(@$homepageSettings->featured_story_banner_image) : asset('assets/images/landscape-photo.webp')}}" alt="Featured Story" class="hero-banner-img">
            </figure>
            <div class="hero-banner-content">
                <header class="hero-banner-header">
                    @if(@$homepageSettings->featured_story_title)
                    <h2 class="hero-banner-title">
                        @if(@$homepageSettings->featured_story_button_url)
                        <a href="{{@$homepageSettings->featured_story_button_url}}">{{@$homepageSettings->featured_story_title}}</a>
                        @else
                        {{@$homepageSettings->featured_story_title}}
                        @endif
                    </h2>
                    @endif
                    @if(@$homepageSettings->featured_story_description)
                    <div class="hero-banner-lead">
                        <p>{{@$homepageSettings->featured_story_description}}</p>
                        @if(@$homepageSettings->featured_story_button_text && @$homepageSettings->featured_story_button_url)
                        <p><a class="hero-banner-link" href="{{@$homepageSettings->featured_story_button_url}}">{{@$homepageSettings->featured_story_button_text}}</a></p>
                        @endif
                    </div>
                    @endif
                </header>
            </div>
        </div>
    </div>
    @endif

    <!-- Ad Banner Section -->
    <div class="ad-banner-section" style="display: none">
        <div class="wrap">
            <div class="wrap_float">
                <div class="ad-banner">
                    <img src="{{asset('assets/images/ad.jpeg')}}" alt="Advertisement" class="ad-banner-image" style="height: 195px; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">

<div class="subscribe_section" style="display: none">
           <div class="wrap">
               <div class="wrap_float">
                   <div class="subscribe_block" style="background-image: url({{asset('assets/images/banner.jpg')}})">
                       <div class="left">
                           <h2 class="_title">Newsletter</h2>
                           <p class="_subtitle">Sign up to receive the latest stories</p>
                       </div>
                       <div class="right">
                           <div class="input_wrap select_wrap">
                               <select>
                                   <option value="Destination" disabled selected>Destination</option>
                                   <option value="United States">United States</option> 
                                    <option value="United Kingdom">United Kingdom</option> 
                                    <option value="Afghanistan">Afghanistan</option>
                               </select>
                           </div>
                           <div class="input_wrap">
                               <input type="email" class="input" placeholder="Email">
                           </div>
                           <button class="submit button"><span>Subscribe</span></button>
                       </div>
                   </div>
               </div>
           </div>
       </div>
        <div class="gallery-page" style="display: none;">
            <div class="wrap">
                <div class="wrap_float">
                    <div class="gallery-page-head">
                        <h1 class="title">Explore Our Gallery</h1>
<!--                        <div class="select_wrap">-->
<!--                            <select>-->
<!--                                <option value="Destination" disabled selected>Destination</option>-->
<!--                                <option value="United States">United States</option>-->
<!--                                <option value="Zimbabwe">Zimbabwe</option>-->
<!--                            </select>-->
<!--                        </div>-->
                    </div>
                    <div class="gallery-page-body">
                        <div class="gallery-list">
                            <a href="gallery-single.html" class="gallery-item">
                                <div class="top">
                                    <p class="country">Subtitle</p>
                                    <p class="title">A New Beginning</p>
                                </div>
                                <div class="images">
                                    <div class="scroll">
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner1.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner2.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner3.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/stories.jpg')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="gallery-single.html" class="gallery-item">
                                <div class="top">
                                    <p class="country">Subtitle</p>
                                    <p class="title">Coming Home(Trails of Dolpa)</p>
                                </div>
                                <div class="images">
                                    <div class="scroll">
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner1.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner2.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner3.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/stories.jpg')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="gallery-single.html" class="gallery-item">
                                <div class="top">
                                    <p class="country">Subtitle</p>
                                    <p class="title">A New Beginning</p>
                                </div>
                                <div class="images">
                                    <div class="scroll">
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner1.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner2.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner3.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/stories.jpg')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="gallery-single.html" class="gallery-item">
                                <div class="top">
                                    <p class="country">Subtitle</p>
                                    <p class="title">Coming Home(Trails of Dolpa)</p>
                                </div>
                                <div class="images">
                                    <div class="scroll">
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner1.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner2.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner3.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/banner.jpg')}}" alt="">
                                        </div>
                                        <div class="img">
                                            <img src="{{asset('assets/images/stories.jpg')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="btn_wrap load_btn_wrap">
                            <a class="load_more button"><span>Load more</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@push('scripts')
    <!-- Vimeo Player Script -->
    <script>
        (function() {
            var overlay = document.getElementById('vimeo-overlay');
            var exploreBtn = document.getElementById('explore-films-btn');
            
            // Initialize poster slider
            if (typeof jQuery !== 'undefined' && jQuery.fn.slick) {
                jQuery(document).ready(function($) {
                    $('#vimeo-poster-slider').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 4000,
                        arrows: false,
                        dots: false,
                        fade: true,
                        speed: 800,
                        infinite: true,
                        pauseOnHover: false,
                        pauseOnFocus: false,
                        cssEase: 'ease-in-out'
                    });
                });
            }
            
            // Hide title and subtitle on button click
            function hideOverlayContent() {
                var title = document.querySelector('.vimeo-title');
                var subtitle = document.querySelector('.vimeo-subtitle');
                
                if (title) {
                    title.style.opacity = '0';
                    title.style.transition = 'opacity 0.5s ease';
                }
                if (subtitle) {
                    subtitle.style.opacity = '0';
                    subtitle.style.transition = 'opacity 0.5s ease';
                }
            }
            
            // Button click handler
            if (exploreBtn) {
                exploreBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    hideOverlayContent();
                });
            }
        })();
    </script>
@endpush
@endsection
