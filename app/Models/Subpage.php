<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subpage extends Model
{
    use HasFactory;
    protected $guarded = ['sub_pages_id'];
    protected $table = 'sub_pages';
    protected $primaryKey = 'sub_pages_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'create_date', 'pages_id', 'sub_pages_image', 'sub_pages_status'
    ];
    public $timestamps = false;
}
