<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = ['name', 'channel_master_id', 'numbers_of_member', 'link', 'vote_next'];

    protected $primaryKey = 'name';

    public $incrementing = false;

    protected $casts = [
        'link' => 'array',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
