<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name_menu', 'section_id', 'url', 'icons', 'order', 'status', 'parent_id'];
    protected $table = 'menus';

    public function section()
    {
        return $this->belongsTo(MenuSection::class);
    }

    public function actions()
    {
        return $this->hasMany(Action::class, 'menu_id');
    }

    public function actionGroups()
    {
        return $this->hasMany(ActionGroup::class, 'action_id');
    }
}
