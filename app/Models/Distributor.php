<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;
    protected $guarded = ['distributor_id'];
    protected $table = 'distributor';
    protected $primaryKey = 'distributor_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'country',
        'province',
        'city',
        'district',
        'subdistrict',
        'distributor_name',
        'address',
        'phone',
        'latitude',
        'longitude',
        'distributor_type'
    ];
    public $timestamps = false;
}
