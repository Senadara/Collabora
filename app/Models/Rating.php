<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $table = 'ratings';

    protected $primaryKey = 'id';

    protected $fillable = [
        'star',
        'feedback',
        'account_id',
        'event_id'
    ];

    // app/Models/Rating.php
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
