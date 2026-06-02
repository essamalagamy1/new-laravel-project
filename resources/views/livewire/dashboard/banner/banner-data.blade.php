@php use App\Services\FileService; @endphp
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
	<x-card title="{{ __('lang.banners') }}" shadow class="mb-3">
		<x-slot:menu>
			@can('create_banner')
				<livewire:dashboard.banner.create-banner  wire:key="{{\Illuminate\Support\Str::random(20)}}"></livewire:dashboard.banner.create-banner>
			@endcan
		</x-slot:menu>
		<div class="flex gap-3 mb-3 flex-wrap">
			<div class="w-48">
				<x-select label="{{__('lang.status')}}" wire:model.live="filter_status" :options="[['id' => 'active', 'name' => __('lang.active')], ['id' => 'inactive', 'name' => __('lang.inactive')]]" placeholder="{{__('lang.all')}}" option-value="id" option-label="name"/>
			</div>
			<div class="w-48">
				<x-select label="{{__('lang.visibility')}}" wire:model.live="filter_visibility" :options="[['id' => 'all_states', 'name' => __('lang.all')], ['id' => 'all', 'name' => __('lang.visibility_all')], ['id' => 'easyta3lim_only', 'name' => __('lang.visibility_easyta3lim_only')], ['id' => 'other_platforms_only', 'name' => __('lang.visibility_other_platforms_only')]]" option-value="id" option-label="name"/>
			</div>
		</div>
		<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
			<div class="overflow-x-auto">
				<table class="table">
					<thead class="min-w-full divide-y bg-base-300 text-base-content">
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">{{__('lang.sort')}}</th>
						<th class="text-center">{{__('lang.name_ar')}}</th>
						<th class="text-center">{{__('lang.name_en')}}</th>
						<th class="text-center">{{__('lang.is_single')}}</th>
						<th class="text-center">{{__('lang.visibility')}}</th>
						<th class="text-center">{{__('lang.status')}}</th>
						<th class="text-center">{{__('lang.created_at')}}</th>
						<th class="text-center">{{__('lang.action')}}</th>
					</tr>
					</thead>
					<tbody>
					@forelse($banners as $banner)
						<tr class="bg-base-200">
							<th class="text-center">{{$banners->firstItem() + $loop->index}}</th>
							<th class="text-center">{{$banner->sort}}</th>
							<th class="text-nowrap">{{$banner->getTranslation('name', 'ar')}}</th>
							<th class="text-nowrap">{{$banner->getTranslation('name', 'en')}}</th>
							<th class="text-center">
								<x-badge :value="$banner->is_single ? __('lang.yes') : __('lang.no')" class="bg-{{$banner->is_single ? 'green-500' : 'red-500'}}"/>
							</th>
							<th class="text-center text-nowrap">
								@if($banner->visibility === 'all')
									<span class="badge badge-info text-white">{{__('lang.visibility_all')}}</span>
								@elseif($banner->visibility === 'easyta3lim_only')
									<span class="badge badge-success text-white">{{__('lang.visibility_easyta3lim_only')}}</span>
								@elseif($banner->visibility === 'other_platforms_only')
									<span class="badge badge-secondary text-white">{{__('lang.visibility_other_platforms_only')}}</span>
								@endif
							</th>
							<th class="text-center">
								<x-badge :value="$banner->status->title()" class="bg-{{$banner->status->color()}}"/>
							</th>
							<th class="text-center text-nowrap">{{formatDate($banner->created_at,true) }}</th>
							<td>
								<div class="flex gap-2 justify-center">
									@can('edit_banner')
										<livewire:dashboard.banner.update-banner :banner="$banner" :key="\Illuminate\Support\Str::random(10)"/>
									@endcan
									@can('delete_banner')
										<x-button icon="o-trash" class="btn-sm btn-ghost" wire:click="delete({{$banner->id}})"
										          wire:confirm="{{__('lang.confirm_delete', ['attribute' => __('lang.banner')])}}"
										          wire:loading.attr="disabled" wire:target="delete({{$banner->id}})"
										          spinner="delete({{$banner->id}})" tooltip="{{__('lang.delete')}}"/>
									@endcan
								</div>
							</td>
						</tr>
					@empty
						<tr class="bg-base-200">
							<th colspan="10" class="text-center">{{__('lang.no_data')}}</th>
						</tr>
					@endforelse
					</tbody>
				</table>
				<div class="flex items-center justify-between px-4 py-3 bg-base-300 text-base-content sm:px-6 min-w-">
					<div class="flex w-full items-center justify-between">
						<div class="w-full flex-none">
							{{ $banners->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</x-card>
</div>
