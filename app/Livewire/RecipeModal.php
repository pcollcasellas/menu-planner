<?php

namespace App\Livewire;

use App\Models\Recipe;
use LivewireUI\Modal\ModalComponent;

class RecipeModal extends ModalComponent
{
    public ?Recipe $recipe = null;
    public Forms\RecipeForm $form;

    public function mount(Recipe $recipe = null): void
    {
        if ($recipe && $recipe->exists) {
            $ingredients = $recipe->ingredients;

            // Create an array to store the desired format
            $ingredientsArray = $ingredients->map(function ($ingredient) {
                return [
                    'name' => $ingredient->name,
                    'quantity' => $ingredient->pivot->quantity,
                ];
            })->toArray();

            $this->form->ingredients = $ingredientsArray;
            $this->form->setRecipe($recipe);
        } else {
            $this->form->ingredients = [['name' => '', 'quantity' => '']];
        }
    }

    public function render()
    {
        return view('livewire.recipe-modal');
    }

    public function addIngredient()
    {
        $this->form->ingredients[] = ['name' => '', 'quantity' => ''];
    }

    public function removeIngredient($index)
    {
        unset($this->form->ingredients[$index]);
        // Re-index array to prevent gaps
        $this->form->ingredients = array_values($this->form->ingredients);
    }

    public function save()
    {
        $this->form->save();
        $this->closeModal();
        $this->dispatch('refresh-list');
    }
}
