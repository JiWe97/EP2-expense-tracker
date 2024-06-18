<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankingRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'bank_name',
        'balance',
        'account_number',
        'balance',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'banking_record_id');
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
