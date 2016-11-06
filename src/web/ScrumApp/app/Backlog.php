<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Backlog extends Model
{

    protected $fillable = ['project_id'];

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
