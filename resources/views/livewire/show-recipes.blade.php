<div>
	<div class="item-center flex justify-between">
		<input type="text" wire:model.live="search"
			class="rounded-md border-0 py-1.5 pl-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-800 sm:text-sm sm:leading-6"
			placeholder="Search...">
		<div class="flex cursor-pointer justify-end"
			wire:click="$dispatch('openModal', { component: 'recipe-modal' })">
			<span class="mr-2">New recipe</span>
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
				stroke="currentColor" class="h-6 w-6">
				<path stroke-linecap="round" stroke-linejoin="round"
					d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
			</svg>
		</div>
	</div>
	<ul>
		@foreach ($recipes as $recipe)
			<div class="flex items-center justify-between border-b-2 py-3 last:border-b-0">
				<li wire:sortable.handle>
					<div
						wire:click="$dispatch('openModal', { component: 'recipe-modal', arguments: {recipe: {{ $recipe }}} })">
						<h1 class="cursor-pointer text-xl">{{ $recipe->name }}</h1>
					</div>
					<p>{{ $recipe->description }}</p>
					<p>Preparation time: {{ $recipe->prep_time }}</p>
					<p>Cooking time: {{ $recipe->cooking_time }}</p>
				</li>
				<div wire:click="delete({{ $recipe->id }})"
					wire:confirm="Are you sure you want to delete this recipe?"
					class="flex cursor-pointer text-red-500 hover:text-red-700">
					<span class="mr-2">Delete recipe</span>
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
						stroke="currentColor" class="h-6 w-6">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
					</svg>
				</div>
			</div>
		@endforeach
	</ul>
</div>
