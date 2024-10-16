<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuNavigationTranslation extends Model
{
    use HasFactory;
    protected $guarded = ['menu_translation_id'];
    protected $table = 'menu_navigation_translation';
    protected $primaryKey = 'menu_translation_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'menu_id', 'language_code', 'menu_title', 'menu_web_url', 'menu_cms_url'
    ];
    public $timestamps = false;
}
