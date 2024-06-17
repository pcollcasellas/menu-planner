<div>
    <div class="mb-5 flex justify-between">
        @if( count($templates) > 0)
        <select wire:model.live="selectedTemplateId"class="select max-w-xs">
            @foreach ($templates as $template)
                <option value="{{ $template->id }}">{{$template->title}}
                </option>
            @endforeach
        </select>
        @endif

        <div class="flex cursor-pointer justify-end"
            wire:click="$dispatch('openModal', { component: 'menu-template-modal' })">
            <span class="mr-2">{{ __("New template") }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>

    <div class="flex rounded p-4">
        @if (count($templates)>0)
            @foreach ($days as $day)
            <div class="w-1/7">
                <livewire:daily-planner-template day="{{$day}}" menuTemplateId="{{$selectedTemplateId}}" key="{{ now() }}" />
            </div>
            @endforeach
        @else No templates
        @endif
    </div>
</div>

