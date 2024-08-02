<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppLanguage extends Model
{
    use HasFactory;
    protected $table = 'app_language';
    protected $timestamp = false;
    protected $fillable = ['code', 'name', 'icon_image'];
    public $timestamps = false;
}
