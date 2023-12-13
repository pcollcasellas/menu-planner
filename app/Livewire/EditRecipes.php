<?php

namespace App\Livewire;

use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\ModalComponent;

class EditRecipes extends ModalComponent
{
    public ?Recipe $recipe = null;

    public $name;
    public $description;
    public $prep_time;
    public $cooking_time;

    protected $rules = [
        'recipe.name' => 'string',
        'recipe.description' => 'string',
        'recipe.prep_time' => '',
        'recipe.cooking_time' => '',
    ];

    public function mount(Recipe $recipe = null)
    {
        if ($recipe->exists) {
            $this->setRecipe($recipe);
            dd($this->recipe);
        }
    }

    public function setRecipe(?Recipe $recipe = null)
    {
        $this->recipe = $recipe;
        $this->name = $recipe->name;
        $this->description = $recipe->description;
        $this->prep_time = $recipe->prep_time;
        $this->cooking_time = $recipe->cooking_time;
    }

    public function render()
    {
        dd($this->recipe);
        return view('livewire.edit-recipes');
    }

    public function save()
    {
        dd($this->name);
        $this->recipe->name = $this->name;
        $this->recipe->description = $this->description;
        $this->recipe->prep_time = $this->prep_time;
        $this->recipe->cooking_time = $this->cooking_time;
        $this->recipe->user_id = Auth::user()->id;
        dd($this->recipe);
        $this->validate();

        $this->recipe->save();
        $this->closeModal();
    }
}
