<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    use HasFactory;

    protected $table = 'system_login';
    protected $fillable = [
        'login_person_id',
        'login_person_type',
        'login_ip',
        'login_detail',
    ];
}
