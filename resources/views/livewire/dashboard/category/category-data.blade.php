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

<x-card title="{{ __('lang.categories') }}" shadow class="mb-3">
		<x-slot:menu>
			@can('create_category')
				<livewire:dashboard.category.create-category wire:key="{{\Illuminate\Support\Str::random(20)}}"></livewire:dashboard.category.create-category>
			@endcan
		</x-slot:menu>
		<div class="flex gap-3 mb-3 flex-wrap">
			<div class="w-64">
				<x-ui.choices-advanced-search label="{{ __('lang.categories') }}" wire:model.live="search_category_id" :options="$all_category" single clearable searchable
				                   option-value="id" option-label="name" placeholder="{{ __('lang.search') }}"/>
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
						<th class="text-center">{{__('lang.subcategories')}}</th>
						<th class="text-center">{{__('lang.visibility')}}</th>
						<th class="text-center">{{__('lang.status')}}</th>
						<th class="text-center">{{__('lang.created_at')}}</th>
						<th class="text-center">{{__('lang.action')}}</th>
					</tr>
					</thead>
					<tbody>
					@forelse($categories as $category)
						<tr class="bg-base-200">
							<th class="text-center">{{$categories->firstItem() + $loop->index}}</th>
							<th class="text-nowrap">{{$category->getTranslation('name', 'ar')}}</th>
							<th class="text-nowrap">{{$category->getTranslation('name', 'en')}}</th>
							<th class="text-center">
								<x-badge :value="$category->children_count" class="bg-gray-500"/>
							</th>
							<th class="text-center text-nowrap">
								@if($category->visibility === 'all')
									<span class="badge badge-info text-white">{{__('lang.visibility_all')}}</span>
								@elseif($category->visibility === 'easyta3lim_only')
									<span class="badge badge-success text-white">{{__('lang.visibility_easyta3lim_only')}}</span>
								@elseif($category->visibility === 'other_platforms_only')
									<span class="badge badge-secondary text-white">{{__('lang.visibility_other_platforms_only')}}</span>
								@endif
							</th>
							<th class="text-center">
								<x-badge :value="$category->status->title()" class="bg-{{$category->status->color()}}"/>
							</th>
							<th class="text-center text-nowrap">{{formatDate($category->created_at,true) }}</th>
							<td>
								<div class="flex gap-2 justify-center">
									@can('edit_category')
										<livewire:dashboard.category.update-category :category="$category" :key="\Illuminate\Support\Str::random(10)"/>
									@endcan
									@can('delete_category')
										<x-button icon="o-trash" class="btn-sm btn-ghost" wire:click="delete({{$category->id}})"
										          wire:confirm="{{__('lang.confirm_delete', ['attribute' => __('lang.category')])}}"
										          wire:loading.attr="disabled" wire:target="delete({{$category->id}})"
										          spinner="delete({{$category->id}})" tooltip="{{__('lang.delete')}}"/>
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
							{{ $categories->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</x-card>
</div>
