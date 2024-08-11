<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeTranslation extends Model
{
    use HasFactory;
    protected $guarded = ['recipe_translation_id'];
    protected $table = 'recipe_translation';
    protected $primaryKey = 'recipe_translation_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'recipe_id', 'language_code', 'recipe_title', 'recipe_description', 'product_id', 'recipe_slug', 'ingredient'
    ];
    public $timestamps = false;
}
