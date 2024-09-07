<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeImage extends Model
{
    use HasFactory;
    protected $guarded = ['recipe_image_id'];
    protected $table = 'recipe_image';
    protected $primaryKey = 'recipe_image_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'image_filename',
        'image_cover',
        'recipe_id'
    ];
    public $timestamps = false;
}
