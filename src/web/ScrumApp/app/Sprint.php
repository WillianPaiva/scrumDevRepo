<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    public function UserStorys()
    {
        return $this->hasMany('App\UserStory');
    }
    public function Collunms()
    {
        return $this->hasMany('App\Layout');
    }
}
