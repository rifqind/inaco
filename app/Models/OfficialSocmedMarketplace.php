<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialSocmedMarketplace extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'official_socmed_marketplace';
    protected $fillable = [
        'instagram', 'facebook', 'tiktok', 'youtube', 'twitter', 'shopee', 'tokopedia', 'lazada', 'tiktokshop'
    ];
    public $timestamps = false;
}
