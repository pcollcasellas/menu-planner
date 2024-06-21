<x-app-layout>
	<x-slot name="header">
		<h2 class="text-xl font-semibold leading-tight text-gray-800">
			{{ __("Recipes") }}
		</h2>
	</x-slot>

	<div class="flex py-12">
		<div class="max-w-8xl mx-auto w-2/3 sm:px-6 lg:px-8">
			<div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
				<div class="p-6 text-gray-900">
					@livewire("show-recipes")
				</div>
			</div>
		</div>
	</div>
</x-app-layout>