<?php

namespace App\Livewire;

use App\Models\MenuTemplate;
use LivewireUI\Modal\ModalComponent;


class MenuTemplateModal extends ModalComponent
{
    public ?MenuTemplate $menuTemplate = null;
    public Forms\MenuTemplateForm $form;

    public function mount(MenuTemplate $menuTemplate = null): void
    {
        if ($menuTemplate && $menuTemplate->exists) {
            $this->form->setMenuTemplate($menuTemplate);
        }
    }

    public function render()
    {
        return view('livewire.menu-template-modal');
    }

    public function save()
    {
        $this->form->save();
        $this->closeModal();
        $this->dispatch('refresh-list');
    }
}
