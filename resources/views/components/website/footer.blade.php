@php
    $site_setting = siteSetting();
    $site_name    = $site_setting?->name ?? config('app.name');
    $site_desc    = $site_setting?->description ?? __('lang.footer_tagline');
    $logo_black   = $site_setting?->getFirstMediaUrl('logo_black') ?: asset('logo.svg');

    $facebook  = $site_setting?->facebook_url  ?? null;
    $instagram = $site_setting?->instagram_url ?? null;
    $twitter   = $site_setting?->twitter_url   ?? null;
    $youtube   = $site_setting?->youtube_url   ?? null;
    $tiktok    = $site_setting?->tiktok_url    ?? null;
@endphp

<footer id="footer" class="site-footer">

    {{-- ===================== Top gradient bar ===================== --}}
    <div class="footer-topbar"></div>

    {{-- ===================== Main Content ===================== --}}
    <div class="footer-body">
        <div class="container">
            <div class="row gy-5">

                {{-- Brand Column --}}
                <div class="col-lg-4 col-md-12">
                    <a href="{{ route('home') }}" class="footer-logo d-inline-flex align-items-center gap-2 mb-4 text-decoration-none" wire:navigate>
                        <img src="{{ $logo_black }}" alt="{{ $site_name }}" class="footer-logo-img">
                        <span class="footer-brand-name">{{ $site_name }}</span>
                    </a>
                    <p class="footer-desc">{{ $site_desc }}</p>

                    {{-- Contact Info --}}
                    <ul class="footer-contact-list list-unstyled mt-4">
                        @if($site_setting?->address)
                            <li>
                                <span class="footer-contact-icon"><i class="bi bi-geo-alt-fill"></i></span>
                                <span>{{ $site_setting->address }}</span>
                            </li>
                        @endif
                        @if($site_setting?->phone)
                            <li>
                                <span class="footer-contact-icon"><i class="bi bi-telephone-fill"></i></span>
                                <span dir="ltr">{{ $site_setting->phone }}</span>
                            </li>
                        @endif
                        @if($site_setting?->email)
                            <li>
                                <span class="footer-contact-icon"><i class="bi bi-envelope-fill"></i></span>
                                <span>{{ $site_setting->email }}</span>
                            </li>
                        @endif
                    </ul>

                    {{-- Social Links --}}
                    @if($facebook || $instagram || $twitter || $youtube || $tiktok)
                        <div class="footer-social mt-4 d-flex gap-2">
                            @if($facebook)  <a href="{{ $facebook }}"  target="_blank" class="footer-social-btn" title="Facebook"> <i class="bi bi-facebook"></i></a>@endif
                            @if($instagram) <a href="{{ $instagram }}" target="_blank" class="footer-social-btn" title="Instagram"><i class="bi bi-instagram"></i></a>@endif
                            @if($twitter)   <a href="{{ $twitter }}"   target="_blank" class="footer-social-btn" title="Twitter">  <i class="bi bi-twitter-x"></i></a>@endif
                            @if($youtube)   <a href="{{ $youtube }}"   target="_blank" class="footer-social-btn" title="YouTube">  <i class="bi bi-youtube"></i></a>@endif
                            @if($tiktok)    <a href="{{ $tiktok }}"    target="_blank" class="footer-social-btn" title="TikTok">   <i class="bi bi-tiktok"></i></a>@endif
                        </div>
                    @endif
                </div>

                {{-- Spacer --}}
                <div class="col-lg-1 d-none d-lg-block"></div>

                {{-- Quick Links --}}
                <div class="col-lg-3 col-sm-6">
                    <h5 class="footer-heading">{{ __('lang.footer_column_company') }}</h5>
                    <ul class="footer-links list-unstyled">
                        <li><a href="{{ route('home') }}" wire:navigate>{{ __('lang.home') }}</a></li>
                        @auth
                            <li><a href="{{ route('my-courses.index') }}" wire:navigate>{{ __('lang.my_courses') }}</a></li>
                        @endauth
                        <li><a href="{{ route('pages.about') }}" wire:navigate>{{ __('lang.about_us') }}</a></li>
                    </ul>
                </div>

                {{-- Legal Links --}}
                <div class="col-lg-3 col-sm-6">
                    <h5 class="footer-heading">{{ __('lang.legal') }}</h5>
                    <ul class="footer-links list-unstyled">
                        <li><a href="{{ route('pages.privacy') }}" wire:navigate>{{ __('lang.privacy_policy') }}</a></li>
                        <li><a href="{{ route('pages.terms') }}" wire:navigate>{{ __('lang.terms_and_conditions') }}</a></li>
                        <li><a href="{{ route('pages.refund') }}" wire:navigate>{{ __('lang.refund_policy') }}</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    {{-- ===================== Bottom Bar ===================== --}}
    <div class="footer-bottom">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
                <p class="mb-0 footer-copyright">
                    {{ __('lang.footer_copyright', ['year' => now()->year, 'app_name' => $site_name]) }}
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('pages.privacy') }}" class="footer-bottom-link" wire:navigate>{{ __('lang.privacy_policy') }}</a>
                    <span class="text-secondary">·</span>
                    <a href="{{ route('pages.terms') }}" class="footer-bottom-link" wire:navigate>{{ __('lang.terms_and_conditions') }}</a>
                </div>
            </div>
        </div>
    </div>

