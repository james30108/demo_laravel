<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'system_report';
    protected $fillable = [
        'report_point',
        'report_count',
        'report_round',
        'report_type',
    ];
}
