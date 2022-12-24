<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'system_address';
    protected $fillable = [
        'address_person_id',
        'address_person_type',
        'address_detail',
        'address_district',
        'address_amphure',
        'address_zipcode',
        'address_type',
    ];

    // join from users
    public function member()
    {
        return $this->belongsTo(Member::class, "address_person_id");
    }
}
