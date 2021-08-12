<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'reciver_id',
        'amount',
        'message',
        'sender_balance',
        'reciver_balance',
        'sender_account_id',
        'reciver_account_id'
    ];

    public function sender()
    {
        return $this->belongsTo(Account::class, 'sender_id', 'id');
    }

    public function reciver()
    {
        return $this->belongsTo(Account::class, 'reciver_id', 'id');
    }
}
