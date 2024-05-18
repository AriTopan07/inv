<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionGroup extends Model
{
    use HasFactory;

    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
