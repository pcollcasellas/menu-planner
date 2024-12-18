<div class="p-6" wire:ignore.self>
	<form wire:submit.prevent="save">
		<div class="mb-4">
			<x-input-label for="name">Recipe name</x-input-label>
			<x-text-input type="text" id="name" required wire:model="form.name" />
		</div>

		<div class="mb-4">
			<x-input-label for="description">Recipe description</x-input-label>
			<x-textarea type="text" id="description" wire:model="form.description" />
		</div>

		<div class="flex mb-4">
			<div class="flex-1">
				<x-input-label for="prep_time">Recipe preparation time</x-input-label>
				<x-text-input type="number" id="prep_time" wire:model="form.prep_time" />
			</div>

			<div class="flex-1">
				<x-input-label for="cooking_time">Recipe cooking time</x-input-label>
				<x-text-input type="number" id="cooking_time" required wire:model="form.cooking_time" />
			</div>
		</div>
        <hr>
        {{-- Ingredients --}}
        <div class="mb-4">

            <h2 class="py-4 text-xl bold">Ingredients</h2>

            <div class="w-full overflow-hidden overflow-x-auto rounded-md">
                <table class="w-full text-sm text-left text-neutral-600">
                    <thead class="text-sm bg-neutral-50 text-neutral-900">
                        <tr>
                            <th scope="col" class="p-4">Name</th>
                            <th scope="col" class="p-4">Quantity</th>
                            <th scope="col" class="p-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($form->ingredients as $index => $ingredient)
                            <tr class="even:bg-black/5 dark:even:bg-white/10">
                                <td class="p-1">
				                    <x-text-input-underline type="text" id="ingredient_name" wire:model="form.ingredients.{{ $index }}.name" />
                                </td>
                                <td class="p-1">
				                    <x-text-input-underline type="text" id="ingredient_quantity" wire:model="form.ingredients.{{ $index }}.quantity" />
                                </td>
                                <td class="p-1">
                                    <x-delete-icon wire:click="removeIngredient({{ $index }})" />
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="py-2 text-center">
                                <button
                                    type="button"
                                    wire:click="addIngredient"
                                    class="mt-2 text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Add Ingredient
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

		<div class="flex justify-end">
			<x-primary-button type="submit">Save</x-primary-button>
		</div>

	</form>

</div>
