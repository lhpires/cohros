<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function PhoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class,'contact_id','id');
    }
}
