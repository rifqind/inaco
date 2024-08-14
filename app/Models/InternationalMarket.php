<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternationalMarket extends Model
{
    use HasFactory;
    protected $guarded = ['market_id'];
    protected $table = 'international_market';
    protected $primaryKey = 'market_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'country',
        'product_export'
    ];
    public $timestamps = false;
}
