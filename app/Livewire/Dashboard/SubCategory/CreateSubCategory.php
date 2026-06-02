<?php

namespace App\Livewire\Dashboard\SubCategory;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class CreateSubCategory extends Component
{
    use Toast, WithFileUploads;

    public bool $modalAdd = false;

    public $name_ar;

    public $name_en;

    public $image;

    public $parent_id;

    public $status = 'inactive';

    public $all_categories;

    public $visibility = 'all';

    public function render(): View
    {
        return view('livewire.dashboard.sub-category.create-sub-category');
    }

    public function rules(): array
    {
        return [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'parent_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:5000|mimes:svg',
            'status' => 'required|in:active,inactive',
            'visibility' => 'required|in:all,easyta3lim_only,other_platforms_only',
        ];
    }

    public function saveAdd(): void
    {
        $this->authorize('create_subcategory');
        $this->validate();
        $category = Category::create([
            'name' => [
                'ar' => $this->name_ar,
                'en' => $this->name_en,
            ],
            'parent_id' => $this->parent_id,
            'status' => $this->status,
            'visibility' => $this->visibility,
        ]);
        if ($this->image) {
            $category->addMedia($this->image->getRealPath())->toMediaCollection('image');
        }
        $this->modalAdd = false;
        $this->dispatch('render')->component(SubCategoryData::class);
        $this->success(__('lang.added_successfully', ['attribute' => __('lang.subcategory')]));
    }

    public function resetData(): void
    {
        $this->reset(['name_ar', 'name_en', 'image', 'parent_id', 'status', 'visibility']);
        $this->status = 'inactive';
        $this->visibility = 'all';
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
