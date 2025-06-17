<x-menu activate-by-route>
	<x-menu-item title="Home" icon="o-home" link="{{route('dashboard')}}" wire:navigate/>
	<x-menu-item title="Users" icon="o-users" link="{{route('users')}}" wire:navigate/>
</x-menu>