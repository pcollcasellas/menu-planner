<div>
	<div class="flex flex-col items-center justify-between mb-5 text-center sm:flex-row">
		<input class="rounded" type="date" wire:model="selectedDate" wire:change="changeDate">

		<livewire:import-template weekStartDate="{{ $startOfWeek }}" key="{{ now() }}" />
		<div>
			{{ \Carbon\Carbon::parse($startOfWeek)->format("d/m/Y") }}
			-
			{{ \Carbon\Carbon::parse($endOfWeek)->format("d/m/Y") }}
		</div>

	</div>

	<div class="flex justify-between p-2">
		<x-primary-button wire:click="shuffleDays" class="px-4 text-white bg-blue-500 rounded">
			{{ __("Shuffle") }}
		</x-primary-button>
		@if ($shuffled)
		<div class="flex items-center gap-2">
			<x-secondary-button wire:click="saveShuffleChanges">
				{{ __('Save') }}
			</x-secondary-button>
			<span wire:click="reverseShuffleChanges" class="px-4 text-sm text-red-500 rounded cursor-pointer">
				{{ __("Discard Changes") }}
			</span>
		</div>
		@endif
	</div>

    <div class="flex flex-col p-4 rounded sm:flex-row">
		@foreach ($dates as $date)
		<div class="w-1/7">
			<h2 class="mb-3 text-xl font-bold text-center border-b-4">{{ __(\Carbon\Carbon::parse($date)->format("l"))
				}}</h2>
			<table class="w-full border-collapse table-fixed">
				<tbody>
					@foreach ($meals as $meal)
					<tr class="mb-2 align-top sm:mb-4">
						<td class="relative border-b">
							<!-- Wrapping container for dynamic height -->
                            <div class="flex flex-col justify-between sm:min-h-8 shrink-0">
                                <div class="mb-3 text-xl text-center">{{ __($meal) }}</div>
                                <!-- Scrollable content for menu items -->
                                <div class="overflow-auto max-h-96">
                                    @foreach ($menuItems as $item)
                                        @if ($item['day'] == $date && $item['meal'] == $meal)
                                        <div class="flex items-center mb-2 text-sm">
                                            <span>{{ $item['recipe_name'] }}</span>
                                            <div wire:click="deleteMenuItem('{{ $date }}', '{{ $meal }}',{{ $item['recipe_id'] }})"
                                                wire:confirm="Are you sure you want to delete this recipe?">
                                                <x-delete-icon />
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
							</div>
                            <div class="flex items-center justify-center">
                                <button wire:click.live="openRecipeModal('{{$date}}', '{{ $meal }}')"
                                    class="flex items-center text-sm text-gray-400" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                    </svg>
                                    <span>{{ __("Add recipe") }}</span>
                                </button>
                            </div>
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
		<div class="items-center justify-between w-full py-3 border-b-2 last:border-b-0">
			<li wire:click="addMenuItem({{ $recipe->id }})" class="list-none cursor-pointer">
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
