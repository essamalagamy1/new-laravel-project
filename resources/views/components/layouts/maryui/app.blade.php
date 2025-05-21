<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<title>{{ $title ?? 'Laravel' }}</title>

	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

	<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-base-200">

<x-nav sticky full-width>

	<x-slot:brand>
		{{-- Drawer toggle for "main-drawer" --}}
		<label for="main-drawer" class="lg:hidden mr-3">
			<x-icon name="o-bars-3" class="cursor-pointer"/>
		</label>
		{{-- Brand --}}
		<div>{{config('app.name')}}</div>
	</x-slot:brand>

	{{-- Right side actions --}}
	<x-slot:actions>
{{--		<x-theme-toggle/>--}}
		<x-button icon="o-bell" link="###" class="btn-ghost btn-sm" responsive/>
		<div class="dropdown dropdown-end">
			<div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
				<div class="w-10 rounded-full">
					<img alt="Tailwind CSS Navbar component" src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp"/>
				</div>
			</div>
			<ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
				<li>
					<a class="justify-between">
						{{ auth()->user()->name }}
					</a>
				</li>
				<li><a href="" wire:navigate>Settings</a></li>
				<li><a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="cursor: pointer" wire:navigate>Logout</a></li>
				<form style="display: none" id="logout-form" action="{{ route('logout') }}" method="POST">
					@csrf
				</form>
			</ul>
		</div>
	</x-slot:actions>
</x-nav>

{{-- The main content with `full-width` --}}
<x-main with-nav full-width>

	{{-- This is a sidebar that works also as a drawer on small screens --}}
	{{-- Notice the `main-drawer` reference here --}}
	<x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100">
		{{-- Activates the menu item when a route matches the `link` property --}}
		<x-menu activate-by-route>
			<x-menu-item title="Home" icon="o-home" link="{{route('dashboard')}}" wire:navigate/>
			<x-menu-item title="Users" icon="o-users" link="{{route('users')}}" wire:navigate/>
			<x-menu-item title="Messages" icon="o-envelope" link="###"/>
			<x-menu-sub title="Settings" icon="o-cog-6-tooth">
				<x-menu-item title="Wifi" icon="o-wifi" link="####"/>
				<x-menu-item title="Archives" icon="o-archive-box" link="####"/>
			</x-menu-sub>
		</x-menu>
	</x-slot:sidebar>

	{{-- The `$slot` goes here --}}
	<x-slot:content>
		{{ $slot }}
	</x-slot:content>
</x-main>

{{--  TOAST area --}}
<x-toast  position="toast-top toast-center"/>
</body>
</html>