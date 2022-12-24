<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liner2 extends Model
{
    use HasFactory;

    protected $table = 'system_liner2';
    protected $fillable = [
        'liner2_code',
        'liner2_member',
        'liner2_direct',
        'liner2_downline_first',
        'liner2_downline_all',
        'liner2_type',
        'liner2_class',
        'liner2_status',
        'liner2_point',
        'liner2_etc',
        'liner2_etc2',
    ];

    // join from member_system
    public function member()
    {
        return $this->belongsTo(Member::class, 'liner_member2', 'id');
    }
}
