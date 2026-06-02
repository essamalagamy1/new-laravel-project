<?php

namespace App\Livewire\Dashboard\Banner;

use App\Models\Banner;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class UpdateBanner extends Component
{
    use Toast, WithFileUploads;

    public bool $modalUpdate = false;

    public Banner $banner;

    public $name_ar;

    public $name_en;

    public $description_ar;

    public $description_en;

    public $image;

    public $sort;

    public $old_image;

    public $status;

    public $is_single = false;

    public $url;

    public $visibility;

    public function mount(): void
    {
        $this->name_ar = $this->banner->getTranslation('name', 'ar');
        $this->name_en = $this->banner->getTranslation('name', 'en');
        $this->description_ar = $this->banner->getTranslation('description', 'ar');
        $this->description_en = $this->banner->getTranslation('description', 'en');
        $this->old_image = $this->banner->image;
        $this->is_single = $this->banner->is_single;
        $this->status = $this->banner->status->value;
        $this->sort = $this->banner->sort;
        $this->url = $this->banner->url;
        $this->visibility = $this->banner->visibility;
    }

    public function render(): View
    {
        return view('livewire.dashboard.banner.update-banner');
    }

    public function rules(): array
    {
        return [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'required|string|max:500',
            'description_en' => 'required|string|max:500',
            'image' => 'nullable|image|max:5000|mimes:jpg,jpeg,png,gif,webp,svg',
            'is_single' => 'boolean',
            'status' => 'required|in:active,inactive',
            'sort' => 'required|integer',
            'url' => [
                'nullable',
                'url',
                'max:255',
                Rule::prohibitedIf(fn () => filled($this->course_id)),
            ],
            'visibility' => 'required|in:all,easyta3lim_only,other_platforms_only',
        ];
    }

    public function saveUpdate(): void
    {
        $this->authorize('edit_banner');
        $this->validate();
        $this->banner->update([
            'sort' => $this->sort,
            'name' => [
                'ar' => $this->name_ar,
                'en' => $this->name_en,
            ],
            'description' => [
                'ar' => $this->description_ar,
                'en' => $this->description_en,
            ],
            'is_single' => $this->is_single ? true : false,
            'status' => $this->status,
            'url' => $this->url,
            'visibility' => $this->visibility,
        ]);
        if ($this->image) {
            $this->banner->addMedia($this->image->getRealPath())->toMediaCollection('image');
        }

        $this->modalUpdate = false;
        $this->dispatch('render')->component(BannerData::class);
        $this->success(__('lang.updated_successfully', ['attribute' => __('lang.banner')]));
    }

    public function resetError(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
