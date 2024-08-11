<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use HasFactory;
    protected $guarded = ['products_translation_id'];
    protected $table = 'products_translation';
    protected $primaryKey = 'products_translation_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'product_id', 'language_code', 'product_title', 'product_description', 'product_slug'
    ];
    public $timestamps = false;
}
