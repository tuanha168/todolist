<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'phone_number',
        'dob',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
