<div>
	<div class="item-center flex justify-between">
		<input type="text" wire:model.live="search"
			class="rounded-md border-0 py-1.5 pl-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-800 sm:text-sm sm:leading-6"
			placeholder="{{ __(" Search...") }}">
		<div class="flex cursor-pointer items-center justify-end"
			wire:click="$dispatch('openModal', { component: 'recipe-modal' })">
			<span class="mr-2">{{ __("New recipe") }}</span>
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
				<p>{{ __("Preparation time") }}: {{ $recipe->prep_time }}</p>
				<p>{{ __("Cooking time") }}: {{ $recipe->cooking_time }}</p>
			</li>
			<div class="inline-flex-1 min-w-max text-sm">
				<div wire:click="$dispatch('openModal', { component: 'recipe-modal', arguments: {recipe: {{ $recipe }}} })"
					class="mb-2 flex cursor-pointer items-center justify-end">
					<span class="mr-2">{{ __("Edit recipe") }}</span>
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
						stroke="currentColor" class="h-6 w-6">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
					</svg>
				</div>
				<div wire:click="delete({{ $recipe->id }})" wire:confirm="{{ __(" Are you sure you want to delete this
					recipe?") }}" class="flex cursor-pointer justify-end text-xs text-red-500 hover:text-red-700">
					<span class="mr-2">{{ __("Delete recipe") }}</span>
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
						stroke="currentColor" class="h-4 w-4">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
					</svg>
				</div>
			</div>
		</div>
		@endforeach
	</ul>
</div>