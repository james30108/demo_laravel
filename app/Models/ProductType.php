<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'system_product_type';
    protected $fillable = [
        'product_type_code',
        'product_type_name',
        'product_type_detail',
    ];
}
