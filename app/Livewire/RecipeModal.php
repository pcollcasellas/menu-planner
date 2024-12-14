<?php

namespace App\Livewire;

use App\Models\Recipe;
use LivewireUI\Modal\ModalComponent;

class RecipeModal extends ModalComponent
{
    public ?Recipe $recipe = null;
    public Forms\RecipeForm $form;

    public array $ingredients = [['name' => '', 'quantity' => '']];


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

    public function addIngredient()
    {
        $this->ingredients[] = ['name' => '', 'quantity' => ''];
    }

    public function removeIngredient($index)
    {
        // Remove ingredient by index
        unset($this->ingredients[$index]);
        // Re-index array to prevent gaps
        $this->ingredients = array_values($this->ingredients);
    }

    public function save()
    {
        $this->form->save();
        $this->closeModal();
        $this->dispatch('refresh-list');
    }
}
