<?php

namespace App\Livewire;

use App\Models\MenuTemplate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WeeklyPlannerTemplate extends Component
{
    public $startOfWeek;
    public $endOfWeek;
    public $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    public $selectedTemplate;

    public function render()
    {
        return view('livewire.weekly-planner-template');
    }

    public function mount($selectedTemplate = null)
    {

        $this->selectedTemplate = MenuTemplate::where('user_id', Auth::user()->id)->first();
    }
}
