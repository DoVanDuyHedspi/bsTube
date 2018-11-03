<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable =  ['body'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected $appends = [
        'humanCreatedAt'
    ];

    public function getHumanCreatedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
