<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'color',
        'icon',
        'show',
        'is_income',
        'user_id',
        'deleted_at'
    ];

    /**
     * Toggle the show attribute.
     *
     * @return $this
     */
    public function toggleShow()
    {
        $this->show = !$this->show;
        $this->save();

        return $this;
    }

    /**
     * Get the user that owns the category.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The budgets that belong to the category.
     */
    public function budget()
    {
        return $this->belongsToMany(Budget::class, 'budget_categories', 'category_id', 'budget_id');
    }

    /**
     * Get the transactions for the category.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Scope a query to only include visible categories for the authenticated user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisibleToUser($query)
    {
        return $query->where('show', true)
            ->where('is_income', false)
            ->where('user_id', Auth::id());
    }
}
