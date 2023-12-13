@props(["entangle"])
<div x-data="{
    show: @entangle($entangle)
}" x-show="show" x-on:keydown.escape.window="show = false" x-cloak>
	<div class="fixed inset-0 z-10 overflow-y-auto">
		<div
			class="flex min-h-screen items-center justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">

			<div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false"
				x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
				x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
				x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
				<div class="absolute inset-0 bg-gray-500 opacity-75"></div>
			</div>

			<span class="hidden sm:inline-block sm:h-screen sm:align-middle"></span>&#8203;

			<div
				class="@isset($attributes["modalid"]) id="{{ $attributes["modalid"] }}" @endisset role= absolute left-0 right-0 top-0 mx-auto mt-5 transform rounded-lg bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-lg"dialog"
				aria-modal="true" aria-labelledby="modal-headline" x-transition:enter="ease-out duration-300"
				x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
				x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
				x-transition:leave="ease-in duration-200"
				x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
				x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

				@isset($attributes["title"])
					<div class="flex justify-between bg-black p-4">
						<h3 class="font-bold text-white">{{ $attributes["title"] }}</h3>
						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer"
							x-on:click="show = false" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M6 18L18 6M6 6l12 12" />
						</svg>
					</div>
				@endisset
				<div class="bg-white px-4 pb-4 pt-4">
					{{ $slot }}
				</div>

				@isset($footer)
					<div class="bg-gray-100 p-4">
						{{ $footer }}
					</div>
					@endif

				</div>
			</div>
		</div>
	</div>
