<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayRefer extends Model
{
    use HasFactory;

    protected $table = 'system_pay_refer';
    protected $fillable = [
        'pay_title',
        'pay_person_id',
        'pay_person_type',
        'pay_name',
        'pay_order',
        'pay_bank',
        'pay_type',
        'pay_status',
        'pay_money',
        'pay_slip',
        'pay_detail',
        'pay_create',
    ];

    // join from product type
    public function order()
    {
        return $this->belongsTo(Order::class, "pay_order");
    }
}
