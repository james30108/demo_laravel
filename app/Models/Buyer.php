<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Buyer extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    protected $table = 'system_buyer';
    protected $fillable = [
        'buyer_direct',
        'buyer_name',
        'buyer_tel',
        'buyer_email',
        'password',
        'buyer_address',
        'buyer_district',
        'buyer_amphure',
        'buyer_zipcode',
        'buyer_lang',
    ];
    protected $hidden = [
        'password',
    ];
}
