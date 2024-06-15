<?php

namespace App\Livewire;

use App\Models\MenuTemplateItem;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DailyPlannerTemplate extends Component
{
    public $meals = ['Lunch', 'Dinner'];
    public $menuTemplateId;
    public $menuTemplate;
    public $day;

    public $showModal;
    public $currentMeal;
    public $recipes;
    public $modalSearch;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount($day, $menuTemplateId)
    {
        $this->menuTemplateId = $menuTemplateId;
        $this->menuTemplate = MenuTemplateItem::where([['menu_template_id', $menuTemplateId], ['day', $day]])->get();
        $this->day = $day;
    }

    public function refresh()
    {
        $this->menuTemplate = MenuTemplateItem::where([['menu_template_id', $this->menuTemplateId], ['day', $this->day]])->get();
    }

    public function render()
    {
        return view('livewire.daily-planner-template');
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

    public function addMenuTemplateItem($recipe_id)
    {

        $MenuTemplateItem = new MenuTemplateItem([
            'menu_template_id' => $this->menuTemplateId,
            'recipe_id' => $recipe_id,
            'meal' => $this->currentMeal,
            'day' => $this->day,
            'order' => 5
        ]);
        $MenuTemplateItem->save();
        $this->modalSearch = '';
        $this->showModal = false;
        $this->refresh();
    }

    public function deleteMenuTemplateItem($itemId)
    {
        $MenuTemplateItem = MenuTemplateItem::where('id', $itemId)
            ->where('menu_template_id', $this->menuTemplateId)
            ->first();
        $MenuTemplateItem->delete();
        $this->refresh();
    }
}
