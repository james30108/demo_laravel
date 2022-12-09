<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'system_product';
    protected $fillable = [
        'product_type',
        'product_type2',
        'product_name',
        'product_code',
        'product_detail',
        'product_price',
        'product_price_member',
        'product_point',
        'product_freight',
        'product_weight',
        'product_quantity',
        'product_unit',
        'product_group',
        'product_etc',
        'product_etc2',
        'product_image_cover',
        'product_image_1',
        'product_image_2',
        'product_image_3',
        'product_image_4',
        'product_image_5',
    ];
}
