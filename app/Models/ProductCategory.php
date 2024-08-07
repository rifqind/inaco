<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $guarded = ['category_id'];
    protected $table = 'products_category';
    protected $primaryKey = 'category_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'create_date', 'category_image', 'category_status'
    ];
    public $timestamps = false;
}
