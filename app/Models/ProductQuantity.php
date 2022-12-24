<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductQuantity extends Model
{
    use HasFactory;

    protected $table = 'system_product_quantity';
    protected $fillable = [
        'product_quantity_main',
        'product_quantity_old',
        'product_quantity_new',
    ];

    // join from product
    public function product()
    {
        return $this->belongsTo(Product::class, "product_quantity_main");

    }
}
