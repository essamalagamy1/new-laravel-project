<?php

namespace App\Livewire\Dashboard\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Title('users')]
#[Lazy]
class UserData extends Component
{
    use Toast, WithPagination;

    public $all_user;

    public $search_user_id;

    public $filter_has_code = 'all';

    public function placeholder(): View
    {
        return view('livewire.placeholders.page-loading');
    }

    public function mount(): void
    {
        $user = auth()->user();

        // Instructors / assistants see only their own students
        $instructorCode = null;
        if ($user->hasRole('instructor')) {
            $instructorCode = $user->instructor_code;
        } elseif ($user->isAssistant() && $user->instructorOwner) {
            $instructorCode = $user->instructorOwner->instructor_code;
        }

        $this->all_user = User::role('user')
            ->when($instructorCode, fn ($q) => $q->where('student_instructor_code', $instructorCode))
            ->get(['id', 'name', 'email'])
            ->toArray();

        view()->share('breadcrumbs', $this->breadcrumbs());
    }

    public function breadcrumbs(): array
    {
        return [
            [
                'label' => __('lang.users'),
                'icon' => 'o-users',
            ],
        ];
    }

    #[On('render')]
    public function render(): View
    {
        $user = auth()->user();

        // Determine if we should scope to a specific instructor_code
        $instructorCode = null;
        if ($user->hasRole('instructor')) {
            $instructorCode = $user->instructor_code;
        } elseif ($user->isAssistant() && $user->instructorOwner) {
            $instructorCode = $user->instructorOwner->instructor_code;
        }

        $data['users'] = User::role('user')
            ->when($instructorCode, fn (Builder $query) => $query->where('student_instructor_code', $instructorCode))
            ->when($this->search_user_id, fn (Builder $query) => $query->where('id', $this->search_user_id))
            ->when($this->filter_has_code === 'yes', fn (Builder $query) => $query->whereNotNull('student_instructor_code')->where('student_instructor_code', '!=', ''))
            ->when($this->filter_has_code === 'no', fn (Builder $query) => $query->where(fn ($q) => $q->whereNull('student_instructor_code')->orWhere('student_instructor_code', '')))
            ->with(['media', 'studentInstructor'])
            ->latest()
            ->paginate(10);

        return view('livewire.dashboard.user.user-data', $data);
    }

    public function delete($id): void
    {
        $this->authorize('delete_user');
        User::findOrFail($id)->delete();
        $this->success(__('lang.deleted_successfully', ['attribute' => __('lang.user')]));
    }

    public function resetDevice($id): void
    {
        $this->authorize('edit_user');
        $user = User::findOrFail($id);
        $user->update(['device_id' => null]);
        $this->success(__('lang.device_reset_successfully'));
    }
}
