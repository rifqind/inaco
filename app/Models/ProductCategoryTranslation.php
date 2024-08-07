<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryTranslation extends Model
{
    use HasFactory;
    protected $guarded = ['category_translation_id'];
    protected $table = 'products_category_translation';
    protected $primaryKey = 'category_translation_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'category_id', 'language_code', 'category_title', 'category_description', 'segment_id', 'category_slug'
    ];
    public $timestamps = false;
}
