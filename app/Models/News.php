<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $guarded = ['news_id'];
    protected $table = 'news';
    protected $primaryKey = 'news_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'news_category', 'create_date', 'news_image', 'news_status'
    ];
    public $timestamps = false;
}
