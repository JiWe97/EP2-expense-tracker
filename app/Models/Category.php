<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'color', 'icon', 'show', 'is_income', 'user_id', 'deleted_at'];

    public function toggleShow()
    {
        $this->show =!$this->show;
        $this->save();

        return $this;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function budget()
    {
        return $this->belongsToMany(Budget::class, 'budget_categories', 'category_id', 'budget_id');
    }
    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
