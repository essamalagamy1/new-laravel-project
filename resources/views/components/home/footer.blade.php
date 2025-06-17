<footer class="bg-gray-900 text-white py-6 bg-opacity-80 backdrop-blur-md dark:bg-gray-900 dark:bg-opacity-80 border-t border-gray-200 dark:border-gray-800 transition-colors duration-300">
	<div class="container mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-5 text-sm" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
			<div class="text-center ">
				<h3 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">
					{{ config('app.name') }}
				</h3>
				<p class="text-gray-400 mt-1">{{ __('lang.build_showcase_impress') }}</p>
			</div>

			<!-- Right Section: Links and Copyright -->
			<div class="flex flex-col  gap-3">
				<div class="flex flex-col sm:flex-row sm:justify-center md:justify-end items-center gap-x-4 gap-y-2 text-center">
					<a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
						{{ __('lang.footer_link_privacy_policy') }}
					</a>
					<a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 lg:border-l lg:border-r border-gray-500 lg:px-3">
						{{ __('lang.footer_link_terms_of_service') }}
					</a>
					<a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
						{{ __('lang.footer_link_cookie_policy') }}
					</a>
				</div>
			</div>


		</div>
		<div data-aos="fade-up" data-aos-anchor-placement="top-bottom">
			<x-progress class="progress-primary h-0.5" indeterminate />
			<p class="text-gray-400 text-center  text-xs mt-3">
				{{ __('lang.footer_copyright', ['year' => now()->year,'app_name' => config('app.name')]) }}
				{{ __('lang.footer_developed_by') }}
				<a href="https://www.linkedin.com/in/essamalagamy1/" class="font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">
					{{ __('lang.essam_alagamy') }}
				</a>
			</p>
		</div>

	</div>
</footer>
