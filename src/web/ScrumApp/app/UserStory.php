<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStory extends Model
{
    //
    public function project()
    {
        return $this->belongsTo('App\Project');
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
