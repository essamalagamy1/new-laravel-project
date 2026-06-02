<?php

namespace App\Livewire\Dashboard\HomeSection;

use App\Models\Banner;
use App\Models\HomeSection;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

#[Title('Home Sections')]
#[Lazy]
class HomeSectionData extends Component
{
    use Toast;

    public bool $showBannersModal = false;

    public string $bannersNameAr = '';

    public string $bannersNameEn = '';

    public array $selectedBannerIds = [];

    public bool $showSingleBannerModal = false;

    public string $singleNameAr = '';

    public string $singleNameEn = '';

    public array $selectedSingleBannerId = [];

    public $availableBanners;

    public $availableSingleBanners;

    public function placeholder(): View
    {
        return view('livewire.placeholders.page-loading');
    }

    public function mount(): void
    {
        $this->availableBanners = Banner::active()
            ->where('is_single', false)
            ->get()
            ->map(fn ($b) => ['id' => $b->id, 'name' => $b->name]);

        $this->availableSingleBanners = Banner::active()
            ->where('is_single', true)
            ->get()
            ->map(fn ($b) => ['id' => $b->id, 'name' => $b->name]);

        view()->share('breadcrumbs', $this->breadcrumbs());
    }

    public function breadcrumbs(): array
    {
        return [
            [
                'label' => __('lang.home_sections'),
                'icon' => 'o-squares-2x2',
            ],
        ];
    }

    public function toggleActive(int $id): void
    {
        $this->authorize('edit_home_section');

        $section = HomeSection::findOrFail($id);
        $section->update(['is_active' => ! $section->is_active]);

        $this->success(__('lang.updated_successfully', ['attribute' => __('lang.home_section')]));
    }

    public function updateName(int $id, string $nameAr, string $nameEn): void
    {
        $this->authorize('edit_home_section');

        $section = HomeSection::findOrFail($id);
        $section->update([
            'name' => ['ar' => $nameAr, 'en' => $nameEn],
        ]);

        $this->success(__('lang.updated_successfully', ['attribute' => __('lang.home_section')]));
    }

    public function updateSort(int $id, int $position): void
    {
        $this->authorize('edit_home_section');

        $section = HomeSection::findOrFail($id);
        $oldPosition = $section->sort;
        $newPosition = $position + 1;

        if ($oldPosition === $newPosition) {
            return;
        }

        if ($oldPosition > $newPosition) {
            HomeSection::where('sort', '>=', $newPosition)
                ->where('sort', '<', $oldPosition)
                ->increment('sort');
        } else {
            HomeSection::where('sort', '>', $oldPosition)
                ->where('sort', '<=', $newPosition)
                ->decrement('sort');
        }

        $section->update(['sort' => $newPosition]);

        $this->success(__('lang.section_order_updated'));
    }

    public function openBannersModal(): void
    {
        $this->authorize('edit_home_section');

        $this->bannersNameAr = '';
        $this->bannersNameEn = '';
        $this->selectedBannerIds = [];
        $this->showBannersModal = true;
    }

    public function addBannersSection(): void
    {
        $this->authorize('edit_home_section');

        $this->validate([
            'bannersNameAr' => 'required|string',
            'bannersNameEn' => 'required|string',
            'selectedBannerIds' => 'required|array|min:1',
        ]);

        $section = HomeSection::create([
            'type' => 'banners',
            'name' => ['ar' => $this->bannersNameAr, 'en' => $this->bannersNameEn],
            'sort' => (HomeSection::max('sort') ?? 0) + 1,
            'is_active' => true,
        ]);

        $section->banners()->sync($this->selectedBannerIds);

        $this->showBannersModal = false;
        $this->success(__('lang.created_successfully', ['attribute' => __('lang.home_section')]));
    }

    public function openSingleBannerModal(): void
    {
        $this->authorize('edit_home_section');

        $this->singleNameAr = '';
        $this->singleNameEn = '';
        $this->selectedSingleBannerId = [];
        $this->showSingleBannerModal = true;
    }

    public function addSingleBannerSection(): void
    {
        $this->authorize('edit_home_section');

        $this->validate([
            'singleNameAr' => 'required|string',
            'singleNameEn' => 'required|string',
            'selectedSingleBannerId' => 'required|array|min:1|max:1',
        ]);

        $section = HomeSection::create([
            'type' => 'single_banner',
            'name' => ['ar' => $this->singleNameAr, 'en' => $this->singleNameEn],
            'sort' => (HomeSection::max('sort') ?? 0) + 1,
            'is_active' => true,
        ]);

        $section->banners()->sync($this->selectedSingleBannerId);

        $this->showSingleBannerModal = false;
        $this->success(__('lang.created_successfully', ['attribute' => __('lang.home_section')]));
    }

    public function deleteSection(int $id): void
    {
        $this->authorize('edit_home_section');

        $section = HomeSection::findOrFail($id);

        if (! $section->hasBannerSelection()) {
            $this->error(__('lang.cannot_delete'));

            return;
        }

        $section->banners()->detach();
        $section->delete();

        $this->success(__('lang.deleted_successfully', ['attribute' => __('lang.home_section')]));
    }

    public function render(): View
    {
        $data['sections'] = HomeSection::orderBy('sort')->get();

        return view('livewire.dashboard.home-section.home-section-data', $data);
    }
}
