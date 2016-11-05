<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStory extends Model
{
    //
    public function backlog()
    {
        return $this->belongsTo('App\Backlog');
    }
    public function sprint()
    {
        return $this->belongsTo('App\Sprint');
    }
    public function Tasks()
    {
        return $this->hasMany('App\Task');
    }
}
