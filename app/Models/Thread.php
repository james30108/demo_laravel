<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $table = 'system_thread';
    protected $fillable = [
        'thread_title',
        'thread_intro',
        'thread_detail',
        'thread_type',
        'thread_highlight',
        'thread_status',
        'thread_image_cover',
        'thread_image_1',
        'thread_image_2',
        'thread_image_3',
        'thread_image_4',
        'thread_image_5',
    ];
}
