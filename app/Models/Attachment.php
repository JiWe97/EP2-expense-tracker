<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'picture', 'transaction_id'
    ]

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
