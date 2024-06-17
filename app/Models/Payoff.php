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
        'balance'
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

}
