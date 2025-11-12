@extends('frontend.partials.master')

@section('title', 'Contact - Never Ending Trails')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .contact-banner-section {
        margin-top: 0 !important;
        position: relative;
        width: 100%;
        height: 80vh;
        min-height: 600px;
        overflow: hidden;
    }
    body:has(.contact-banner-section) .container {
        padding-top: 0;
    }
    
    .contact-banner-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{@$contactSettings && @$contactSettings->banner_image ? asset($contactSettings->banner_image) : asset("assets/images/main-banner.webp")}}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: 1;
    }
    
    .contact-banner-background::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.6) 100%);
    }
    
    .contact-content-section {
        padding: 20px 0;
        background: #f8f9fa;
    }
    
    .contact-wrapper {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 30px;
        margin: 0 auto;
    }
    
    .contact-info {
        background: #ffffff;
        padding: 50px 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        height: fit-content;
    }
    
    .contact-info-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .contact-info-item {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 35px;
    }
    
    .contact-info-item:last-child {
        margin-bottom: 0;
    }
    
    .contact-info-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        /* border: 2px solid #e0e0e0; */
        flex-shrink: 0;
    }
    
    .contact-info-icon i {
        font-size: 24px;
        color: #666;
    }
    
    .contact-info-content {
        flex: 1;
    }
    
    .contact-info-label {
        font-size: 13px;
        font-weight: 600;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }
    
    .contact-info-value {
        font-size: 18px;
        color: #1a1a1a;
        text-decoration: none;
        display: block;
        transition: color 0.3s ease;
        font-weight: 500;
    }
    
    .contact-info-value:hover {
        color: #333333;
    }
    
    .contact-form-wrapper {
        background: #ffffff;
        padding: 50px 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .contact-form-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .form-row .form-group {
        margin-bottom: 0;
    }
    
    .form-group {
        margin-bottom: 30px;
    }
    
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-input,
    .form-textarea {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #e0e0e0;
        border-radius: 0;
        font-size: 16px;
        color: #1a1a1a;
        transition: all 0.3s ease;
        font-family: inherit;
        background: #fafafa;
    }
    
    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #1a1a1a;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(26, 26, 26, 0.1);
    }
    
    .form-textarea {
        resize: vertical;
        min-height: 140px;
    }
    
    .form-submit {
        display: inline-block;
        color: #000000;
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 2px;
        padding: 14px 42px;
        border: 1px solid #000000;
        background: transparent;
        transition: all 0.4s ease;
        margin-top: 15px;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        width: auto;
        font-family: inherit;
    }
    
    .form-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: #000000;
        transition: left 0.4s ease;
        z-index: -1;
    }
    
    .form-submit:hover {
        color: #ffffff;
        border-color: #000000;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }
    
    .form-submit:hover::before {
        left: 0;
    }
    
    @media (max-width: 968px) {
        .contact-wrapper {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
        
        .contact-banner-title {
            font-size: 36px;
        }
        
        .contact-glass-card {
            padding: 40px 30px;
        }
    }
    
    @media (max-width: 768px) {
        .contact-banner-section {
            height: 50vh;
            min-height: 400px;
        }
        
        .contact-banner-title {
            font-size: 28px;
        }
        
        .contact-banner-tagline {
            font-size: 16px;
        }
        
        .contact-content-section {
            padding: 10px 0;
        }
        
        .contact-info,
        .contact-form-wrapper {
            padding: 40px 30px;
        }
    }
</style>
@endpush

@section('content')
<!-- Contact Banner Section -->
        <div class="contact-banner-section">
            <div class="contact-banner-background"></div>
            
            <!-- Glass Card Overlay -->
            <div class="about-glass-card">
                <div class="about-glass-content">
                    <div class="about-banner-title-wrapper">
                        <h1 class="about-banner-title">{{@$contactSettings->title ?? 'Reach Out to Us'}}</h1>
                        <div class="about-banner-divider"></div>
                    </div>
                    <p class="about-banner-tagline">{{@$contactSettings->short_description ?? 'We\'d love to hear from you. Get in touch and let\'s start a conversation.'}}</p>
                </div>
            </div>
        </div>

        <!-- Contact Content Section -->
        <div class="contact-content-section">
            <div class="wrap">
                <div class="wrap_float">
                    <div class="contact-wrapper" style="max-width: none;">
                        <div class="contact-info">
                            <h2 class="contact-info-title">Contact Information</h2>
                            @if(@$site_settings['email'])
                            <div class="contact-info-item">
                                <div class="contact-info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-info-content">
                                    <div class="contact-info-label">Email</div>
                                    <a href="mailto:{{@$site_settings['email']}}" class="contact-info-value">{{@$site_settings['email']}}</a>
                                </div>
                            </div>
                            @endif
                            @if(@$site_settings['contact_number'])
                            <div class="contact-info-item">
                                <div class="contact-info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="contact-info-content">
                                    <div class="contact-info-label">Phone</div>
                                    <a href="tel:{{@$site_settings['contact_number']}}" class="contact-info-value">{{@$site_settings['contact_number']}}</a>
                                </div>
                            </div>
                            @endif
                            @if(@$site_settings['address'])
                            <div class="contact-info-item">
                                <div class="contact-info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-info-content">
                                    <div class="contact-info-label">Address</div>
                                    <div class="contact-info-value">{{@$site_settings['address']}}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <div class="contact-form-wrapper">
                            <h2 class="contact-form-title">Send Us a Message</h2>
                            <form class="contact-form" action="{{route('front.contact.submit')}}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" id="name" name="name" class="form-input" placeholder="Enter your full name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email address" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Subject" class="form-label">Subject</label>
                                        <input type="text" id="Subject" name="Subject" class="form-input" placeholder="What is your inquiry about?">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" id="phone" name="phone" class="form-input" placeholder="Enter your contact number">
                                    </div>
                                </div>
                                <div class="form-group full-width">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea id="message" name="message" class="form-textarea" rows="6" placeholder="Please provide details about your inquiry or message" required></textarea>
                                </div>
                                <button type="submit" class="form-submit">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
