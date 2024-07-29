<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuNavigation extends Model
{
    use HasFactory;
    protected $guarded = ['menu_id'];
    protected $table = 'menu_navigation';
    protected $primaryKey = 'menu_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'parent_menu', 'on_website', 'menu_category', 'icon_on_cms', 'display_sequence'
    ];
    public $timestamps = false;
}
