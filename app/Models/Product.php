<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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
        'product_status',
        'product_etc',
        'product_etc2',
        'product_image_cover',
        'product_image_1',
        'product_image_2',
        'product_image_3',
        'product_image_4',
        'product_image_5',
    ];

    // join to product quantity
    public function productQuantity()
    {
        return $this->hasMany(ProductQuantity::class, "product_quantity_main");
    }

    // join to cart
    public function cart()
    {
        return $this->hasMany(Cart::class, "cart_product_id");
    }

    // join from product type
    public function productType()
    {
        return $this->belongsTo(ProductType::class, "product_type");
    }
}
