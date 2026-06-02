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

<x-card title="{{ __('lang.subcategories') }}" shadow class="mb-3">
		<x-slot:menu>
			@can('create_subcategory')
				<livewire:dashboard.sub-category.create-sub-category :all_categories="$all_categories" wire:key="{{\Illuminate\Support\Str::random(20)}}"></livewire:dashboard.sub-category.create-sub-category>
			@endcan
		</x-slot:menu>
		<div class="flex gap-3 mb-3 flex-wrap">
			<div class="w-64">
				<x-ui.choices-advanced-search label="{{ __('lang.subcategories') }}" wire:model.live="search_subcategory_id" :options="$all_subcategory" single clearable searchable
				                   option-value="id" option-label="name" placeholder="{{ __('lang.search') }}"/>
			</div>
			<div class="w-48">
				<x-select label="{{__('lang.category')}}" wire:model.live="filter_category_id" :options="$all_categories" placeholder="{{__('lang.all')}}" option-value="id" option-label="name"/>
			</div>
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
						<th class="text-center">{{__('lang.name_ar')}}</th>
						<th class="text-center">{{__('lang.name_en')}}</th>
						<th class="text-center">{{__('lang.category')}}</th>
						<th class="text-center">{{__('lang.visibility')}}</th>
						<th class="text-center">{{__('lang.status')}}</th>
						<th class="text-center">{{__('lang.created_at')}}</th>
						<th class="text-center">{{__('lang.action')}}</th>
					</tr>
					</thead>
					<tbody>
					@forelse($subcategories as $subcategory)
						<tr class="bg-base-200">
							<th class="text-center">{{$subcategories->firstItem() + $loop->index}}</th>
							<th class="text-nowrap">{{$subcategory->getTranslation('name', 'ar')}}</th>
							<th class="text-nowrap">{{$subcategory->getTranslation('name', 'en')}}</th>
							<th class="text-center text-nowrap">{{$subcategory->parent->getTranslation('name', app()->getLocale())}}</th>
							<th class="text-center text-nowrap">
								@if($subcategory->visibility === 'all')
									<span class="badge badge-info text-white">{{__('lang.visibility_all')}}</span>
								@elseif($subcategory->visibility === 'easyta3lim_only')
									<span class="badge badge-success text-white">{{__('lang.visibility_easyta3lim_only')}}</span>
								@elseif($subcategory->visibility === 'other_platforms_only')
									<span class="badge badge-secondary text-white">{{__('lang.visibility_other_platforms_only')}}</span>
								@endif
							</th>
							<th class="text-center">
								<x-badge :value="$subcategory->status->title()" class="bg-{{$subcategory->status->color()}}"/>
							</th>
							<th class="text-center text-nowrap">{{formatDate($subcategory->created_at,true) }}</th>
							<td>
								<div class="flex gap-2 justify-center">
									@can('edit_subcategory')
										<livewire:dashboard.sub-category.update-sub-category :subcategory="$subcategory" :all_categories="$all_categories" :key="\Illuminate\Support\Str::random(10)"/>
									@endcan
									@can('delete_subcategory')
										<x-button icon="o-trash" class="btn-sm btn-ghost" wire:click="delete({{$subcategory->id}})"
										          wire:confirm="{{__('lang.confirm_delete', ['attribute' => __('lang.subcategory')])}}"
										          wire:loading.attr="disabled" wire:target="delete({{$subcategory->id}})"
										          spinner="delete({{$subcategory->id}})" tooltip="{{__('lang.delete')}}"/>
									@endcan
								</div>
							</td>
						</tr>
					@empty
						<tr class="bg-base-200">
							<th colspan="8" class="text-center">{{__('lang.no_data')}}</th>
						</tr>
					@endforelse
					</tbody>
				</table>
				<div class="flex items-center justify-between px-4 py-3 bg-base-300 text-base-content sm:px-6 min-w-">
					<div class="flex w-full items-center justify-between">
						<div class="w-full flex-none">
							{{ $subcategories->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</x-card>
</div>
