<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    protected $appends = ['avatar'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function chats() {
        return $this->hasMany(Chat::class);
    }

    public function channels() {
        return $this->hasMany('App\Channel', 'channel_master_id');
    }

    public function getAvatar() {
        return 'https://gravatar.com/avatar/'.md5($this->email).'/?s=45&d=mm';
    }

    public function getAvatarAttribute() {
        return $this->getAvatar();
    }

    public function getRouteKeyName() {
        return 'username';
    }

    public function isNotTheUser(User $user) {
        return $this->id !== $user->id;
    }

    public function isFollowing(User $user) {
        return (bool) $this->following->where('id', $user->id)->count();
    }

    public function canFollow(User $user) {
        if(!$this->isNotTheUser($user)) {
            return false;
        }
        return !$this->isFollowing($user);
    }

    public function canUnfollow(User $user) {
        return $this->isFollowing($user);
    }

    public function following() {
        return $this->belongsToMany('App\User', 'follows', 'user_id', 'follower_id');
    }

    public function followers() {
        return $this->belongsToMany('App\User', 'follows', 'follower_id', 'user_id');
    }
}