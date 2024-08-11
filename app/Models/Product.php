<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['product_id'];
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'create_date', 'category_id',
        'product_url_tokopedia',
        'product_url_shopee',
        'product_url_lazada',
        'product_url_tiktokshop',
        'show_on_home',
        'display_sequence_onhome', 'product_status'
    ];
    public $timestamps = false;
}
