<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryTransaction extends Model
{
    protected $fillable = [
        'otp',
        'sender_id',
        'reciver_id',
        'amount',
        'message',
    ];
}
