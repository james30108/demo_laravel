<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $table = 'system_transfer';
    protected $fillable = [
        'transfer_from',
        'transfer_to',
        'transfer_money',
        'transfer_status',
    ];

    // join from member
    public function memberFrom()
    {
        return $this->belongsTo(Member::class, "transfer_from");
    }

    // join from member
    public function memberTo()
    {
        return $this->belongsTo(Member::class, "transfer_to");
    }
}
