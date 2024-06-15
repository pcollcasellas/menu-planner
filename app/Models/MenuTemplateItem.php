<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuTemplateItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function menu_template()
    {
        return $this->belongsTo(MenuTemplate::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
