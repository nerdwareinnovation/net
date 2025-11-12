<div class="footer">
    <div class="wrap">
        <div class="wrap_float">
            <div class="footer_top">
                <div class="left">
                    <div class="col">
                        <div class="_title m_title">Quick Links</div>
                        <ul>
                            <li><a href="{{route('front.stories')}}">Stories</a></li>
                            <li><a href="{{route('front.films')}}">Films</a></li>
                            <li><a href="{{route('front.gallery')}}">Gallery</a></li>
                        </ul>
                    </div>
                    <div class="col">
                        <div class="_title m_title" style="opacity: 0">Page</div>
                        <ul>
                            <li><a href="{{route('front.about')}}">About</a></li>
                            <li><a href="{{route('front.contact')}}">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="right">
                    <div class="_title">Reach Out</div>
                    <div class="contacts_info">
                        @if(@$site_settings['contact_number'])
                        <div class="tel">
                            <a href="tel:{{@$site_settings['contact_number']}}">{{@$site_settings['contact_number']}}</a>
                        </div>
                        @endif
                        @if(@$site_settings['email'])
                        <div class="email">
                            <a href="mailto:{{@$site_settings['email']}}">{{@$site_settings['email']}}</a>
                            <p>For any queries.</p>
                        </div>
                        @endif
                        @if(@$site_settings['address'])
                        <div class="address">
                            {{@$site_settings['address']}}
                        </div>
                        @endif
                    </div>
                    <div class="socials social-links">
                        @if(@$site_settings['fb_url'])
                        <a href="{{@$site_settings['fb_url']}}" target="_blank" rel="noopener noreferrer" class="link facebook"><span></span></a>
                        @endif
                        @if(@$site_settings['insta_url'])
                        <a href="{{@$site_settings['insta_url']}}" target="_blank" rel="noopener noreferrer" class="link instagram"><span></span></a>
                        @endif
                        @if(@$site_settings['twitter_url'])
                        <a href="{{@$site_settings['twitter_url']}}" target="_blank" rel="noopener noreferrer" class="link twitter"><span></span></a>
                        @endif
                        @if(@$site_settings['linkedin_url'])
                        <a href="{{@$site_settings['linkedin_url']}}" target="_blank" rel="noopener noreferrer" class="link linkedin"><span></span></a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="footer_bottom">
                <div class="left">
                    <a href="#" style="color: rgba(255, 255, 255, 0.8)">Privacy Policy</a>
                </div>
                <div class="right">
                    {!! @$site_settings['footer_description'] !!}
                </div>
            </div>
        </div>
    </div>
</div>
