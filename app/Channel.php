<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateInterval;

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

    function covtime($ytDuration) {

        $di = new DateInterval($ytDuration);
        $string = '';
    
        if ($di->h > 0) {
          $string .= $di->h.':';
        }
    
        return $string.$di->i.':'.$di->s;
    }
}
