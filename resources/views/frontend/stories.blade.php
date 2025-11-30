@extends('frontend.partials.master')

@section('title', 'Stories - Never Ending Trails')

@section('content')
<!-- Welcome Section -->
        <div class="section" style="padding-bottom: 30px;">
            <div style="opacity: 1;" class="container">
                <div class="text-box">
                    <h1 class="heading large">Welcome to Never Ending Trails, we write about trails, people and culture</h1>
                </div>
                <div class="divider-line inset"></div>
            </div>
        </div>

        <!-- Stories Listing Section -->
        <div class="stories-listing-section" style="padding-top: 0px; padding-bottom: 80px;">
            <div class="wrap" id="stories-wrap" style="padding: 0 50px 0 50px; max-width: none;">
                <div class="wrap_float">
                    <div class="blog-grid">
                        <div class="row">
                            <!-- Featured Column -->
                            <div class="col-md-6">
                                <div class="grid-column">
                                    <div class="section-title-wrapper">
                                        <h2 class="heading small">Featured</h2>
                                        <div class="spacer _16"></div>
                                    </div>
                                    <div class="posts-wrapper featured">
                                        <div class="posts-grid featured">
                                            @forelse($featuredStories as $story)
                                            <div class="post-item featured-item">
                                                <a href="{{route('front.story.detail', $story->slug)}}" class="post-link">
                                                    <div class="post-item-content">
                                                        <div class="post-item-image-wrapper">
                                                            <img src="{{$story->thumbnail ? asset($story->thumbnail) : asset('assets/images/stories2.jpg')}}" alt="{{$story->title}}" class="post-item-image">
                                                        </div>
                                                        <div class="post-item-top">
                                                            <div class="divider-line primary-colour"></div>
                                                            <div class="post-top-details-wrapper">
                                                                <div class="post-detail-tag">{{$story->category->name ?? 'Uncategorized'}}</div>
                                                                <div class="post-detail-tag">{{$story->created_at->format('M d')}}</div>
                                                            </div>
                                                        </div>
                                                        <div class="post-item-bottom">
                                                            <h2 class="heading large">{{$story->title}}</h2>
                                                            <div class="text-color-4">
                                                                <div class="paragraph">{{Str::limit(strip_tags($story->description ?? ''), 150)}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            @empty
                                            <div class="post-item featured-item">
                                                <p class="text-muted">No featured stories available.</p>
                                            </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Recent Column -->
                            <div class="col-md-6">
                                <div class="grid-column">
                                    <div class="section-title-wrapper">
                                        <h2 class="heading small">Recent</h2>
                                        <div class="spacer _16"></div>
                                    </div>
                                    <div class="posts-wrapper">
                                        <div class="posts-grid recent">
                                            @forelse($regularStories as $story)
                                            <div class="post-item recent-item">
                                                <a href="{{route('front.story.detail', $story->slug)}}" class="post-link">
                                                    <div class="post-item-content">
                                                        <div class="post-item-image-wrapper">
                                                            <img src="{{$story->thumbnail ? asset($story->thumbnail) : asset('assets/images/specials/3.webp')}}" alt="{{$story->title}}" class="post-item-image">
                                                        </div>
                                                        <div class="post-item-top">
                                                            <div class="divider-line primary-colour"></div>
                                                            <div class="post-top-details-wrapper">
                                                                <div class="post-detail-tag">{{$story->category->name ?? 'Uncategorized'}}</div>
                                                                <div class="post-detail-tag">{{$story->created_at->format('M d')}}</div>
                                                            </div>
                                                        </div>
                                                        <div class="post-item-bottom">
                                                            <h2 class="heading regular">{{$story->title}}</h2>
                                                            <div class="text-color-4">
                                                                <div class="paragraph small">{{Str::limit(strip_tags($story->description ?? ''), 120)}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            @empty
                                            <div class="post-item recent-item">
                                                <p class="text-muted">No stories available.</p>
                                            </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
