<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'system_member';
    protected $fillable = [
        'member_id',
        'member_title_name',
        'member_code',
        'member_tel',
        'member_bank',
        'member_bank_own',
        'member_bank_id',
        'member_class',
        'member_code_id',
        'member_token_line',
        'member_status',
        'member_point',
        'member_point_month',
        'member_e_wallet',
        'member_image_cover',
        'member_image_card',
        'member_image_bank',
        'member_lang'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }
}
