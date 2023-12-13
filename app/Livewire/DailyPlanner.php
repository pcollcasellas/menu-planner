<?php

namespace App\Livewire;

use App\Models\MenuItem;
use App\Models\Recipe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use SebastianBergmann\Type\FalseType;

class DailyPlanner extends Component
{
    public $date;
    public $meals = ['Lunch', 'Dinner'];
    public $menu;

    public $showModal;
    public $currentMeal;
    public $recipes;
    public $modalSearch;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount($date)
    {
        // Fetch menu items from the database for the selected date
        $this->menu = MenuItem::where('day', $date)->get();

        $this->date = $date;
    }

    public function refresh()
    {
        $this->menu = MenuItem::where('day', $this->date)->get();
    }

    public function render()
    {
        return view('livewire.daily-planner');
    }

    public function openRecipeModal($meal)
    {
        $this->currentMeal = $meal;
        $this->recipes = Recipe::where('user_id', Auth::user()->id)->get();
        $this->showModal = True;
    }

    public function onModalChange()
    {
        $search = '%' . $this->modalSearch . '%';
        $this->recipes = Recipe::where('user_id', Auth::user()->id)
            ->where(function ($query) use ($search) {
                $query->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('prep_time', 'like', '%' . $search . '%')
                    ->orWhere('cooking_time', 'like', '%' . $search . '%');
            })
            ->get();
    }

    public function addMenuItem($recipe_id)
    {
        $menuItem = new MenuItem([
            'user_id' => Auth::user()->id,
            'recipe_id' => $recipe_id,
            'meal' => $this->currentMeal,
            'day' => $this->date,
            'order' => 5
        ]);
        $menuItem->save();
        $this->modalSearch = '';
        $this->showModal = false;
        $this->refresh();
    }

    public function deleteMenuItem($meal, $recipe_id)
    {
        $menuItem = MenuItem::where('user_id', Auth::user()->id)
            ->where('meal', $meal)
            ->where('recipe_id', $recipe_id)
            ->first();
        $menuItem->delete();
        $this->refresh();
    }
}
