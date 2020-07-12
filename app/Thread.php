<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = [
        'user_id',
        'channel_id',
        'title',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }
}
