<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'system_cart';
    protected $fillable = [
        'cart_person_id',
        'cart_person_type',
        'cart_product_id',
        'cart_product_quantity',
    ];

    // join from product type
    public function product()
    {
        return $this->belongsTo(Product::class, "cart_product_id");
    }
}
