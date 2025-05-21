<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class UserData extends Component
{
	use Toast, WithPagination;

	public bool $myModal1 = false;
	public $name, $email, $password, $password_confirmation;
	public $all_user, $search, $search_user_id;

	public function mount(): void
	{
		$this->all_user = User::all()->toArray();
	}

	public function render()
	{
		$data['users'] = User::when($this->search, fn(Builder $query) => $query->where('name', $this->search))->paginate(10);
		return view('livewire.user-data', $data);
	}

	public function edit(): void
	{
		$this->success("edit");

	}

	public function delete(User $user): void
	{
		$user->delete();
		$this->success("deleted successfully");
	}

	public function save(): void
	{
		$this->validate([
			'email' => 'required|email|unique:users,email',
			'password' => 'required|min:8',
			'password_confirmation' => 'required|same:password',
			'name' => 'required|min:3',
		]);

		User::create([
			'email' => $this->email,
			'password' => bcrypt($this->password),
			'name' => $this->name,
		]);
		$this->resetExcept('all_user');
		$this->myModal1 = false;
		$this->success("User Created");
	}
}
