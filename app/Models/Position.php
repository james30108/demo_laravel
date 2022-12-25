<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = 'system_position';
    protected $fillable = [
        'position_name',
        'position_image',
        'position_match_level',
        'position_point',
    ];
}
