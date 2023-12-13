<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class WeeklyPlanner extends Component
{
    public $startOfWeek;
    public $endOfWeek;
    public $dates = [];
    public $selectedDate;

    public function mount($selectedDate = null)
    {
        // Use the selected date or default to the current week
        $this->selectedDate = $selectedDate ? Carbon::parse($selectedDate) : Carbon::now();
        $this->startOfWeek = $this->selectedDate->copy()->startOfWeek();
        $this->endOfWeek = $this->selectedDate->copy()->endOfWeek();
        // Generate an array of dates for the week
        $currentDate = $this->startOfWeek->copy();
        while ($currentDate->lte($this->endOfWeek)) {
            $this->dates[] = $currentDate->toDateString();
            $currentDate->addDay();
        }
        $this->selectedDate = $this->selectedDate->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.weekly-planner');
    }

    public function changeDate()
    {
        // Re-generate dates for the week when the selected date changes
        $this->startOfWeek = Carbon::parse($this->selectedDate)->startOfWeek();
        $this->endOfWeek = $this->startOfWeek->copy()->endOfWeek();

        $this->dates = [];
        $currentDate = $this->startOfWeek->copy();
        while ($currentDate->lte($this->endOfWeek)) {
            $this->dates[] = $currentDate->toDateString();
            $currentDate->addDay();
        }
    }
}
