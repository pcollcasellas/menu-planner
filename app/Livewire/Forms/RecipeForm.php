<?php

namespace App\Livewire\Forms;

use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RecipeForm extends Form
{
    public ?Recipe $recipe = null;

    public $name;
    public $description;
    public $user_id;
    public $prep_time;
    public $cooking_time;
    public $ingredients = [];

    public function setRecipe(?Recipe $recipe = null)
    {
        $this->recipe = $recipe;

        $this->name = $recipe->name;
        $this->description = $recipe->description;
        $this->user_id = $recipe->user_id;
        $this->prep_time = $recipe->prep_time;
        $this->cooking_time = $recipe->cooking_time;
    }

    public function save()
    {
        // dd($this);
        $this->user_id = Auth::user()->id;
        $this->validate();

        if (!$this->recipe) {
            Recipe::create($this->only(['user_id', 'name', 'description', 'prep_time', 'cooking_time']));
        } else {
            $this->recipe->update($this->only(['user_id', 'name', 'description', 'prep_time', 'cooking_time']));
        }
        $this->reset();
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'description' => ['required'],
        ];
    }
}
