<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankingRecord extends Model
{
    use HasFactory;

    // Define attributes that can be mass assigned
    protected $fillable = [
        'user_id',
        'name',
        'bank_name',
        'balance',
        'account_number',
    ];

    // Define a relationship with Transaction model
    // A banking record has many transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'banking_record_id');
    }


    // Define a relationship with User model
    // A banking record belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
