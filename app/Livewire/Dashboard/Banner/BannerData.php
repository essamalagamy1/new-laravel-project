<?php

namespace App\Livewire\Dashboard\Banner;

use App\Models\Banner;
use App\Models\Course;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Title('banners')]
#[Lazy]
class BannerData extends Component
{
    use Toast, WithPagination;

    public $search_banner_id;

    public $filter_status;


    public $filter_visibility = 'all_states';

    public function placeholder(): View
    {
        return view('livewire.placeholders.page-loading');
    }

    public function mount(): void
    {
        view()->share('breadcrumbs', $this->breadcrumbs());
    }

    public function breadcrumbs(): array
    {
        return [
            [
                'label' => __('lang.banners'),
                'icon' => 'o-photo',
            ],
        ];
    }

    #[On('render')]
    public function render(): View
    {
        $data['banners'] = Banner::when($this->search_banner_id, fn (Builder $query) => $query->where('id', $this->search_banner_id))
            ->when($this->filter_status, fn (Builder $query) => $query->where('status', $this->filter_status))
            ->when($this->filter_visibility && $this->filter_visibility !== 'all_states', fn (Builder $query) => $query->where('visibility', $this->filter_visibility))
            ->orderByRaw('COALESCE(sort, 999999) ASC')
            ->paginate(20);

        return view('livewire.dashboard.banner.banner-data', $data);
    }

    public function delete($id): void
    {
        $this->authorize('delete_banner');
        $banner = Banner::findOrFail($id);

        // Delete image using Media Library
        $banner->clearMediaCollection('image');

        $banner->delete();
        $this->success(__('lang.deleted_successfully', ['attribute' => __('lang.banner')]));
    }
}
