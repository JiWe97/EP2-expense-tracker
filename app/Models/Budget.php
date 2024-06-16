<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'mail_when_completely_spent',
        'mail_when_partially_spent',
        'banking_record_id',
    ];

    protected $casts = [
        'last_partially_spent_notification' => 'datetime',
        'last_completely_spent_notification' => 'datetime',
    ];

    /**
     * The categories that belong to the budget.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'budget_category', 'budget_id', 'category_id');
    }

    /**
     * Get the banking record associated with the budget.
     */
    public function bankingRecord()
    {
        return $this->belongsTo(BankingRecord::class);
    }

    /**
     * Get the transactions for the budget.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Prepare validated data for storing/updating budget.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected static function prepareValidatedData(Request $request)
    {
        $validatedData = $request->validated();
        $validatedData['banking_record_id'] = $request->input('banking_record_id');
        $validatedData['mail_when_completely_spent'] = $request->input('completely');
        $validatedData['mail_when_partially_spent'] = $request->input('partially');

        return $validatedData;
    }

    /**
     * Validate and create a new budget.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\Budget
     */
    public static function validateAndCreate(Request $request)
    {
        $validatedData = self::prepareValidatedData($request);
        $budget = self::create($validatedData);

        if ($request->has('category_id')) {
            $budget->categories()->attach($request->input('category_id'));
        }

        return $budget;
    }

    /**
     * Update budget and sync categories.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function updateAndSyncCategories(Request $request)
    {
        $validatedData = self::prepareValidatedData($request);
        $this->update($validatedData);

        if ($request->has('category_id')) {
            $this->categories()->sync($request->input('category_id'));
        }
    }
}