</footer>

<style>
    /* ===================== Footer Reset ===================== */
    .site-footer {
        background-color: #0d0f14;
        color: #94a3b8;
        font-size: 14.5px;
        position: relative;
        overflow: hidden;
    }

    /* Subtle background pattern */
    .site-footer::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(ellipse 60% 50% at 80% 10%, color-mix(in srgb, var(--accent-color), transparent 85%) 0%, transparent 70%),
            radial-gradient(ellipse 40% 30% at 10% 80%, color-mix(in srgb, var(--accent-color), transparent 90%) 0%, transparent 70%);
        pointer-events: none;
    }

    /* ===================== Top gradient bar ===================== */
    .footer-topbar {
        height: 3px;
        background: linear-gradient(90deg, var(--accent-color) 0%, color-mix(in srgb, var(--accent-color), #00d4ff 50%) 50%, var(--accent-color) 100%);
        background-size: 200% 100%;
        animation: footerBarShimmer 4s linear infinite;
    }

    @keyframes footerBarShimmer {
        0%   { background-position: 0% 0; }
        100% { background-position: 200% 0; }
    }

    /* ===================== Body ===================== */
    .footer-body {
        padding: 60px 0 40px;
        position: relative;
        z-index: 1;
    }

    /* ===================== Logo ===================== */
    .footer-logo-img {
        width: 36px;
        height: 36px;
        object-fit: contain;
        border-radius: 8px;
    }

    .footer-brand-name {
        font-size: 20px;
        font-weight: 700;
        font-family: var(--heading-font);
        color: #f1f5f9;
        letter-spacing: .5px;
    }

    /* ===================== Description ===================== */
    .footer-desc {
        color: #64748b;
        line-height: 1.75;
        max-width: 340px;
    }

    /* ===================== Contact List ===================== */
    .footer-contact-list li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 10px;
        color: #94a3b8;
        line-height: 1.5;
    }

    .footer-contact-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: color-mix(in srgb, var(--accent-color), transparent 82%);
        color: var(--accent-color);
        font-size: 13px;
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* ===================== Social Buttons ===================== */
    .footer-social-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: color-mix(in srgb, var(--accent-color), transparent 85%);
        border: 1px solid color-mix(in srgb, var(--accent-color), transparent 70%);
        color: var(--accent-color);
        font-size: 15px;
        text-decoration: none;
        transition: background 0.25s, transform 0.25s, border-color 0.25s;
    }

    .footer-social-btn:hover {
        background: var(--accent-color);
        border-color: var(--accent-color);
        color: #fff;
        transform: translateY(-3px);
    }

    /* ===================== Headings ===================== */
    .footer-heading {
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #f1f5f9;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }

    .footer-heading::after {
        content: '';
        position: absolute;
        bottom: 0;
        inset-inline-start: 0;
        width: 28px;
        height: 2px;
        border-radius: 99px;
        background: var(--accent-color);
    }

    /* ===================== Links ===================== */
    .footer-links li {
        margin-bottom: 2px;
    }

    .footer-links a {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 0;
        color: #64748b;
        text-decoration: none;
        transition: color 0.2s, gap 0.2s;
        font-size: 14.5px;
    }

    .footer-links a::before {
        content: '→';
        font-size: 12px;
        color: var(--accent-color);
        opacity: 0;
        transform: translateX(-6px);
        transition: opacity 0.2s, transform 0.2s;
    }

    html[dir="rtl"] .footer-links a::before {
        content: '←';
        transform: translateX(6px);
    }

    .footer-links a:hover {
        color: #f1f5f9;
        gap: 10px;
    }

    .footer-links a:hover::before {
        opacity: 1;
        transform: translateX(0);
    }

    /* ===================== Bottom Bar ===================== */
    .footer-bottom {
        border-top: 1px solid rgba(255,255,255,.06);
        padding: 18px 0;
        position: relative;
        z-index: 1;
    }

    .footer-copyright {
        color: #475569;
        font-size: 13.5px;
    }

    .footer-bottom-link {
        color: #475569;
        text-decoration: none;
        font-size: 13.5px;
        transition: color 0.2s;
    }

    .footer-bottom-link:hover {
        color: var(--accent-color);
    }
</style>
