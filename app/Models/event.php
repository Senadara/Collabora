<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = "event";

    public function Account() {
        return $this->belongsTo(Account::class);
    }
    function volunteer()
    {
        return $this->belongsToMany(event::class,'event_regist','event_id')->withPivot('id', 'experience', 'phone')->withTimestamps();
    }

}
