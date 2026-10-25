<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'has_ip_skip' => 'boolean',
        'has_whatsapp' => 'boolean',
        'has_custom_branding' => 'boolean',
        'is_popular' => 'boolean',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'plan_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'plan_id');
    }
}
