<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    protected $table = 'system_point';
    protected $fillable = [
        'point_member',
        'point_order',
        'point_type',
        'point_bonus',
        'point_status',
        'point_detail',
    ];
}
