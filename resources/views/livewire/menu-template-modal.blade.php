<div class="p-6" wire:ignore.self>
    <form wire:submit.prevent="save">
        <div class="mb-4">
            <x-input-label for="title">Title</x-input-label>
            <x-text-input type="text" id="title" required wire:model="form.title" />
        </div>

        <div class="flex justify-end">
            <x-primary-button type="submit">Save</x-primary-button>
        </div>
    </form>
</div>