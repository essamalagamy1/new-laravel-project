<?php

namespace App\Livewire\Dashboard\Category;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class CreateCategory extends Component
{
    use Toast, WithFileUploads;

    public bool $modalAdd = false;

    public $name_ar;

    public $name_en;

    public $image;

    public $status = 'inactive';

    public $visibility = 'all';

    public function render(): View
    {
        return view('livewire.dashboard.category.create-category');
    }

    public function rules(): array
    {
        return [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'image' => 'nullable|max:5000|mimes:svg',
            'status' => 'required|in:active,inactive',
            'visibility' => 'required|in:all,easyta3lim_only,other_platforms_only',
        ];
    }

    public function saveAdd(): void
    {
        $this->authorize('create_category');
        $this->validate();
        $category = Category::create([
            'name' => [
                'ar' => $this->name_ar,
                'en' => $this->name_en,
            ],
            'status' => $this->status,
            'parent_id' => null,
            'visibility' => $this->visibility,
        ]);
        if ($this->image) {
            $category->addMedia($this->image->getRealPath())->toMediaCollection('image');
        }
        $this->modalAdd = false;
        $this->dispatch('render')->component(CategoryData::class);
        $this->success(__('lang.added_successfully', ['attribute' => __('lang.category')]));
    }

    public function resetData(): void
    {
        $this->reset(['name_ar', 'name_en', 'image', 'status', 'visibility']);
        $this->status = 'inactive';
        $this->visibility = 'all';
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
