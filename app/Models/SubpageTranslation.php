<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubpageTranslation extends Model
{
    use HasFactory;
    protected $guarded = ['sub_pages_translation_id'];
    protected $table = 'sub_pages_translation';
    protected $primaryKey = 'sub_pages_translation_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'sub_pages_id', 'language_code', 'sub_pages_title', 'sub_pages_description', 'sub_pages_slug'
    ];
    public $timestamps = false;
}
