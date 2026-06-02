<?php

namespace App\Livewire\Dashboard;

use App\Enums\EnrollmentStatus;
use App\Enums\WalletTransactionType;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('home')]
#[Lazy]
class Dashboard extends Component
{


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
                'label' => __('lang.home'),
                'icon' => 'o-home',
            ],
        ];
    }


    public function render(): View
    {
        return view('livewire.dashboard.dashboard');
    }
}
