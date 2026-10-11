<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    //protected $fillable = [];
    protected $guarded = [];  

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function campings()
    {
        return $this->hasMany(Camping::class, 'created_by', 'id');
    }

    public function spinners()
    {
        return $this->hasMany(Spinner::class, 'created_by', 'id');
    }

    public function expiredCampings()
    {
        return $this->hasMany(Camping::class, 'created_by', 'id')->whereDate('end_date', '<', date('Y-m-d'));
    }
}
