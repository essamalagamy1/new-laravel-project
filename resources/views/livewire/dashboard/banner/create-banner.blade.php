<div>
	<x-button icon="o-plus" class="btn-primary btn-sm mt-2 md:mt-0" label="{{__('lang.add')}}" @click="$wire.modalAdd = true" wire:click="resetData"/>
	{{--modalAdd--}}
	<x-modal wire:model="modalAdd" title="{{__('lang.add')}}" box-class="modal-box-600">
		<x-form wire:submit="saveAdd">
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
			<div>
				<x-file wire:model="image" accept="image/*" hint="{{__('lang.click_on_image_to_change')}}" class="cursor-pointer">
				</x-file>
				<div wire:loading wire:target="image" class="mt-2">
					<x-progress class="progress-primary h-1" indeterminate />
					<p class="text-sm text-center text-primary">{{ __('lang.uploading_image') }}...</p>
				</div>
			</div>
			<x-slot:actions>
				<x-button label="{{__('lang.cancel')}}" @click="$wire.modalAdd = false"/>
				<x-button label="{{__('lang.save')}}" class="btn btn-primary"  wire:loading.attr="disabled" wire:target="saveAdd,image" type="submit" spinner/>
			</x-slot:actions>
		</x-form>
	</x-modal>
</div>
