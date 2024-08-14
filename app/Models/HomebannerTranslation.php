<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomebannerTranslation extends Model
{
    use HasFactory;
    protected $guarded = ['banner_translation_id'];
    protected $table = 'homebanner_translation';
    protected $primaryKey = 'banner_translation_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'banner_id',
        'language_code',
        'banner_caption',
        'banner_url'
    ];
    public $timestamps = false;
}
