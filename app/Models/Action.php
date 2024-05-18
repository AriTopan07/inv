<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    public function masterAction()
    {
        return $this->belongsTo(MasterAction::class, 'master_action_id');
    }

    public function actionGroups()
    {
        return $this->belongsToMany(ActionGroup::class, 'action_groups', 'action_id', 'group_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
