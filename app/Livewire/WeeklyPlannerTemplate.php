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
    public $templates;
    public $selectedTemplate;
    public $options = [];

    public function render()
    {
        return view('livewire.weekly-planner-template');
    }

    public function mount($selectedTemplate = null)
    {
        $this->templates = MenuTemplate::where('user_id', Auth::user()->id)->get();
        $this->selectedTemplate = MenuTemplate::where('user_id', Auth::user()->id)->first();

        foreach ($this->templates as $template) {
            $this->options[] = [
                'title' => $template['title'], // Assuming 'title' is the field you want to display as the option label
                'id' => $template['id'],
            ];
        }
    }

    public function selectTemplate($templateId)
    {
        $this->selectedTemplate = MenuTemplate::find($templateId);
    }
}
