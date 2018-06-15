<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    //
    protected $fillable = [

        'post_id',
        'photo',
        'owner',
        'like'

    ];

    public function post() {

        return $this->belongsTo('App\Post');
    }
}
