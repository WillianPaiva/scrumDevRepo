<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Backlog extends Model
{
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function UserStorys()
    {
        return $this->hasMany('App\UserStory');
    }
    //
}
