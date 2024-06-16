<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'date',
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

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = floatval(str_replace(',', '.', $value));
    }

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
        return $this->belongsTo(Category::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }
}
