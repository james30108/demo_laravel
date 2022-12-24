<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'system_contact';
    protected $fillable = [
        'contact_direct',
        'contact_person_id',
        'contact_person_type',
        'contact_status',
        'contact_name',
        'contact_email',
        'contact_title',
        'contact_detail',
    ];
}
