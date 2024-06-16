<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profilepicture',
        'darkmode',
        'birthdate',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the recipients associated with the user.
     */
    public function recipient()
    {
        return $this->belongsToMany(Recipient::class, 'recipient_user', 'recipient_id', 'user_id');
    }

    /**
     * Get the categories associated with the user.
     */
    public function category()
    {
        return $this->belongsToMany(Category::class, 'category_user', 'category_id', 'user_id');
    }

    /**
     * Get the banking records for the user.
     */
    public function bankingRecords()
    {
        return $this->hasMany(BankingRecord::class);
    }

    /**
     * Get the transactions for the user.
     */
    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
