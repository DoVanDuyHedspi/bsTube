<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['channel_name', 'user_id', 'content'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    protected $appends = [
        'humanCreatedAt'
    ];

    public function getHumanCreatedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
