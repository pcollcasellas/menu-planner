<?php

namespace App\Livewire\Forms;

use App\Models\MenuTemplate;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class MenuTemplateForm extends Form
{
    public ?MenuTemplate $menuTemplate = null;

    public $title;
    public $user_id;

    public function setMenuTemplate(?MenuTemplate $menuTemplate = null)
    {
        $this->menuTemplate = $menuTemplate;
        $this->title = $menuTemplate->title;
        $this->user_id = $menuTemplate->user_id;
    }

    public function save()
    {
        $this->user_id = Auth::user()->id;
        $this->validate();

        if (!$this->menuTemplate) {
            MenuTemplate::create($this->only(['user_id', 'title']));
        } else {
            $this->menuTemplate->update($this->only(['user_id', 'title']));
        }
        $this->reset();
    }

    public function rules()
    {
        return [
            'title' => ['required'],
        ];
    }
}
