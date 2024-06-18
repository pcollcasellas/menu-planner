<div>
    <div wire:click.live="openImportTemplateModal" class="flex text-bold items-center cursor-pointer">
        <span class="mr-2">Import Template</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6 h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
    </div>

    @if ($showModal)
    <x-modal entangle="showModal" :title='__("Select template")'>
        <input type="text" wire:model.live="modalSearch" wire:input.lazy="onModalChange"
            class="w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-800 sm:text-sm sm:leading-6"
            placeholder="{{ __(" Search...") }}">
        @foreach ($templates as $template)
        <div class="w-full items-center justify-between border-b-2 py-3 last:border-b-0">
            <li wire:click="addMenuTemplate({{ $template->id }})" class="cursor-pointer list-none">
                <h1 class="text-xl font-bold">{{ $template->title }}</h1>
            </li>
        </div>
        @endforeach
    </x-modal>
    @endif
</div>