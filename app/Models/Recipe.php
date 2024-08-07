<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    protected $guarded = ['recipe_id'];
    protected $table = 'recipe';
    protected $primaryKey = 'recipe_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'create_date', 'recipe_image', 'recipe_status'
    ];
    public $timestamps = false;
}
