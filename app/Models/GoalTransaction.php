<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'amount',
        'type',
    ];

    /**
     * Get the goal that owns the transaction.
     */
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}
