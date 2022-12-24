<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'system_bank';
    protected $fillable = [
        'bank_code',
        'bank_acr',
        'bank_name_th',
        'bank_name_eng',
    ];
}
