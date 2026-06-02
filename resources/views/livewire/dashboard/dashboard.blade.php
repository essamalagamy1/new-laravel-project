<div>
    <div class="flex h-full w-full flex-1 flex-col gap-5 rounded-xl">

        {{-- ======================== --}}
        {{-- Stats Row 1 --}}
        {{-- ======================== --}}
{{--        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">--}}
{{--            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">--}}
{{--                <x-stat--}}
{{--                    :title="__('lang.users')"--}}
{{--                    :value="number_format($stats['users'])"--}}
{{--                    icon="o-academic-cap"--}}
{{--                    color="text-indigo-500"--}}
{{--                />--}}
{{--            </div>--}}
{{--        </div>--}}

        {{-- ======================== --}}
        {{-- Charts --}}
        {{-- ======================== --}}
{{--        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">--}}

{{--            --}}{{-- Enrollments Chart --}}
{{--            <x-card :title="__('lang.enrollments')" shadow separator>--}}
{{--                <div class="h-64">--}}
{{--                    <x-chart wire:model="enrollmentsChart" />--}}
{{--                </div>--}}
{{--            </x-card>--}}

{{--            --}}{{-- Wallet Chart --}}
{{--            <x-card--}}
{{--                :title="auth()->user()->hasRole('instructor') ? __('lang.my_wallet') : __('lang.platform_wallet')"--}}
{{--                shadow separator--}}
{{--            >--}}
{{--                <div class="h-64">--}}
{{--                    <x-chart wire:model="walletChart" />--}}
{{--                </div>--}}
{{--            </x-card>--}}

{{--        </div>--}}

        {{-- ======================== --}}
        {{-- Latest Enrollments Table --}}
        {{-- ======================== --}}
{{--        <x-card :title="__('lang.latest_enrollments')" shadow separator>--}}
{{--            <div class="overflow-x-auto">--}}
{{--                <table class="table w-full text-sm">--}}
{{--                    <thead class="bg-base-300 text-nowrap">--}}
{{--                        <tr>--}}
{{--                            <th class="py-3 px-4">#</th>--}}
{{--							 <th class="py-3 px-4">{{ __('lang.enrollment_code') }}</th>--}}
{{--                            <th class="py-3 px-4">{{ __('lang.user') }}</th>--}}
{{--                            <th class="py-3 px-4">{{ __('lang.course') }}</th>--}}
{{--                            <th class="py-3 px-4">{{ __('lang.final_price') }}</th>--}}
{{--                            <th class="py-3 px-4">{{ __('lang.status') }}</th>--}}
{{--                            <th class="py-3 px-4">{{ __('lang.date') }}</th>--}}
{{--                        </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                        @foreach($latestEnrollments as $i => $enrollment)--}}
{{--                        <tr class="hover:bg-base-200 transition-colors">--}}
{{--                            <td class="py-3 px-4 font-mono text-xs text-gray-400">{{ $i + 1 }}</td>--}}
{{--							<td class="py-3 px-4 font-mono text-xs text-gray-400">--}}
{{--							<a href="{{ route('enrollments.show', $enrollment->id) }}" class="text-blue-500 hover:underline">--}}
{{--								{{ $enrollment->enrollment_code }}</a>--}}
{{--							</td>--}}
{{--                            <td class="py-3 px-4">--}}
{{--                                {{ $enrollment->user?->name ?? '-' }}--}}
{{--                            </td>--}}
{{--                            <td class="py-3 px-4 max-w-[200px] truncate">--}}
{{--                                {{ $enrollment->course?->getTranslation('name', app()->getLocale()) ?? '-' }}--}}
{{--                            </td>--}}
{{--                            <td class="py-3 px-4 font-semibold">--}}
{{--                                {{ number_format($enrollment->final_price, 2) }}--}}
{{--                            </td>--}}
{{--                            <td class="py-3 px-4">--}}
{{--                                <x-badge--}}
{{--                                    :value="$enrollment->status->title()"--}}
{{--                                    class="bg-{{ $enrollment->status->color() }} text-white text-xs"--}}
{{--                                />--}}
{{--                            </td>--}}
{{--                            <td class="py-3 px-4 text-gray-400 text-xs">--}}
{{--                                {{ formatDate($enrollment->created_at) }}--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                        @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </x-card>--}}
    </div>
</div>
