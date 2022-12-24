<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $table = 'system_deposit';
    protected $fillable = [
        'deposit_member',
        'deposit_money',
        'deposit_bank',
        'deposit_slip',
        'deposit_detail',
        'deposit_status',
        'deposit_create',
    ];
}
