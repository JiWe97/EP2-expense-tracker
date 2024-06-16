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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'budget_category', 'budget_id', 'category_id');
    }

    public function bankingRecord()
    {
        return $this->belongsTo(BankingRecord::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    protected static function prepareValidatedData(Request $request)
    {
        $validatedData = $request->validated();
        $validatedData['banking_record_id'] = $request->input('banking_record_id');
        $validatedData['mail_when_completely_spent'] = $request->input('completely');
        $validatedData['mail_when_partially_spent'] = $request->input('partially');
        return $validatedData;
    }

    public static function validateAndCreate(Request $request)
    {
        $validatedData = self::prepareValidatedData($request);

        $budget = self::create($validatedData);

        if ($request->has('category_id')) {
            $budget->categories()->attach($request->input('category_id'));
        }

        return $budget;
    }

    public function updateAndSyncCategories(Request $request)
    {
        $validatedData = self::prepareValidatedData($request);

        $this->update($validatedData);

        if ($request->has('category_id')) {
            $this->categories()->sync($request->input('category_id'));
        }
    }
}
