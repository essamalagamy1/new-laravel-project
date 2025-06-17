<nav id="nav" class="fixed top-0 left-0 right-0 z-50 bg-white bg-opacity-80 backdrop-blur-md dark:bg-gray-900 dark:bg-opacity-80 border-b border-gray-200 dark:border-gray-800 transition-colors duration-300">
	<div class="container mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex justify-between items-center h-16">
			{{-- Logo and site name --}}
			<div class="flex items-center">
				<a href="{{route('dashboard')}}" class="flex items-center">
                <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600" data-aos="fade-down" data-aos-delay="100">
                   {{config('app.name')}}
                </span>
				</a>
			</div>

			{{-- Desktop navigation links --}}
			<div class="hidden md:flex items-center space-x-6 ">
				<a href="{{route('home')}}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200 font-bold text-lg"
				   data-aos="fade-down" data-aos-delay="200">{{__('lang.home')}}
				</a>
				<a href="#audience" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200 font-bold text-lg"
				   data-aos="fade-down" data-aos-delay="300">{{__('lang.for_whom')}}
				</a>
				<a href="#pricing" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200 font-bold text-lg"
				   data-aos="fade-down" data-aos-delay="400">{{__('lang.pricing')}}
				</a>
				<a href="#contact" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200 font-bold text-lg"
				   data-aos="fade-down" data-aos-delay="400">{{__('lang.contact_us')}}
				</a>
				<a href="#faq" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200 font-bold text-lg"
				   data-aos="fade-down" data-aos-delay="500">{{__('lang.FAQ')}}
				</a>
			</div>

			<div class="flex items-center space-x-2 sm:space-x-3 rtl:space-x-reverse">
				{{--register and login buttons--}}
				@guest
					<a href="{{route('register')}}"
					   class="hidden md:inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg
				   text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900
				   transition-colors duration-200 shadow-lg hover:shadow-indigo-500/40 " data-aos="fade-down" data-aos-delay="600">
						{{__('lang.get_started')}}
					</a>

					<a href="{{route('login')}}"
					   class="hidden md:inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-indigo-600 dark:text-indigo-400 bg-transparent
				    hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-colors duration-200"
					   data-aos="fade-down" data-aos-delay="600">
						{{__('lang.login')}}
					</a>
				@endguest

				{{-- Authenticated user button --}}
				@auth
					<a href="{{route('dashboard')}}"
					   class="md:inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg
				   text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
				    dark:focus:ring-offset-gray-900
				   transition-colors duration-200 shadow-lg hover:shadow-indigo-500/40 " data-aos="fade-down" data-aos-delay="600">
						{{__('lang.dashboard')}}
					</a>
				@endauth


				{{-- language --}}
				<div class="dropdown relative dropdown-end" data-aos="fade-down" data-aos-delay="700">
					<div tabindex="0" role="button"
					     class="flex items-center justify-center cursor-pointer p-1.5 sm:p-2 rounded-full text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
						<i class='bx bx-translate text-lg sm:text-xl'></i>
					</div>
					<ul tabindex="0" class="dropdown-content menu absolute  mt-3 dark:bg-gray-900 rounded-lg z-50 w-max min-w-[10rem] p-2 shadow-md bg-white border border-gray-100 dark:border-gray-800 origin-top">
						<li>
							<a class="flex items-center w-full px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors duration-200 text-base font-bold {{app()->getLocale() === 'en' ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300'}}"
							   href="{{route('web-language','en')}}">
								<x-flag-country-us class="w-[20px] h-auto me-3"/> {{-- تم تعديل العرض واستخدام me-3 للمسافة --}}
								<span>English</span>
							</a>
						</li>
						<li>
							<a class="flex items-center w-full px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors duration-200 text-base font-bold {{app()->getLocale() === 'ar' ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300'}}"
							   href="{{route('web-language','ar')}}">
								<x-flag-country-eg class="w-[20px] h-auto me-3"/> {{-- تم تعديل العرض واستخدام me-3 للمسافة --}}
								<span>العربية</span>
							</a>
						</li>
					</ul>
				</div>

				{{-- Hamburger menu for mobile --}}
				<div class="md:hidden flex items-center" data-aos="fade-down" data-aos-delay="200"> {{-- Added AOS for hamburger on mobile --}}
					<button id="mobile-menu-button" type="button"
					        class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
					        aria-controls="mobile-menu-items" aria-expanded="false">
						<span class="sr-only">{{__('lang.open_main_menu')}}</span>
						<svg id="icon-menu-closed" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
						</svg>
						<svg id="icon-menu-open" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
						</svg>
					</button>
				</div>
			</div>
		</div>
	</div>

	{{-- Mobile menu items, hidden by default and shown when the button is clicked --}}
	<div class="hidden md:hidden" id="mobile-menu-items">
		<div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
			<a href="{{route('home')}}" class="text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 block px-3 py-2 rounded-md text-base font-bold">{{__('lang.home')}}</a>
			<a href="#audience" class="text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 block px-3 py-2 rounded-md text-base font-bold">{{__('lang.for_whom')}}</a>
			<a href="#pricing" class="text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 block px-3 py-2 rounded-md text-base font-bold">{{__('lang.pricing')}}</a>
			<a href="#faq" class="text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 block px-3 py-2 rounded-md text-base font-bold">{{__('lang.FAQ')}}</a>
		</div>
		<div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
			<div class="px-2">
				{{-- Register and Login buttons for mobile --}}
				@guest
					<a href="{{route('login')}}" class="block w-full px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
						{{__('lang.login')}}
					</a>
					<a href="{{route('register')}}" class="block w-full px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
						{{__('lang.get_started')}}
					</a>
				@endguest
				{{-- Authenticated user button for mobile --}}
				@auth
					<a href="{{route('home')}}" class="block w-full px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
						{{__('lang.dashboard')}}
					</a>
				@endauth
			</div>
		</div>
	</div>
</nav>
