<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use SoftDeletes;
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
