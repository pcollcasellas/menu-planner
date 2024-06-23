<?php

namespace App\Livewire;

use App\Models\MenuItem;
use App\Models\Recipe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WeeklyPlanner extends Component
{
    public $startOfWeek;
    public $endOfWeek;
    public $dates = [];
    public $selectedDate;
    public $meals = ['Lunch', 'Dinner'];
    
    public $menuItems;

    public $showModal;
    public $recipes;
    public $currentDate;
    public $currentMeal;
    public $modalSearch;

    public $shuffled;
    public $shuffledMenuItems;


    protected $listeners = ['refresh-menu-items' => 'getMenuItems'];

    public function mount($selectedDate = null)
    {
        $this->selectedDate = $selectedDate ? Carbon::parse($selectedDate) : Carbon::now();
        $this->generateWeekDates();
        $this->getMenuItems();
    }

    public function generateWeekDates()
    {
        $this->startOfWeek= $this->selectedDate->copy()->startOfWeek();
        $this->endOfWeek = $this->selectedDate->copy()->endOfWeek();
        $this->dates = [];
        $currentDate = $this->startOfWeek->copy();
        while ($currentDate->lte($this->endOfWeek)) {
            $this->dates[] = $currentDate->toDateString();
            $currentDate->addDay();
        }
        $this->selectedDate = $this->selectedDate->format('Y-m-d');
    }

    public function getMenuItems()
    {
        $this->menuItems = [];
        $menuItems = MenuItem::whereBetween('day', [$this->startOfWeek, $this->endOfWeek])->get();
        
        foreach($menuItems as $menuItem)
        {
            $this->menuItems[] = [
                'id' => $menuItem->id,
                'day' => $menuItem->day,
                'meal' => $menuItem->meal,
                'recipe_id' => $menuItem->recipe_id,
                'recipe_name' => $menuItem->recipe->name
            ];
        }
    }

    public function render()
    {
        return view('livewire.weekly-planner');
    }

    public function changeDate()
    {
        $this->startOfWeek = Carbon::parse($this->selectedDate)->startOfWeek();
        $this->endOfWeek = $this->startOfWeek->copy()->endOfWeek();

        $this->dates = [];
        $currentDate = $this->startOfWeek->copy();
        while ($currentDate->lte($this->endOfWeek)) {
            $this->dates[] = $currentDate->toDateString();
            $currentDate->addDay();
        }
        $this->getMenuItems();
    }

    public function addMenuItem($recipe_id)
    {
        $menuItem = new MenuItem([
            'user_id' => Auth::user()->id,
            'recipe_id' => $recipe_id,
            'meal' => $this->currentMeal,
            'day' => $this->currentDate,
            'order' => 5
        ]);
        $menuItem->save();
        $this->modalSearch = '';
        $this->showModal = false;
        $this->getMenuItems();
    }

    public function deleteMenuItem($date, $meal, $recipe_id)
    {
        $menuItem = MenuItem::where([
            ['user_id', Auth::id()],
            ['day', $date],
            ['meal', $meal],
            ['recipe_id', $recipe_id]
        ])->first();

        $menuItem->delete();
        $this->getMenuItems();
    }


    /**************************
        RECIPES MODAL
    **************************/
    public function openRecipeModal($date, $meal)
    {
        $this->currentDate = $date;
        $this->currentMeal = $meal;
        $this->recipes = Recipe::where('user_id', Auth::id())->get();
        $this->showModal = true;
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


    /**************************
        SHUFFLE
    **************************/
    public function shuffleDays()
    {
        // Shuffle the dates array
        $shuffledDates = $this->dates;
        shuffle($shuffledDates);

        // Create a mapping from old dates to new dates
        $dateMapping = array_combine($this->dates, $shuffledDates);
        
        // Update menu items with shuffled dates
        foreach ($this->menuItems as &$menuItem) {
            $menuItem['day'] = $dateMapping[$menuItem['day']];
            $this->dispatch('log', $menuItem);
        }

        // Dispatch log event if needed
        $this->shuffled = true;
    }

    public function reverseShuffleChanges()
    {
        $this->shuffled = false;
        $this->getMenuItems();
    }

    public function saveShuffleChanges()
    {
        $this->dispatch('log', $this->menuItems);

        // Save shuffled menu items
        foreach ($this->menuItems as $menuItem) {
            MenuItem::where('id', $menuItem['id'])->update(['day' => $menuItem['day']]);
        }
        
        $this->shuffled = false;
        $this->getMenuItems();
    }
}
