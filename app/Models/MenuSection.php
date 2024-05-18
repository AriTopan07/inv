<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuSection extends Model
{
    use HasFactory;

    protected $fillable = ['name_section', 'order', 'icons', 'status'];
    protected $table = 'menu_sections';

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
