<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $guarded = ['pages_id'];
    protected $table = 'pages';
    protected $primaryKey = 'pages_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'create_date', 'pages_image', 'pages_status'
    ];
    public $timestamps = false;
}
