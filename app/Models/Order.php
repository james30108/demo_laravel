<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'system_order';
    protected $fillable = [
        'order_code',
        'order_person_id',
        'order_person_type',
        'order_price',
        'order_point',
        'order_quantity',
        'order_name',
        'order_tel',
        'order_address',
        'order_district',
        'order_amphur',
        'order_province',
        'order_zipcode',
        'order_track_name',
        'order_track_id',
        'order_detail',
        'order_freight',
        'order_status',
        'order_type',
        'order_pay_type',
        'order_cut_report',
        'order_cut',
        'order_etc',
        'order_etc2',
    ];

    // join to pay refer
    public function payRefer()
    {
        return $this->hasOne(PayRefer::class, "pay_order");
    }
}
