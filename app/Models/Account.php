<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'user_id',
        'account_id',
        'account_name',
        'account_type',
        'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function send()
    {
        return $this->hasMany(Transaction::class, 'id', 'sender_id');
    }

    public function recive()
    {
        return $this->hasMany(Transaction::class, 'id', 'reciver_id');
    }
}
