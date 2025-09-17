<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail

{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'password',
        'company_name',
        'company_address',
        'company_type',
        'is_active',
        'user_level',
        'owner_id',
        'position_id',
        'approve_1',
        'approve_2',
        'email_verified_at',
        'city',
        'leader_name'
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function rposition():BelongsTo
    {
        return $this->belongsTo(UserPosition::class, 'position_id', 'id');
    }

    public function rlevel():BelongsTo
    {
        return $this->belongsTo(UserLevel::class, 'user_level', 'id');
    }

}
