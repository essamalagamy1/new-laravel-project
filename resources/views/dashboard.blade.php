<x-layouts.maryui.app>
	<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
		<div class="grid auto-rows-min gap-4 grid-cols-2 sm:grid-cols-28 md:grid-cols-4  lg:grid-cols-4">
			<div class="relative h-auto overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
				<x-stat title="Messages" value="44" icon="o-envelope" tooltip="Hello" color="text-primary"/>
			</div>
			<div class="relative h-auto overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
				<x-stat title="Messages" value="44" icon="o-envelope" tooltip="Hello" color="text-primary"/>
			</div>
			<div class="relative h-auto overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
				<x-stat title="Messages" value="44" icon="o-envelope" tooltip="Hello" color="text-primary"/>
			</div>
			<div class="relative h-auto overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
				<x-stat title="Messages" value="44" icon="o-envelope" tooltip="Hello" color="text-primary"/>
			</div>
		</div>


		<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
			<div class="overflow-x-auto">
				<table class="table">
					<!-- head -->
					<thead class="bg-base-300 text-base-content">
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Job</th>
						<th>Favorite Color</th>
						<th>action</th>
					</tr>
					</thead>
					<tbody>
					<!-- row 1 -->
					<tr class="bg-base-200">
						<th>1</th>
						<td>Cy Ganderton</td>
						<td>Quality Control Specialist</td>
						<td>Blue</td>
						<td>
							<div class="flex gap-2">
								<x-button icon="o-pencil" link="###" class="btn-sm btn-ghost"/>
								<x-button icon="o-trash" link="###" class="btn-sm btn-ghost"/>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>

	</div>

</x-layouts.maryui.app>