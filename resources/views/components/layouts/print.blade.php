<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $title ?? config('app.name') }}</title>
	@vite(['resources/js/app.js'])
	<style>
		@media print {
			body { background: white !important; color: black !important; }
			.no-print { display: none !important; }
			.print-container { max-width: 100% !important; padding: 0 !important; }
		}
		body { background: #f8fafc; }
	</style>
</head>
<body class="bg-white min-h-screen">
	<div class="print-container max-w-4xl mx-auto p-6">
		{{ $slot }}
	</div>
</body>
</html>
