<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    protected $table = "phone_numbers";

    public function contact()
    {
        return $this->belongsTo(Contact::class,'contact_id','id');
    }

    public function number() : Attribute
    {
        return new Attribute(
            get: fn($number) => preg_replace("/^(\d{2})(\d{5})(\d{4})$/", "($1) $2-$3", $number),
            set: fn($number) => preg_replace("/[^0-9]/", "", $number)
        );
    }
}
