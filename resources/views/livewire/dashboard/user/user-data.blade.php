@php use App\Enums\Status;use App\Services\FileService; @endphp
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

<x-card title="{{ __('lang.users') }}" shadow class="mb-3">
		<x-slot:menu>
			@can('create_user')
				<livewire:dashboard.user.create-user wire:key="{{\Illuminate\Support\Str::random(20)}}"></livewire:dashboard.user.create-user>
			@endcan
		</x-slot:menu>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
			<x-ui.choices-advanced-search label="{{ __('lang.users') }}" wire:model.live="search_user_id" :options="$all_user" single clearable searchable
			                   option-value="id" option-label="name" option-sub-label="email" placeholder="{{ __('lang.search') }}"/>
			<x-select label="{{ __('lang.instructor_code_status') }}" wire:model.live="filter_has_code" :options="[['id' => 'all', 'name' => __('lang.all')], ['id' => 'yes', 'name' => __('lang.subscribed_with_instructor')], ['id' => 'no', 'name' => __('lang.not_subscribed_with_instructor')]]" option-value="id" option-label="name"/>
		</div>
		<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
			<div class="overflow-x-auto">
				<table class="table">
					<thead class="min-w-full divide-y bg-base-300 text-base-content">
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">{{__('lang.name')}}</th>
						<th class="text-center">{{__('lang.email')}}</th>
						<th class="text-center">{{__('lang.instructor_code')}}</th>
						<th class="text-center">{{__('lang.created_at')}}</th>
						<th class="text-center">{{__('lang.action')}}</th>
					</tr>
					</thead>
					<tbody>
					@forelse($users as $user)
						<tr class="bg-base-200">
							<th class="text-center">{{$users->firstItem() + $loop->index}}</th>
							<th class="text-nowrap">
								<x-avatar :image="$user->getFirstMediaUrl('image')" :title="$user->name" :subtitle="$user->username" class="!w-10"/>
							</th>
							<th class="text-center text-nowrap">{{$user->email}}</th>
							<th class="text-center text-nowrap">
								@if($user->student_instructor_code)
									<span class="badge bg-primary font-mono">{{$user->student_instructor_code}}</span>
								@else
									<span class="text-gray-400">-</span>
								@endif
							</th>
							<th class="text-center text-nowrap">{{formatDate($user->created_at,true) }}</th>
							<td>
								<div class="flex gap-2 justify-center">
									@can('edit_user')
										<x-button icon="o-device-phone-mobile" class="btn-sm btn-ghost text-primary"
										          wire:click="resetDevice({{$user->id}})"
										          wire:confirm="{{__('lang.confirm_reset_device')}}"
										          wire:loading.attr="disabled" wire:target="resetDevice({{$user->id}})"
										          spinner="resetDevice({{$user->id}})" tooltip="{{__('lang.reset_device')}}"/>
										<livewire:dashboard.user.update-user :user="$user" :key="\Illuminate\Support\Str::random(10)"/>
									@endcan
									@can('delete_user')
										<x-button icon="o-trash" class="btn-sm btn-ghost" wire:click="delete({{$user->id}})"
										          wire:confirm="{{__('lang.confirm_delete', ['attribute' => __('lang.user')])}}"
										          wire:loading.attr="disabled" wire:target="delete({{$user->id}})"
										          spinner="delete({{$user->id}})" tooltip="{{__('lang.delete')}}"/>
									@endcan
								</div>
							</td>
						</tr>
					@empty
						<tr class="bg-base-200">
							<th colspan="6" class="text-center">{{__('lang.no_data')}}</th>
						</tr>
					@endforelse
					</tbody>
				</table>
				<div class="flex items-center justify-between px-4 py-3 bg-base-300 text-base-content sm:px-6 min-w-">
					<div class="flex w-full items-center justify-between">
						<div class="w-full flex-none">
							{{ $users->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</x-card>
</div>
