<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $guarded = ['product_image_id'];
    protected $table = 'products_image';
    protected $primaryKey = 'product_image_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'image_filename', 'image_cover',
        'product_id'
    ];
    public $timestamps = false;
}
