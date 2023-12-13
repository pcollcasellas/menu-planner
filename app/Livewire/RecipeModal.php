<?php

namespace App\Livewire;

use App\Models\Recipe;
use LivewireUI\Modal\ModalComponent;

class RecipeModal extends ModalComponent
{
    public ?Recipe $recipe = null;
    public forms\RecipeForm $form;

    public function mount(Recipe $recipe = null): void
    {
        if ($recipe && $recipe->exists) {
            $this->form->setRecipe($recipe);
        }
    }

    public function render()
    {
        return view('livewire.recipe-modal');
    }

    public function save()
    {
        $this->form->save();
        $this->closeModal();
        $this->dispatch('refresh-list');
    }
}
