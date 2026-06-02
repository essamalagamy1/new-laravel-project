<x-menu activateByRoute active-bg-color="font-black text-primary bg-primary/10 dark:bg-primary/20" class="menu-vertical">
	{{-- الرئيسية --}}
	<x-menu-item title="{{ __('lang.home') }}" icon-classes="text-primary" icon="o-home" link="{{ route('dashboard') }}" />

	<x-menu-separator />

	{{-- إدارة المستخدمين --}}
	@canany(['show_user', 'show_admin', 'show_instructor', 'show_role', 'show_assistant'])
		<x-menu-title title="{{ __('lang.users_management') }}" />
		@can('show_role')
			<x-menu-item title="{{ __('lang.roles_and_permissions') }}" icon-classes="text-primary" icon="o-shield-check" link="{{ route('roles') }}" />
		@endcan

		<x-menu-sub title="{{ __('lang.users') }}" icon-classes="text-primary" icon="o-users">
			@can('show_user')
				<x-menu-item title="{{ __('lang.users') }}" link="{{ route('users') }}" />
			@endcan
			@can('show_admin')
				<x-menu-item title="{{ __('lang.admins') }}" link="{{ route('admins') }}" />
			@endcan
		</x-menu-sub>

		<x-menu-separator />
	@endcanany

    @can('show_category')
        <x-menu-sub title="{{ __('lang.categories') }}" icon-classes="text-primary" icon="o-squares-plus">
            <x-menu-item title="{{ __('lang.categories') }}" link="{{ route('dashboard.categories') }}" />
            <x-menu-item title="{{ __('lang.subcategories') }}" link="{{ route('subcategories') }}" />
        </x-menu-sub>
    @endcan



	{{-- التسويق والعروض --}}
	@canany(['show_coupon', 'show_banner'])
		<x-menu-title title="{{ __('lang.marketing') }}" />

		@can('show_coupon')
			<x-menu-item title="{{ __('lang.coupons') }}" icon-classes="text-primary" icon="o-ticket" link="{{ route('coupons') }}" />
		@endcan

		@can('show_banner')
			<x-menu-item title="{{ __('lang.banners') }}" icon-classes="text-primary" icon="o-rectangle-stack" link="{{ route('banners') }}" />
		@endcan

		<x-menu-separator />
	@endcanany

	{{-- الدعم --}}
	@can('show_faq')
		<x-menu-title title="{{ __('lang.support') }}" />

		<x-menu-item title="{{ __('lang.faqs') }}" icon-classes="text-primary" icon="o-question-mark-circle" link="{{ route('faqs') }}" />

		<x-menu-separator />
	@endcan

	{{-- إعدادات النظام --}}
	@canany(['show_payment_gateway', 'show_site_setting', 'show_home_section'])
		<x-menu-title title="{{ __('lang.system_settings') }}" />

		@can('show_payment_gateway')
			<x-menu-item title="{{ __('lang.payment_gateways') }}" icon-classes="text-primary" icon="o-credit-card" link="{{ route('dashboard.payment-gateways') }}" />
		@endcan

		@can('show_site_setting')
			<x-menu-item title="{{ __('lang.settings') }}" icon-classes="text-primary" icon="o-cog-6-tooth" link="{{ route('site-settings') }}" />
		@endcan
	@endcanany
</x-menu>

