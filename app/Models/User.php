<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'account_id',
        'full_name',
        'gender',
        'birth_date',
        'phone_number',
        'address',
        'university',
        'major',
        'semester',
        'instagram_handle',
    ];


    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
