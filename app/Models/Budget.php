<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'budget', 'mail_when_completely_spent', 'mail_when_partially_spent', 'banking_record_id'];

    public function store(Request $request)
    {
        // Convert checkbox values to boolean
        $completelySpent = $request->input('completely') === 'on';
        $partiallySpent = $request->input('partially') === 'on';

    }

}
