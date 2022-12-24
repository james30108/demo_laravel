<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    protected $table = 'system_member';
    protected $fillable = [
        'member_name',
        'password',
        'member_email',
        'member_title_name',
        'member_code',
        'member_tel',
        'member_bank',
        'member_bank_own',
        'member_bank_id',
        'member_position',
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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // join to liner_system
    public function liner()
    {
        return $this->hasOne(Liner::class, "liner_member");
    }

    // join to address
    public function address()
    {
        return $this->hasMany(Address::class, "address_member");
    }

    // join to transfer from
    public function transferFrom()
    {
        return $this->hasMany(Transfer::class, "transfer_from");
    }

    // join to transfer to
    public function transferTo()
    {
        return $this->hasMany(Transfer::class, "transfer_to");
    }

}
