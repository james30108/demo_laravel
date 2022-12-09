<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $table = 'system_config';
    protected $fillable = [
        'config_type',
        'config_name',
        'config_value'
    ];
}
