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
        $this->user_id = Auth::id(); // Use the shorthand Auth::id() for getting the authenticated user's ID
        $this->validate();

        $data = $this->only(['user_id', 'title']);

        $menuTemplate = $this->menuTemplate
            ? tap($this->menuTemplate)->update($data)
            : MenuTemplate::create($data);

        $this->reset();
        return $menuTemplate->id;
    }

    public function rules()
    {
        return [
            'title' => ['required'],
        ];
    }
}
