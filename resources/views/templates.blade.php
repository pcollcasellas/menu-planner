<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __("Templates") }}
        </h2>
    </x-slot>

    <div class="flex py-12">
        <div class="w-2/3">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @livewire("weekly-planner-template")
                    </div>
                </div>
            </div>
        </div>
        <div class="mr-8 h-full w-1/3 rounded bg-white p-6">
            @livewire("show-recipes")
        </div>
    </div>
</x-app-layout>