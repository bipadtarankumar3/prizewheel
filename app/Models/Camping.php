<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camping extends Model
{
    use HasFactory;
    protected $guarded = [];  

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function spinners()
    {
        return $this->hasMany(Spinner::class, 'camping_id');
    }

    public function spinnerForms()
    {
        return $this->hasMany(SpinnerForm::class, 'camping_id');
    }
}
