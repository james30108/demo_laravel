<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liner3 extends Model
{
    use HasFactory;

    protected $table = 'system_liner3';
    protected $fillable = [
        'liner3_code',
        'liner3_member',
        'liner3_direct',
        'liner3_downline_first',
        'liner3_downline_all',
        'liner3_type',
        'liner3_class',
        'liner3_status',
        'liner3_point',
        'liner3_etc',
        'liner3_etc2',
    ];

    // join from member_system
    public function member()
    {
        return $this->belongsTo(Member::class, 'liner_member3', 'id');
    }
}
