<div>
	<div class="mb-5 flex justify-between">
		<input class="rounded" type="date" wire:model="selectedDate" wire:change="changeDate">

		<livewire:import-template weekStartDate="{{ $startOfWeek }}" key="{{ now() }}" />
		<div>
			{{ \Carbon\Carbon::parse($startOfWeek)->format("d/m/Y") }}
			-
			{{ \Carbon\Carbon::parse($endOfWeek)->format("d/m/Y") }}
		</div>

	</div>

	<div class="flex justify-between p-2">
		<x-primary-button wire:click="shuffleDays" class="rounded bg-blue-500 px-4 text-white">
			Shuffle
		</x-primary-button>
		@if ($shuffled)
		<div class="flex items-center gap-2">
			<x-secondary-button wire:click="saveShuffleChanges">
				Save
			</x-secondary-button>
			<span wire:click="reverseShuffleChanges" class="cursor-pointer rounded px-4 text-sm text-red-500">
				Discard Changes
			</span>
		</div>
		@endif
	</div>

	<div class="flex rounded p-4">
		@foreach ($dates as $date)
		<div class="w-1/7">
			<h2 class="mb-3 border-b-4 text-center text-xl font-bold">{{ __(\Carbon\Carbon::parse($date)->format("l"))
				}}</h2>
			<table class="w-full table-fixed">
				<tbody>
					@foreach ($meals as $meal)
					<tr class="mb-2 h-44 align-top">
						<td class="relative overflow-hidden border-b">
							<div class="max-h-7">
								<div class="mb-3 text-center text-xl">{{ __($meal) }}</div>
								@foreach ($menuItems as $item)
								@if ($item['day'] == $date && $item['meal'] == $meal)
								<div class="mb-2 flex items-center text-sm">
									<span>{{ $item['recipe_name'] }}</span>
									<div wire:click="deleteMenuItem('{{ $date }}', '{{ $meal }}',{{ $item['recipe_id'] }})"
										wire:confirm="Are you sure you want to delete this recipe?"
										class="flex cursor-pointer text-red-500 hover:text-red-700">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
											stroke-width="1.5" stroke="currentColor" class="h-3 w-3">
											<path stroke-linecap="round" stroke-linejoin="round"
												d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
										</svg>
									</div>
								</div>
								@endif
								@endforeach
							</div>
							<button wire:click.live="openRecipeModal('{{$date}}', '{{ $meal }}')"
								class="absolute bottom-0 flex items-center text-sm text-gray-400" type="button">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
									stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
									<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
								</svg>
								<span>{{ __("Add recipe") }}</span>
							</button>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@endforeach
	</div>

	@if ($showModal)
	<x-modal entangle="showModal" :title='__("Select recipe")'>
		<input type="text" wire:model.live="modalSearch" wire:input.lazy="onModalChange"
			class="w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-800 sm:text-sm sm:leading-6"
			placeholder="{{ __(" Search...") }}">
		@foreach ($recipes as $recipe)
		<div class="w-full items-center justify-between border-b-2 py-3 last:border-b-0">
			<li wire:click="addMenuItem({{ $recipe->id }})" class="cursor-pointer list-none">
				<h1 class="text-xl font-bold">{{ $recipe->name }}</h1>
				<p>{{ $recipe->description }}</p>
				<div class="flex justify-between">
					<p>{{ __("Preparation time") }}: {{ $recipe->prep_time }}</p>
					<p>{{ __("Cooking time") }}: {{ $recipe->cooking_time }}</p>
				</div>
			</li>
		</div>
		@endforeach
	</x-modal>
	@endif
</div>