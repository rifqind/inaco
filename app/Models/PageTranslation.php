<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model
{
    use HasFactory;
    protected $guarded = ['pages_translation_id'];
    protected $table = 'pages_translation';
    protected $primaryKey = 'pages_translation_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'pages_id', 'language_code', 'pages_title', 'pages_description', 'pages_slug'
    ];
    public $timestamps = false;
}
