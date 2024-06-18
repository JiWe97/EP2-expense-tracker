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
        'payoff_id',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'date',
    ];

    /**
     * Set the transaction amount.
     *
     * @param mixed $value
     * @return void
     */
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = floatval(str_replace(',', '.', $value));
    }

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the banking record associated with the transaction.
     */
    public function bankingRecord()
    {
        return $this->belongsTo(BankingRecord::class, 'banking_record_id');
    }

    /**
     * Get the category associated with the transaction.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the attachments for the transaction.
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * Scope a query to only include expenses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function payoff()
    {
        return $this->belongsTo(Payoff::class);
    }
}
