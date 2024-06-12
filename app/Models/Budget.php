<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'amount', 'mail_when_completely_spent', 'mail_when_partially_spent', 'banking_record_id'];
    protected $casts = [
        'last_partially_spent_notification' => 'datetime',
        'last_completely_spent_notification' => 'datetime',
    ];

    public function store(Request $request)
    {
        $completelySpent = $request->input('completely') === 'on';
        $partiallySpent = $request->input('partially') === 'on';

    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'budget_category', 'budget_id', 'category_id');
    }

    public function bankingRecord()
    {
        return $this->belongsTo(BankingRecord::class);
    }



}
