<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportDetail extends Model
{
    use HasFactory;

    protected $table = 'system_report_detail';
    protected $fillable = [
        'report_detail_main',
        'report_detail_link',
        'report_detail_point',
    ];
}
