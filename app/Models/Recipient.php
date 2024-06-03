<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsToMany(User::class, 'recipient_user', 'recipient_id', 'user_id');
    }
}
