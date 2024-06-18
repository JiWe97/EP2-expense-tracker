<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payoff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total',
        'balance',
        'user_id',
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
