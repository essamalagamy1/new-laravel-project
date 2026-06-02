@php
    $site_setting = siteSetting();
    $logo_black = $site_setting?->getFirstMediaUrl('logo_black') ?: asset('logo.svg');
@endphp

{{-- =====================================================
     PREMIUM NAVIGATION & MOBILE DRAWER
     Fully responsive, robust RTL support
===================================================== --}}

<nav id="main-nav" class="main-nav-container" aria-label="Main navigation">

    {{-- DESKTOP LINKS --}}
    <ul class="nav-links-desktop d-none d-xl-flex">
        <li><a href="{{ route('home') }}" class="nav-link-item {{ request()->routeIs('home') ? 'active' : '' }}" wire:navigate>{{ __('lang.home') }}</a></li>
        @auth
            <li><a href="{{ route('my-courses.index') }}" class="nav-link-item {{ request()->routeIs('my-courses.*') ? 'active' : '' }}" wire:navigate>{{ __('lang.my_courses') }}</a></li>
        @endauth
        <li><a href="{{ route('pages.about') }}" class="nav-link-item {{ request()->routeIs('pages.about') ? 'active' : '' }}" wire:navigate>{{ __('lang.about_us') }}</a></li>
        <li><a href="{{ route('pages.privacy') }}" class="nav-link-item {{ request()->routeIs('pages.privacy') ? 'active' : '' }}" wire:navigate>{{ __('lang.privacy_policy') }}</a></li>
    </ul>

    {{-- DESKTOP ACTIONS (Right side) --}}
    <div class="nav-actions-desktop d-none d-xl-flex align-items-center">

        {{-- Lang Dropdown --}}
        <div class="dropdown custom-lang-dropdown">
            <button class="btn-lang-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-globe2"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'العربية' : 'English' }}</span>
                <i class="bi bi-chevron-down ms-1" style="font-size: 10px;"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu">
                <li><a class="dropdown-item {{ app()->getLocale() === 'ar' ? 'active' : '' }}" href="{{ route('web-language', 'ar') }}">العربية</a></li>
                <li><a class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}" href="{{ route('web-language', 'en') }}">English</a></li>
            </ul>
        </div>

        <div class="auth-divider"></div>

        @guest
            <a class="btn-auth-primary" href="{{ route('login') }}">{{ __('lang.login') }}</a>
        @endguest

        @auth
            @hasrole('admin|instructor|superadmin|assistant')
                <a class="btn-auth-primary" href="{{ route('dashboard') }}">{{ __('lang.dashboard') }}</a>
            @endhasrole

            @hasrole('user')
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 4px;">
                    <img src="{{ auth()->user()->getFirstMediaUrl('image') ?: asset('website/assets/img/avatar.png') }}" alt="{{ auth()->user()->name }}" class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover; border: 2px solid var(--accent-color);">
                </a>
                <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu mt-2">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger d-flex align-items-center gap-2" type="submit">
                                <i class="bi bi-box-arrow-right"></i> {{ __('lang.logout') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            @endhasrole
        @endauth
    </div>

    {{-- MOBILE HAMBURGER --}}
    <button  id="navMobileBtn" type="button" aria-label="Toggle menu" aria-expanded="false" class="nav-hamburger d-xl-none">
        <span></span>
        <span></span>
        <span></span>
    </button>
</nav>

{{-- MOBILE DRAWER --}}
<div class="nav-mobile-overlay" id="navMobileOverlay"></div>
<div class="nav-mobile-drawer" id="navMobileDrawer">

    <div class="drawer-header">
        <div class="d-flex align-items-center gap-2">
            <img src="{{ $logo_black }}" alt="Logo" style="width:32px; height:32px; border-radius:6px; object-fit:contain;">
            <span style="color:#f8fafc; font-weight:700; font-family:var(--heading-font); font-size:16px;">{{ $site_setting?->name ?? config('app.name') }}</span>
        </div>
        <button class="drawer-close" id="navMobileClose" aria-label="Close menu">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="drawer-body">
        <ul class="drawer-links">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" wire:navigate><i class="bi bi-house"></i> {{ __('lang.home') }}</a></li>
            @auth
                <li><a href="{{ route('my-courses.index') }}" class="{{ request()->routeIs('my-courses.*') ? 'active' : '' }}" wire:navigate><i class="bi bi-play-circle"></i> {{ __('lang.my_courses') }}</a></li>
            @endauth
            <li><a href="{{ route('pages.about') }}" class="{{ request()->routeIs('pages.about') ? 'active' : '' }}" wire:navigate><i class="bi bi-info-circle"></i> {{ __('lang.about_us') }}</a></li>
            <li><a href="{{ route('pages.privacy') }}" class="{{ request()->routeIs('pages.privacy') ? 'active' : '' }}" wire:navigate><i class="bi bi-shield-check"></i> {{ __('lang.privacy_policy') }}</a></li>
        </ul>

        <div class="drawer-divider"></div>

        <div class="drawer-settings">
            <p class="drawer-label">{{ app()->getLocale() === 'ar' ? 'اللغة' : 'Language' }}</p>
            <div class="drawer-lang-grid">
                <a href="{{ route('web-language', 'ar') }}" class="lang-card {{ app()->getLocale() === 'ar' ? 'active' : '' }}">العربية</a>
                <a href="{{ route('web-language', 'en') }}" class="lang-card {{ app()->getLocale() === 'en' ? 'active' : '' }}">English</a>
            </div>
        </div>

        <div class="drawer-footer">
            @guest
                <a href="{{ route('login') }}" class="btn-drawer-primary w-100">
                    <i class="bi bi-person"></i> {{ __('lang.login') }}
                </a>
            @endguest

            @auth
                @hasrole('admin|instructor|superadmin|assistant')
                    <a href="{{ route('dashboard') }}" class="btn-drawer-primary w-100 mb-2">
                        <i class="bi bi-speedometer2"></i> {{ __('lang.dashboard') }}
                    </a>
                @endhasrole

                <form method="POST" action="{{ route('logout') }}" class="w-100 mt-2">
                    @csrf
                    <button class="btn-drawer-danger w-100 border-0" type="submit">
                        <i class="bi bi-box-arrow-right"></i> {{ __('lang.logout') }}
                    </button>
                </form>
            @endauth
        </div>
    </div>
</div>

<style>
/* ==============================================================
   NAVIGATION BASE
============================================================== */
.main-nav-container {
    display: flex;
    align-items: center;
    gap: 20px;
}

/* ==============================================================
   DESKTOP LINKS
============================================================== */
.nav-links-desktop {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.nav-link-item {
    position: relative;
    padding: 8px 14px;
    font-size: 14.5px;
    font-weight: 500;
    color: #cbd5e1;
    text-decoration: none;
    border-radius: 8px;
    transition: color .2s, background .2s;
    font-family: var(--nav-font, inherit);
}

.nav-link-item:hover {
    color: #fff;
    background: rgba(117,79,254,.1);
}

.nav-link-item.active {
    color: #c4b5fd;
    font-weight: 600;
}

.nav-link-item::after {
    content: '';
    position: absolute;
    bottom: 4px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background: #754FFE;
    border-radius: 99px;
    transition: width .3s cubic-bezier(.4,0,.2,1);
}
.nav-link-item:hover::after,
.nav-link-item.active::after {
    width: 50%;
}

/* ==============================================================
   DESKTOP ACTIONS
============================================================== */
@media (max-width: 1199px) {
    .nav-links-desktop,
    .nav-actions-desktop {
        display: none !important;
    }
}

.auth-divider {
    width: 1px;
    height: 24px;
    background: rgba(255,255,255,.1);
    margin: 0 8px;
}

.btn-lang-toggle {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 8px;
    background: transparent;
    border: 1px solid rgba(117,79,254,.4);
    color: #cbd5e1;
    font-size: 14px;
    font-weight: 500;
    transition: all .2s;
}

.btn-lang-toggle:hover, .btn-lang-toggle[aria-expanded="true"] {
    border-color: #754FFE;
    color: #c4b5fd;
    background: rgba(117,79,254,.1);
}

.btn-auth-primary {
    display: inline-flex;
    align-items: center;
    padding: 8px 20px;
    background: var(--accent-color, #754FFE);
    color: #fff;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
}

.btn-auth-primary:hover {
    background: #6236ff;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(117,79,254,.3);
}

.custom-dropdown-menu {
    background: #111827;
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,.5);
    padding: 8px;
    min-width: 140px;
}
.custom-dropdown-menu .dropdown-item {
    color: #94a3b8;
    border-radius: 6px;
    padding: 8px 16px;
    font-size: 14px;
    transition: all .2s;
}
.custom-dropdown-menu .dropdown-item:hover,
.custom-dropdown-menu .dropdown-item.active {
    background: rgba(117,79,254,.15);
    color: #c4b5fd;
}

/* ==============================================================
   MOBILE HAMBURGER
============================================================== */
.nav-hamburger {
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 5px;
    width: 42px;
    height: 42px;
    padding: 10px;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 10px;
    cursor: pointer;
}

.nav-hamburger span {
    display: block;
    width: 100%;
    height: 2px;
    background: #e2e8f0;
    border-radius: 99px;
    transition: all .3s ease;
}

/* ==============================================================
   MOBILE DRAWER (PHYSICAL L/R FOR PERFECT RTL)
============================================================== */
.nav-mobile-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.6);
    backdrop-filter: blur(4px);
    z-index: 1040;
    opacity: 0;
    visibility: hidden;
    transition: opacity .3s, visibility 0s .3s;
}

.nav-mobile-overlay.is-visible {
    opacity: 1;
    visibility: visible;
    transition: opacity .3s, visibility 0s 0s;
}

.nav-mobile-drawer {
    position: fixed;
    top: 0;
    bottom: 0;
    width: min(320px, 85vw);
    background: #0f121b;
    border-inline-start: 1px solid rgba(255,255,255,.05);
    z-index: 1045;
    display: flex;
    flex-direction: column;
    box-shadow: 0 0 40px rgba(0,0,0,.8);
}

/* --- RTL / LTR Positioning --- */
html[dir="ltr"] .nav-mobile-drawer {
    right: -350px;
    transition: right .35s cubic-bezier(.4,0,.2,1);
}
html[dir="ltr"] .nav-mobile-drawer.is-open {
    right: 0;
}

html[dir="rtl"] .nav-mobile-drawer {
    left: -350px;
    transition: left .35s cubic-bezier(.4,0,.2,1);
}
html[dir="rtl"] .nav-mobile-drawer.is-open {
    left: 0;
}

/* Drawer Interior */
.drawer-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    border-bottom: 1px solid rgba(255,255,255,.05);
}

