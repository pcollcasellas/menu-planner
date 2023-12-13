<div class="p-6" wire:ignore.self>
	<form wire:submit.prevent="save">
		<div class="mb-4">
			<x-input-label for="name">Recipe name</x-input-label>
			<x-text-input type="text" id="name" required wire:model="form.name" />
		</div>

		<div class="mb-4">
			<x-input-label for="description">Recipe description</x-input-label>
			<x-textarea type="text" id="description" required wire:model="form.description" />
		</div>

		<div class="mb-4 flex">
			<div class="flex-1">
				<x-input-label for="prep_time">Recipe preparation time</x-input-label>
				<x-text-input type="number" id="prep_time" required wire:model="form.prep_time" />
			</div>

			<div class="flex-1">
				<x-input-label for="cooking_time">Recipe cooking time</x-input-label>
				<x-text-input type="number" id="cooking_time" required wire:model="form.cooking_time" />
			</div>
		</div>

		<div class="flex justify-end">
			@if (!!$recipe)
				<button class="mr-4 text-red-500" x-on:click="if (confirm('Are you sure?')) $wire.delete()">Delete recipe</button>
			@endif
			<x-primary-button type="submit">Save</x-primary-button>
		</div>

	</form>

</div>
