<div class="p-6" wire:ignore.self>
    <form wire:submit.prevent="save" class="flex-col items-center justify-center">

        <x-input-label for="title" class="w-full">Title</x-input-label>
        <x-text-input type="text" id="title" class="w-full mb-4" required wire:model="form.title" />

        <x-primary-button type="submit" class="flex items-center justify-center w-full">Save</x-primary-button>
    </form>
</div>
