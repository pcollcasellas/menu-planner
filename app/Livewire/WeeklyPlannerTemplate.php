<?php

namespace App\Livewire;

use App\Models\MenuTemplate;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class WeeklyPlannerTemplate extends Component
{
    public $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    public $templates;
    public $selectedTemplateId;
    public $templateTitle='';


    protected $listeners = ['refresh-templates' => 'refresh'];

    public function refresh()
    {
        $this->templates = MenuTemplate::where('user_id', Auth::id())->get();
    }


    public function render()
    {
        return view('livewire.weekly-planner-template');
    }


    public function mount()
    {
        $this->templates = MenuTemplate::where('user_id', Auth::user()->id)->get();
        $this->selectedTemplateId = MenuTemplate::where('user_id', Auth::user()->id)->first()->id;
    }

    public function saveTitle()
    {
        $template = MenuTemplate::find($this->selectedTemplateId);
        $template->title = $this->templateTitle;
        $template->save();
        $this->templates = MenuTemplate::where('user_id', Auth::user()->id)->first()->id; // Refresh templates
    }

    public function startEditTitle()
    {
        $this->templateTitle = $this->templates->find($this->selectedTemplateId)->title;
    }

    public function deleteTemplate()
}
