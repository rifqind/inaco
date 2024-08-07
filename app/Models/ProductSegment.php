<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSegment extends Model
{
    use HasFactory;
    protected $guarded = ['segment_id'];
    protected $table = 'product_segment';
    protected $primaryKey = 'segment_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'segment_name', 'segment_description'
    ];
    public $timestamps = false;
}
