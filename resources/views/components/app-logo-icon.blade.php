@php
	$site_setting = siteSetting();
	$logo_black = $site_setting?->getFirstMediaUrl('logo_black') ?: asset('logo.svg');
@endphp
<img src="{{ $logo_black }}" alt="{{ config('app.name') }}" class="">
