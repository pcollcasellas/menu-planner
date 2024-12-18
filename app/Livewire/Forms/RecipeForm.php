<?php

namespace App\Livewire\Forms;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\DB;


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
        DB::transaction(function () {
            $this->user_id = Auth::user()->id;
            $this->validate();

            if (!$this->recipe) {
                $this->recipe = Recipe::create($this->only(['user_id', 'name', 'description', 'prep_time', 'cooking_time']));
            } else {
                $this->recipe->update($this->only(['user_id', 'name', 'description', 'prep_time', 'cooking_time']));
            }
            foreach ($this->ingredients as $ingredientData) {
                $ingredientName = strtolower($ingredientData['name']);
                $quantity = strtolower($ingredientData['quantity']); // Assuming quantity is stored as a string

                // Step 3: Check if ingredient exists, if not, create it
                $ingredient = Ingredient::firstOrCreate(
                    ['name' => $ingredientName], // Search by the 'name' of the ingredient
                    ['name' => $ingredientName]  // Create with 'name' if not found
                );

                // Step 4: Prepare the pivot data (ingredient ID and quantity)
                $ingredientsData[$ingredient->id] = [
                    'quantity' => $quantity
                ];
            }
            $this->recipe->ingredients()->sync($ingredientsData);
        });
    }

    public function rules()
    {
        return [
            'name' => ['required'],
        ];
    }
}
