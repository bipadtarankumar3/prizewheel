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
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'default_spinn' => '2',
    ];  

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

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function subUsers()
    {
        return $this->hasMany(User::class, 'admin_id');
    }

    public function plans()
    {
        return $this->hasMany(Plan::class, 'admin_id');
    }

    public function paymentsReceived()
    {
        return $this->hasMany(Payment::class, 'admin_id');
    }

    public function paymentsMade()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    /**
     * Check if user account subscription is expired
     */
    public function isExpired()
    {
        if ($this->type === 'admin') {
            return false;
        }
        if (empty($this->expiry_date)) {
            return true;
        }
        return strtotime($this->expiry_date) < strtotime(date('Y-m-d'));
    }

    /**
     * Days remaining in subscription
     */
    public function daysRemaining()
    {
        if ($this->type === 'admin') {
            return 9999;
        }
        if (empty($this->expiry_date)) {
            return 0;
        }
        $diff = strtotime($this->expiry_date) - strtotime(date('Y-m-d'));
        return max(0, (int)ceil($diff / 86400));
    }
}

