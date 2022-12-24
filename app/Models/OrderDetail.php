<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'system_order_detail';
    protected $fillable = [
        'order_detail_main',
        'order_detail_product',
        'order_detail_quantity',
        'order_detail_price',
        'order_detail_point',
        'order_detail_freight',
        'order_detail_review',
        'order_detail_etc',
        'order_detail_etc2',
    ];
}
