<?php

namespace App\Livewire;

use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowRecipes extends Component
{
    public $recipes;
    public $search;

    #[On('refresh-list')]
    public function refresh()
    {
        $this->recipes = Recipe::where('user_id', Auth::user()->id)->get();
    }

    public function mount()
    {
        $this->recipes = Recipe::where('user_id', Auth::user()->id)->get();
    }

    public function render()
    {
        $search = '%' . $this->search . '%';
        $this->recipes = Recipe::where('user_id', Auth::user()->id)
            ->where(function ($query) use ($search) {
                $query->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('prep_time', 'like', '%' . $search . '%')
                    ->orWhere('cooking_time', 'like', '%' . $search . '%');
            })
            ->get();
        return view('livewire.show-recipes');
    }

    public function delete($recipe_id)
    {
        $recipe = Recipe::where('id', $recipe_id)->first();
        $recipe->delete();
        $this->refresh();
    }
}