.drawer-close {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.1);
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    cursor: pointer;
    transition: all .2s;
}

.drawer-close:hover {
    background: rgba(239,68,68,.15);
    color: #f87171;
    border-color: rgba(239,68,68,.3);
}

.drawer-body {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.drawer-links {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.drawer-links a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: #cbd5e1;
    text-decoration: none;
    border-radius: 10px;
    font-size: 15.5px;
    font-weight: 500;
    transition: all .2s;
}

.drawer-links a i {
    font-size: 18px;
    color: #64748b;
    transition: color .2s;
}

.drawer-links a:hover {
    background: rgba(255,255,255,.04);
    color: #fff;
}

.drawer-links a.active {
    background: rgba(117,79,254,.15);
    color: #c4b5fd;
}
.drawer-links a.active i {
    color: #a855f7;
}

.drawer-divider {
    height: 1px;
    background: rgba(255,255,255,.05);
}

.drawer-label {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #64748b;
    margin-bottom: 12px;
    font-weight: 600;
}

.drawer-lang-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.lang-card {
    text-align: center;
    padding: 10px;
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 10px;
    color: #94a3b8;
    text-decoration: none;
    font-size: 14px;
    transition: all .2s;
}

.lang-card.active, .lang-card:hover {
    background: rgba(117,79,254,.15);
    border-color: rgba(117,79,254,.4);
    color: #c4b5fd;
}

.drawer-footer {
    margin-top: auto;
}

.btn-drawer-primary {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px;
    background: var(--accent-color, #754FFE);
    color: #fff;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
}
.btn-drawer-primary:hover {
    background: #6236ff;
    color: #fff;
}

.btn-drawer-danger {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px;
    background: rgba(239,68,68,.1);
    color: #f87171;
    border: 1px solid rgba(239,68,68,.2);
    border-radius: 10px;
    font-weight: 600;
    transition: all .2s;
}
.btn-drawer-danger:hover {
    background: rgba(239,68,68,.2);
}
</style>

<script>
(function() {
    // Define globally to ensure they are always available and never duplicated
    window.openEasyNav = function() {
        const d = document.getElementById('navMobileDrawer');
        const o = document.getElementById('navMobileOverlay');
        if (d && o) {
            d.classList.add('is-open');
            o.classList.add('is-visible');
            document.body.style.overflow = 'hidden';
        }
    };

    window.closeEasyNav = function() {
        const d = document.getElementById('navMobileDrawer');
        const o = document.getElementById('navMobileOverlay');
        if (d && o) {
            d.classList.remove('is-open');
            o.classList.remove('is-visible');
            document.body.style.overflow = '';
        }
    };

    function setupNav() {
        const btn = document.getElementById('navMobileBtn');
        const closeBtn = document.getElementById('navMobileClose');
        const overlay = document.getElementById('navMobileOverlay');
        const drawer = document.getElementById('navMobileDrawer');

        if (!btn || !drawer || !overlay) return;

        // Move to body to prevent backdrop-filter clipping in header
        if (overlay.parentNode !== document.body) {
            document.body.appendChild(overlay);
        }
        if (drawer.parentNode !== document.body) {
            document.body.appendChild(drawer);
        }

        // Clean up old listeners by cloning (foolproof way to remove anonymous listeners)
        const newBtn = btn.cloneNode(true);
        if (btn.parentNode) btn.parentNode.replaceChild(newBtn, btn);
        newBtn.addEventListener('click', window.openEasyNav);

        const newCloseBtn = closeBtn.cloneNode(true);
        if (closeBtn.parentNode) closeBtn.parentNode.replaceChild(newCloseBtn, closeBtn);
        newCloseBtn.addEventListener('click', window.closeEasyNav);

        const newOverlay = overlay.cloneNode(true);
        if (overlay.parentNode) overlay.parentNode.replaceChild(newOverlay, overlay);
        newOverlay.addEventListener('click', window.closeEasyNav);

        // Re-grab drawer since we might have cloned it? Wait, we didn't clone drawer, just overlay.
        // Actually, safer to just re-attach link listeners cleanly:
        const currentDrawer = document.getElementById('navMobileDrawer');
        currentDrawer.querySelectorAll('a').forEach(a => {
            // Remove old by cloning
            const newA = a.cloneNode(true);
            if (a.parentNode) a.parentNode.replaceChild(newA, a);
            newA.addEventListener('click', window.closeEasyNav);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupNav);
    } else {
        setupNav();
    }

    document.addEventListener('livewire:navigated', setupNav);

    // Global escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') window.closeEasyNav();
    });
})();
</script>
