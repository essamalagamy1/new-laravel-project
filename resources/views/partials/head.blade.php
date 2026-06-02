@php
	use App\Services\FileService;

	$site_setting = siteSetting();
	$site_name = $site_setting?->name ?? config('app.name');
	$site_description = $site_setting?->description ?? '';
	$favicon = $site_setting?->getFirstMediaUrl('favicon') ?: asset('favicon.ico');
@endphp
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="{{ config('app.name') }} - Build, showcase, and impress with your professional portfolio">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@auth
		<meta name="vapid-public-key" content="{{ config('webpush.vapid.public_key') }}">
	@endauth

	<title>{{ $site_name }} | {{ isset($title) ? __("lang.$title") : __('lang.home') }}</title>
	<meta name="description" content="@yield('meta_description', $site_description)">
	<meta name="keywords" content="@yield('meta_keywords', $site_description)">
	<link rel="icon" href="{{ $favicon }}" type="image/x-icon"/>
	<link rel="shortcut icon" href="{{ $favicon }}" type="image/x-icon"/>

	@vite(['resources/js/app.js'])
	@yield('style')

	{{-- Chart.js --}}
	<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

	{{-- Dynamic Colors from Site Settings --}}
	<style>
		:root {
			--color-primary: {{ $site_setting?->color_primary ?? '#f8a400' }};
			--color-secondary: {{ $site_setting?->color_secondary ?? '#FFFEFC' }};
			--color-accent: {{ $site_setting?->color_accent ?? '#f8a400' }};
		}
	</style>
</head>
