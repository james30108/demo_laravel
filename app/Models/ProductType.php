<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $table = 'system_product_type';
    protected $fillable = [
        'product_type_code',
        'product_type_name',
        'product_type_detail',
        'product_type_status',
    ];

    // join to product
    public function product()
    {
        return $this->hasMany(Product::class, "product_type");
    }
}
