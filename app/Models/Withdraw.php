<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;

    protected $table = 'system_withdraw';
    protected $fillable = [
        'withdraw_member',
        'withdraw_bank',
        'withdraw_bank_own',
        'withdraw_bank_id',
        'withdraw_point',
        'withdraw_full_point',
        'withdraw_status',
        'withdraw_cut',
    ];
}
