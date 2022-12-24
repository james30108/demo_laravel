<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $table = 'system_commission';
    protected $fillable = [
        'commission_name',
        'commission_point',
        'commission_point2',
    ];
}
