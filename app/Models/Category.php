<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'color', 'icon'];

    public function toggleShow()
    {
        $this->show =!$this->show;
        $this->save();

        return $this;
    }

    public function budget()
    {
        return $this->belongsToMany(Budget::class, 'budget_categories', 'category_id', 'budget_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'category_user', 'category_id', 'user_id');
    }
}
