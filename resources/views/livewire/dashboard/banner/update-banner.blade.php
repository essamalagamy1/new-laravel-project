@php
	use App\Services\FileService;
@endphp
<div x-data="{ uploading: false }">
	<x-button icon="o-pencil" class="btn-sm btn-ghost" @click="$wire.modalUpdate = true" tooltip="{{__('lang.update')}}" wire:click="resetError"/>
	{{--modalEdit--}}
	<x-modal wire:model="modalUpdate" title="{{__('lang.update')}}" box-class="modal-box-600">
		<x-form wire:submit="saveUpdate">
			<div class="flex justify-center mb-4">
				<div>
					<x-file wire:model="image" accept="image/*" hint="{{__('lang.click_on_image_to_change')}}" class="cursor-pointer">
						<img alt="img" src="{{ $banner->getFirstMediaUrl('image') }}" class="!w-24 !h-24 rounded-lg object-cover"/>
					</x-file>
					<div wire:loading wire:target="image" class="mt-2">
						<x-progress class="progress-primary h-1" indeterminate/>
						<p class="text-sm text-center text-primary">{{ __('lang.uploading_image') }}...</p>
					</div>
				</div>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-2">
				<x-input label="{{__('lang.name_ar')}}" wire:model="name_ar"/>
				<x-input label="{{__('lang.name_en')}}" wire:model="name_en"/>
				<x-input label="{{__('lang.sort')}}" type="number" wire:model="sort"/>
				<x-input label="{{__('lang.url')}}" wire:model="url"/>
				<x-select label="{{__('lang.status')}}" wire:model="status" :options="[['id' => 'active', 'name' => __('lang.active')], ['id' => 'inactive', 'name' => __('lang.inactive')]]" option-value="id" option-label="name"/>
				<x-select label="{{__('lang.visibility')}}" wire:model="visibility" :options="[['id' => 'all', 'name' => __('lang.visibility_all')], ['id' => 'easyta3lim_only', 'name' => __('lang.visibility_easyta3lim_only')], ['id' => 'other_platforms_only', 'name' => __('lang.visibility_other_platforms_only')]]" option-value="id" option-label="name"/>
				<div class="col-span-1 md:col-span-2 flex items-center mt-2">
					<x-toggle label="{{__('lang.is_single')}}" wire:model="is_single" />
				</div>
			</div>
			<x-textarea label="{{__('lang.description_ar')}}" wire:model="description_ar" rows="3"/>
			<x-textarea label="{{__('lang.description_en')}}" wire:model="description_en" rows="3"/>
			<x-slot:actions>
				<x-button label="{{__('lang.cancel')}}" @click="$wire.modalUpdate = false"/>
				<x-button label="{{__('lang.update')}}" class="btn btn-primary" type="submit" wire:target="saveUpdate,image" spinner wire:loading.attr="disabled"/>
			</x-slot:actions>
		</x-form>
	</x-modal>
</div>
