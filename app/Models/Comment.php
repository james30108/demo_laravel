<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'system_comment';
    protected $fillable = [
        'comment_direct',
        'comment_person_id',
        'comment_person_type',
        'comment_type',
        'comment_link',
        'comment_status',
        'comment_title',
        'comment_detail',
        'comment_image_cover',
    ];
}
