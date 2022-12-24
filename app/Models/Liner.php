<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liner extends Model
{
    use HasFactory;

    protected $table = 'system_liner';
    protected $fillable = [
        'liner_member',
        'liner_direct',
        'liner_count',
        'liner_count_day',
        'liner_count_month',
        'liner_status',
        'liner_type',
        'liner_withdraw_count',
        'liner_point',
        'liner_etc',
        'liner_etc2',
        'liner_expire',
    ];

    // join from member_system
    public function member()
    {
        return $this->belongsTo(Member::class, "liner_member");
    }
}
