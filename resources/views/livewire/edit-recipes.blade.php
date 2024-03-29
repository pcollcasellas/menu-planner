<div class="p-6">
	<form wire:submit.prevent="save">
		<div class="mb-4">
			<x-input-label for="name">{{ __("Recipe name") }}</x-input-label>
			<x-text-input type="text" id="name" required wire:model="name" />
		</div>

		<div class="mb-4">
			<x-input-label for="description">{{ __("Recipe description") }}</x-input-label>
			<x-textarea type="text" id="description" required wire:model="description" />
		</div>

		<div class="mb-4 flex">
			<div class="flex-1">
				<x-input-label for="prep_time">{{ __("Recipe preparation time") }}</x-input-label>
				<x-text-input type="number" id="prep_time" required wire:model="prep_time" />
			</div>

			<div class="flex-1">
				<x-input-label for="cooking_time">{{ __("Recipe cooking time") }}</x-input-label>
				<x-text-input type="number" id="cooking_time" required wire:model="cooking_time" />
			</div>
		</div>

		<x-primary-button type="submit">{{ __("Save") }}</x-primary-button>

	</form>
</div>
