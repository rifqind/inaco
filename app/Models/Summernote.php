<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Summernote extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'summernote';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'pages_id',
        'file_name'
    ];
    public $timestamps = false;
}
