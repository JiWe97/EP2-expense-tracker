<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'amount',
        'category_id',
        'user_id',
        'description',
        'type',
        'valuta',
        'exchange_rate',
        'warranty',
        'warranty_date',
        'banking_record_id',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['created_at', 'updated_at', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bankingRecord()
    {
        return $this->belongsTo(BankingRecord::class);
    }
    public function category()
    {
        return $this->belongsto(Category::class);
    }

}
