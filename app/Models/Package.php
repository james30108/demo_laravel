<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'system_package';
    protected $fillable = [
        'package_main',
        'package_product',
        'package_name',
        'package_quantity',
        'package_point',
        'package_price',
        'package_status',
    ];
}
