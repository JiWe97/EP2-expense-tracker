<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankingRecord extends Model
{
    //use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'balance',
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
