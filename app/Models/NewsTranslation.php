<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTranslation extends Model
{
    use HasFactory;
    protected $guarded = ['news_translation_id'];
    protected $table = 'news_translation';
    protected $primaryKey = 'news_translation_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'news_id',
        'language_code',
        'news_title',
        'news_description',
        'news_slug',
        'count_views'
    ];
    public $timestamps = false;
}
