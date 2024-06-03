<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    //id, amount, category_id, user_id, description, type, valuta, recipient_id, 
    //exchange_rate, warranty, warranty_date, status, due_before, banking_record_id, created_at, updated_at
    protected $fillable = [
        'amount',
        'category_id',
        'user_id', // Assuming you want users to be associated with transactions
        'description', // Optional, if you want users to add descriptions
        'type', // Optional, if you have different transaction types
        'valuta', // Optional, if you need to store currency information
        'recipient_id', // Optional, if transactions involve recipients
        'exchange_rate', // Optional, if you deal with foreign currency conversions
        'warranty', // Optional, if transactions involve warranties
        'warranty_date', // Optional, if warranties have expiration dates
        'status', // Optional, if you have different transaction statuses
        'due_before', // Optional, if transactions have due dates
        // 'banking_record_id', // Not recommended for mass assignment (consider separate logic)
    ];

    
}
