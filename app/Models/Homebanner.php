<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homebanner extends Model
{
    use HasFactory;
    protected $guarded = ['banner_id'];
    protected $table = 'homebanner';
    protected $primaryKey = 'banner_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'banner_name',
        'banner_image',
        'banner_status'
    ];
    public $timestamps = false;
}
