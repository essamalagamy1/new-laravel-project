@php use App\Services\FileService; @endphp
@assets()
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
@endassets()
<div>

    @if(isset($breadcrumbs))
        <x-breadcrumbs
            :items="$breadcrumbs"
            separator="fas.chevron-{{app()->getLocale() === 'ar' ? 'left' : 'right'}}"
            class="bg-base-300 p-3 rounded-box mb-3"
            icon-class="dark:text-white w-4 h-4"
            link-item-class="text-sm font-bold"
        />
    @endif

    <x-card title="{{ __('lang.site_settings') }}" shadow class="mb-3">
        <x-form wire:submit="saveUpdate">
            {{-- Basic Info --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">
                    <i class="fas fa-info-circle text-primary mr-2"></i>
                    {{ __('lang.basic_info') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <x-input required label="{{ __('lang.name_ar') }}" wire:model="name_ar"/>
                    <x-input required dir="ltr" label="{{ __('lang.name_en') }}" wire:model="name_en"/>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3">
                    <x-textarea required label="{{ __('lang.description_ar') }}" wire:model="description_ar" rows="3"/>
                    <x-textarea required dir="ltr" label="{{ __('lang.description_en') }}" wire:model="description_en" rows="3"/>
                </div>
            </div>

            {{-- Colors --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">
                    <i class="fas fa-palette text-primary mr-2"></i>
                    {{ __('lang.color_settings') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <x-colorpicker wire:model="color_primary" label="{{ __('lang.color_primary') }}" suffix="Hex code"/>
                    <x-colorpicker wire:model="color_secondary" label="{{ __('lang.color_secondary') }}" suffix="Hex code"/>
                    <x-colorpicker wire:model="color_accent" label="{{ __('lang.color_accent') }}" suffix="Hex code"/>
                </div>
            </div>

            {{-- Maintenance Settings --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">
                    <i class="fas fa-tools text-primary mr-2"></i>
                    {{ __('lang.maintenance_settings') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <x-toggle label="{{ __('lang.maintenance_mode') }}" wire:model="maintenance_mode"/>
                </div>
            </div>

            {{-- course settings --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">
                    <i class="fas fa-cogs text-primary mr-2"></i>
                    {{ __('lang.course_settings') }}
                </h3>
                <div class="grid grid-cols-1 sm-only:grid-cols-3 md:grid-cols-5  gap-3">
                    <x-input required type="number" step="0.01" suffix="%" label="{{ __('lang.tax_percentage') }}" wire:model="tax_percentage"/>
                    <x-input required  label="{{ __('lang.payment_transaction_title') }}" wire:model="payment_transaction_title"/>
                    <x-input required  label="{{ __('lang.payment_transaction_value') }}" wire:model="payment_transaction_value"/>
                    <x-input  label="{{ __('lang.payment_transaction_title_2') }}" wire:model="payment_transaction_title_2"/>
                    <x-input  label="{{ __('lang.payment_transaction_value_2') }}" wire:model="payment_transaction_value_2"/>
                </div>
            </div>

            {{-- Logos --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">
                    <i class="fas fa-image text-primary mr-2"></i>
                    {{ __('lang.logos') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <div class="flex justify-center mb-4">
                            <div>
                                <x-file label="{{ __('lang.logo_white') }}" wire:model="logo_white" accept="image/*"
                                        hint="{{ __('lang.click_on_image_to_change') }}" class="cursor-pointer">
                                    <img alt="logo_white" src="{{ siteSetting()->getFirstMediaUrl('logo_white') }}"
                                         class="!w-24 !h-24 rounded-lg"/>
                                </x-file>
                                <div wire:loading wire:target="logo_white" class="mt-2">
                                    <x-progress class="progress-primary h-1" indeterminate/>
                                    <p class="text-sm text-center text-primary">{{ __('lang.uploading_image') }}...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-center mb-4">
                            <div>
                                <x-file label="{{ __('lang.logo_black') }}" wire:model="logo_black" accept="image/*"
                                        hint="{{ __('lang.click_on_image_to_change') }}" class="cursor-pointer">
                                    <img alt="logo_black" src="{{siteSetting()->getFirstMediaUrl('logo_black') }}"
                                         class="!w-24 !h-24 rounded-lg"/>
                                </x-file>
                                <div wire:loading wire:target="logo_black" class="mt-2">
                                    <x-progress class="progress-primary h-1" indeterminate/>
                                    <p class="text-sm text-center text-primary">{{ __('lang.uploading_image') }}...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-center mb-4">
                            <div>
                                <x-file label="{{ __('lang.favicon') }}" wire:model="favicon" accept="image/*"
                                        hint="{{ __('lang.click_on_image_to_change') }}" class="cursor-pointer">
                                    <img alt="favicon" src="{{ siteSetting()->getFirstMediaUrl('favicon') }}"
                                         class="!w-24 !h-24 rounded-lg"/>
                                </x-file>
                                <div wire:loading wire:target="favicon" class="mt-2">
                                    <x-progress class="progress-primary h-1" indeterminate/>
                                    <p class="text-sm text-center text-primary">{{ __('lang.uploading_image') }}...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Info --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">
                    <i class="fas fa-address-book text-primary mr-2"></i>
                    {{ __('lang.contact_info') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <x-textarea label="{{ __('lang.address_ar') }}" wire:model="address_ar" rows="3"/>
                    <x-textarea dir="ltr" label="{{ __('lang.address_en') }}" wire:model="address_en" rows="3"/>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3">
                    <x-input dir="ltr" label="{{ __('lang.phone') }}" wire:model="phone"/>
                    <x-input label="{{ __('lang.email') }}" wire:model="email" type="email"/>
                </div>
            </div>

            {{-- Google OAuth Settings --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">
                    <i class="fa-brands fa-google text-primary me-2"></i>
                    {{ __('lang.google_oauth_settings') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <x-input dir="ltr" label="{{ __('lang.google_client_id') }}" wire:model="google_client_id"
                             hint="{{ __('lang.google_client_id_hint') }}"/>
                    <x-input dir="ltr" label="{{ __('lang.google_client_secret') }}"
                             wire:model="google_client_secret" hint="{{ __('lang.google_client_secret_hint') }}"/>
                    <x-input dir="ltr" label="{{ __('lang.google_redirect_uri') }}"
                             wire:model="google_redirect_uri" hint="{{ __('lang.google_redirect_uri_hint') }}"/>
                </div>
            </div>

            {{-- About Us --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">
                    <i class="fas fa-info-circle text-primary mr-2"></i>
                    {{ __('lang.about_us') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <x-trix required wire:model="about_us_ar" label="{{ __('lang.about_us_ar') }}" key="{{ \Illuminate\Support\Str::random(20) }}"></x-trix>
                    <x-trix dir="ltr" required wire:model="about_us_en" label="{{ __('lang.about_us_en') }}" key="{{ \Illuminate\Support\Str::random(20) }}"></x-trix>
                </div>
            </div>

            {{-- Shipping & Returns --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">
                    <i class="fas fa-shipping-fast text-primary mr-2"></i>
                    {{ __('lang.shipping_returns') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <x-trix required wire:model="shipping_returns_ar" label="{{ __('lang.shipping_returns_ar') }}"
                            key="{{ \Illuminate\Support\Str::random(20) }}"></x-trix>
                    <x-trix dir="ltr" required wire:model="shipping_returns_en"
                            label="{{ __('lang.shipping_returns_en') }}"
                            key="{{ \Illuminate\Support\Str::random(20) }}"></x-trix>
                </div>
            </div>

            {{-- Privacy Policy --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">
                    <i class="fas fa-user-secret text-primary mr-2"></i>
                    {{ __('lang.privacy_policy') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <x-trix required wire:model="privacy_policy_ar" label="{{ __('lang.privacy_policy_ar') }}"
                            key="{{ \Illuminate\Support\Str::random(20) }}"></x-trix>
                    <x-trix dir="ltr" required wire:model="privacy_policy_en"
                            label="{{ __('lang.privacy_policy_en') }}"
                            key="{{ \Illuminate\Support\Str::random(20) }}"></x-trix>
                </div>
            </div>

            {{-- Terms and Conditions --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">
                    <i class="fas fa-file-contract text-primary mr-2"></i>
                    {{ __('lang.terms_and_conditions') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <x-trix required wire:model="terms_and_conditions_ar"
                            label="{{ __('lang.terms_and_conditions_ar') }}"
                            key="{{ \Illuminate\Support\Str::random(20) }}"></x-trix>
                    <x-trix dir="ltr" required wire:model="terms_and_conditions_en"
                            label="{{ __('lang.terms_and_conditions_en') }}"
                            key="{{ \Illuminate\Support\Str::random(20) }}"></x-trix>
                </div>
            </div>

            {{-- refund policy --}}

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">
                    <i class="fas fa-undo-alt text-primary mr-2"></i>
                    {{ __('lang.refund_policy') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <x-trix required wire:model="refund_policy_ar" label="{{ __('lang.refund_policy_ar') }}"
                            key="{{ \Illuminate\Support\Str::random(20) }}"></x-trix>
                    <x-trix dir="ltr" required wire:model="refund_policy_en"
                            label="{{ __('lang.refund_policy_en') }}"
                            key="{{ \Illuminate\Support\Str::random(20) }}"></x-trix>
                </div>
            </div>

            {{-- shipping policy --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">
                    <i class="fas fa-shipping-fast text-primary mr-2"></i>
                    {{ __('lang.shipping_policy') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <x-trix required wire:model="shipping_policy_ar" label="{{ __('lang.shipping_policy_ar') }}"
                            key="{{ \Illuminate\Support\Str::random(20) }}"></x-trix>
                    <x-trix dir="ltr" required wire:model="shipping_policy_en"
                            label="{{ __('lang.shipping_policy_en') }}"
                            key="{{ \Illuminate\Support\Str::random(20) }}"></x-trix>
                </div>
            </div>

            <div class="flex justify-end">
                @can('edit_site_setting')
                    <x-button label="{{ __('lang.update') }}" class="btn btn-primary" wire:loading.attr="disabled" type="submit" spinner="saveUpdate"/>
                @endcan
            </div>
        </x-form>
    </x-card>
</div>
