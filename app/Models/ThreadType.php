<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreadType extends Model
{
    use HasFactory;

    protected $table = 'system_thread_type';
    protected $fillable = [
        'thread_type_name',
        'thread_type_count',
    ];
}
