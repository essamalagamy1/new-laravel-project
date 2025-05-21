<div>
	<div class="flex items-center justify-between mb-4">
		<h1 class="text-2xl font-bold">Users</h1>
		<x-button icon="o-plus" class="btn-primary btn-sm" label="New User" @click="$wire.myModal1 = true"></x-button>
	</div>
	<div class="grid grid-cols-2 gap-4 mb-4">
		<x-input label="user name" placeholder="Search" wire:model.live="search" class="font-bold"/>
		<x-choices-offline label="user select" wire:model.live="search_user_id"
				:options="$all_user" placeholder="Search ..." single clearable searchable option-value="id" option-label="name" option-sub-label="email"/>
	</div>






	<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
		<div class="overflow-x-auto">
			<table class="table">
				<thead class="min-w-full divide-y bg-base-300 text-base-content">
				<tr>
					<th>#</th>
					<th>id</th>
					<th>Name</th>
					<th>Email</th>
					<th>action</th>
				</tr>
				</thead>
				<tbody>
				@forelse($users as $user)
					<tr class="bg-base-200">
						<th>{{$users->firstItem() + $loop->index}}</th>
						<th>user-{{$user->id}}</th>
						<td>{{$user->name}}</td>
						<td>{{$user->email}}</td>
						<td>
							<div class="flex gap-2">
								<x-button icon="o-pencil" class="btn-sm btn-ghost" wire:click="edit({{$user->id}})" wire:navigate spinner tooltip="Edit"/>
								<x-button icon="o-trash" class="btn-sm btn-ghost" wire:click="delete({{$user->id}})" wire:navigate spinner
								          tooltip="Delete" wire:confirm="Are you sure you want to delete this user?"/>
							</div>
						</td>
					</tr>
				@empty
					<tr class="bg-base-200">
						<th colspan="5" class="text-center">No users found</th>
					</tr>
				@endforelse
				</tbody>
			</table>
			<div class="flex items-center justify-between px-4 py-3 bg-base-300 text-base-content sm:px-6">
				<div class="flex w-full items-center justify-between">
					<div class="w-full flex-none">
						{{ $users->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>

	<x-modal wire:model="myModal1" title="New User">
		<form wire:submit.prevent="save">
			<div class="flex flex-col gap-4">
				<x-input label="Name" placeholder="Name" wire:model="name"/>
				<x-input label="Email" placeholder="Email" wire:model="email"/>
				<x-input label="Password" type="password" placeholder="Password" wire:model="password"/>
				<x-input label="Password Confirmation" type="password" placeholder="Password Confirmation" wire:model="password_confirmation"/>
			</div>
			<x-slot:actions>
				<x-button label="Cancel" @click="$wire.myModal1 = false"/>
				<x-button label="Save" class="btn-primary" wire:click="save" wire:loading.attr="disabled" type="submit"/>
			</x-slot:actions>
		</form>
	</x-modal>
</div>