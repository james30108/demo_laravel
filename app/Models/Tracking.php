<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    protected $table = 'system_tracking';
    protected $fillable = [
        'tracking_name',
        'tracking_link',
        'tracking_weight',
        'tracking_price',
        'tracking_max_weight',
        'tracking_max_price',
        'tracking_detail',
        'tracking_status',
    ];
}
